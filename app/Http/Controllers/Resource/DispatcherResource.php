<?php

namespace App\Http\Controllers\Resource;

use App\Dispatcher;
use App\DispatcherToZone;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Zones;
use Exception;
use Setting;

class DispatcherResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dispatchers = Dispatcher::orderBy('created_at' , 'desc')->get();
        return view('admin.dispatcher.index', compact('dispatchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones=Zones::all();
        return view('admin.dispatcher.create',compact(['zones']));
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
            'name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
            'email' => 'required|unique:dispatchers,email|email|max:255',
            'password' => 'required|min:6|confirmed',
            'zone' =>'required'
        ]);

        try{

            $Dispatcher = $request->all();
            $Dispatcher['password'] = bcrypt($request->password);

            $Dispatcher = Dispatcher::create($Dispatcher);
            $zones=explode(',',$request->zone);
            foreach($zones as $index=>$zone){
                $zone_id=Zones::where('zone_name',$zone)->pluck('id')->first();
                if($zone_id){
                    if($index==0){
                        DispatcherToZone::where('dispatcher_id',$Dispatcher->id)->delete();
                    }
                    $connDispatch=new DispatcherToZone;
                    $connDispatch->dispatcher_id=$Dispatcher->id;
                    $connDispatch->zone_id=$zone_id;
                    $connDispatch->save();
                }
            }

            return redirect()->route('admin.dispatch-manager.index')->with('flash_success', 'Dispatcher Details Saved Successfully');
        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'Dispatcher Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $dispatcher = Dispatcher::findOrFail($id);
            return view('admin.dispatcher.edit',compact('dispatcher'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
            'zone' =>'required'
        ]);

        try {
            $zones=explode(',',$request->zone);
            foreach($zones as $index=>$zone){
                $zone_id=Zones::where('zone_name',$zone)->pluck('id')->first();
                if($zone_id){
                    if($index==0){
                        DispatcherToZone::where('dispatcher_id',$id)->delete();
                    }
                    $connDispatch=new DispatcherToZone;
                    $connDispatch->dispatcher_id=$id;
                    $connDispatch->zone_id=$zone_id;
                    $connDispatch->save();
                }
            }
            $dispatcher = Dispatcher::findOrFail($id);
            $dispatcher->name = $request->name;
            $dispatcher->mobile = $request->mobile;
            $dispatcher->save();

            return redirect()->route('admin.dispatch-manager.index')->with('flash_success', 'Dispatcher Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Dispatcher Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }
        

        try {
            Dispatcher::find($id)->delete();
            return back()->with('message', 'Dispatcher deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Dispatcher Not Found');
        }
    }
     public function changeDispatcherassword(Request $request)
    {
       
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error','Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request,[
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        try {
            
            $provider = Dispatcher::findOrFail($request->id);
			if( !$provider  ) {
				throw new Exception('Provider Not Found');
			}
            
            if($request->password!="")
            {
                
                $provider->password = bcrypt($request->password);
            }
            $provider->save();

            return redirect()->back()->with('flash_success', 'Dispatcher Password Updated Successfully'); 
           
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }
   
}