<?php

namespace App\Http\Controllers\Resource;

use App\Model\PickupUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Setting;
class PickupUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pickup_users = PickupUser::all();
        return view('admin.pickupUser.index',compact('pickup_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pickupUser.create');
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
            'email' => 'required|unique:pickup_users,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try{

            $pickup_user = $request->all();
            $pickup_user['password'] = bcrypt($request->password);
            $pickup_user = PickupUser::create($pickup_user);

            return back()->with('flash_success','PickupUser Details Saved Successfully');
        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'PickupUser Not Found');
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
        try {
            $pickup_user = PickupUser::findOrFail($id);
            return view('admin.pickupUser.edit',compact('pickup_user'));

        } catch (\ModelNotFoundException $th) {
            return $th;
        }        
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
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
        ]);

        try {

            $pickup_user = PickupUser::findOrFail($id);
            $pickup_user->name = $request->name;
            $pickup_user->mobile = $request->mobile;
            $pickup_user->enable = $request->enable;
            $pickup_user->save();

            return redirect()->back()->with('flash_success', 'PickUp User Updated Successfully!');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'PickUp User Not Found!');
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
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        try {
            PickupUser::find($id)->delete();
            return back()->with('message', 'Pickup User deleted successfully!');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Pickup User Not Found!');
        }
    }
}
