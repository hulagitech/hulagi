<?php

namespace App\Http\Controllers\Resource;

use App\DispatchBulkList;
use App\Http\Controllers\Controller;
use App\Provider;
use App\RiderLog;
use App\UserRequests;
use App\ZoneDispatchList;
use App\Zones;
use Exception;
use Illuminate\Http\Request;

class ZoneDispatchResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $ktm=Zones::where('zone_name','Kathmandu')->first()->id;
            $requests=UserRequests::where('status','SORTCENTER')
                                ->where(function($query) use ($ktm){
                                    $query->where('zone1','<>',$ktm)
                                        ->orWhere('zone2','<>',$ktm);
                                })
                                ->get();
            return view('admin.zoneDispatch.index', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function view()
    {
        try {
            $requests=DispatchBulkList::where('received',false)->get();
            foreach($requests as $request){
				$request->count=ZoneDispatchList::where("dispatch_id",$request->id)->count();
			}
            return view('admin.zoneDispatch.dispatchList', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDispatch(Request $request)
    {
        try{
            $this->validate($request,[
                'id' => 'required'
            ]);
            $id=$request->id;
            $bulk=DispatchBulkList::findOrFail($id);
            $bulk->remarks=$request->remarks;

            if ($request->hasFile('file')) {

                $this->validate($request,[
                    'file' => 'mimes:jpeg,bmp,png,pdf' // Only allow .jpg, .bmp and .png file types.
                ]);
    
                // Save the file locally in the storage/public/ folder under a new folder named /product
                $request->file->store('dispatch', 'public');
    
                // Store the record, using the new file hashname which will be it's new filename identity.
                $bulk->file_path=$request->file->hashName();
            }
            $bulk->save();
            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $this->validate($request,[
                'id' => 'required'
            ]);
            $id=$request->id;

            //first create a bulk dispatch
            $bulk=new DispatchBulkList;
            $bulk->save();

            //set all to delivering and save to a batch
            foreach($id as $i){
                $zones=ZoneDispatchList::where('request_id',$i)->first();
                if($zones && count($zones)>0){
                    $zones->dispatch_id=$bulk->id;
                    $zones->save();
                }
                else{
                    $dispatch=new ZoneDispatchList;
                    $dispatch->request_id=$i;
                    $dispatch->dispatch_id=$bulk->id;
                    $dispatch->save();
                }   
                $r=UserRequests::findOrFail($i);
                if($r==null){
                    throw new Exception("One or more orders not found in sortcenter");
                }
                $r->status="DELIVERING";
                $r->save();
                $bulk->zone1_id=$r->zone1;
				$bulk->zone2_id=$r->zone2;
            }
            $bulk->save();
            DB::commit();
            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $requests=ZoneDispatchList::where('dispatch_id',$id)->get();
            return view('admin.zoneDispatch.detailDispatch', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
