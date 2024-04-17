<?php

namespace App\Http\Controllers\Resource;

use Setting;
use App\Model\SortCenterUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SortCenterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sortcenter_users=SortCenterUser::all();
        return view('admin.sortcenter.index',compact('sortcenter_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sortcenter.create');
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
            'email' => 'required|unique:sort_center_users,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try{

            $sortcenter_user = $request->all();
            $sortcenter_user['password'] = bcrypt($request->password);
            $sortcenter_user = SortCenterUser::create($sortcenter_user);

            return back()->with('flash_success','Sortcenter user Details Saved Successfully');
        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'Sortcenter user Not Found');
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
                $sortcenter_user = SortCenterUser::findOrFail($id);
                // $depts = Department::orderBy('dept')->get();
    
                return view('admin.sortcenter.edit',compact('sortcenter_user'));
            } catch (ModelNotFoundException $e) {
                return $e;
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

            $sortcenter_user = SortCenterUser::findOrFail($id);
            $sortcenter_user->name = $request->name;
            $sortcenter_user->mobile = $request->mobile;
            $sortcenter_user->enable = $request->enable;
            $sortcenter_user->save();

            return redirect()->back()->with('flash_success', 'Sort center User Updated Successfully!');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Sort center User Not Found!');
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
            SortCenterUser::find($id)->delete();
            return back()->with('message', 'Sortcenter User deleted successfully!');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Sortcenter User Not Found!');
        }
    }
    
}
