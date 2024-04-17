<?php

namespace App\Http\Controllers;

use App\SubZone;
use App\Zones;
use Exception;
use Illuminate\Http\Request;

class SubZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones=SubZone::get()->groupBy('main');
        return view('admin.subzone.index',compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subZones=SubZone::pluck('sub')->toArray();
        $mainZones=SubZone::groupBy('main')->pluck('main')->toArray();
        $allZones=Zones::whereNotIn('id',$subZones)->whereNotIn('id',$mainZones)->get();
        return view('admin.subzone.create',compact('allZones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'main' => 'required|exists:zones,id',
            'sub' => 'required',
        ]);

        try{
            $zones=explode(',',$request->sub);
            SubZone::where('main',$request->main)->delete();
            foreach($zones as $index=>$zone){
                $zone_id=Zones::where('zone_name',$zone)->pluck('id')->first();
                $already=SubZone::where('sub',$zone_id)->count();
                if($zone_id && !$already){
                    $newSub=new SubZone;
                    $newSub->main=$request->main;
                    $newSub->sub=$zone_id;
                    $newSub->save();
                }
            }
            //also set the main zone as its own sub
            $already=SubZone::where('sub',$request->main)->count();
            if($already>0){
                $newSub=new SubZone;
                $newSub->main=$request->main;
                $newSub->sub=$request->main;
                $newSub->save();
            }

            return redirect()->route('admin.subzone.index')->with('flash_success', 'New Subzone added');
        }
        catch(Exception $e){
            return redirect()->route('admin.subzone.index')->with('flash_error', $e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subZones=SubZone::where('main','<>',$id)->where('sub','<>',$id)->pluck('sub')->toArray();
        $mainZones=SubZone::where('main','<>',$id)->where('sub','<>',$id)->groupBy('main')->pluck('main')->toArray();
        $allZones=Zones::whereNotIn('id',$subZones)->whereNotIn('id',$mainZones)->get();
        $editZone=SubZone::where('main',$id)->get();
        return view('admin.subzone.edit',compact('allZones','editZone'));
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
        $this->validate($request, [
            'main' => 'required|exists:zones,id',
            'sub' => 'required',
        ]);

        try{
            $zones=explode(',',$request->sub);
            SubZone::where('main',$request->main)->delete();
            foreach($zones as $index=>$zone){
                $zone_id=Zones::where('zone_name',$zone)->pluck('id')->first();
                $already=SubZone::where('sub',$zone_id)->count();
                if($zone_id && !$already){
                    $newSub=new SubZone;
                    $newSub->main=$request->main;
                    $newSub->sub=$zone_id;
                    $newSub->save();
                }
            }
            //also set the main zone as its own sub
            $already=SubZone::where('sub',$request->main)->count();
            if($already>0){
                $newSub=new SubZone;
                $newSub->main=$request->main;
                $newSub->sub=$request->main;
                $newSub->save();
            }

            return redirect()->route('admin.subzone.index')->with('flash_success', 'Subzone edited');
        }
        catch(Exception $e){
            return redirect()->route('admin.subzone.index')->with('flash_error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            SubZone::where('main',$id)->delete();
            return back()->with('message', 'SubZone deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'SubZone Not Found');
        }
    }
}
