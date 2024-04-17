<?php

namespace App\Http\Controllers;

use App\Admin;
use Exception;
use App\NextUserDashboard;
use Illuminate\Http\Request;

class AdminResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins=Admin::all();
        return view('admin.admin.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users=NextUserDashboard::all();
        return view('admin.admin.create',compact('users'));
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
            'email' => 'required|unique:admins,email|email|max:255',
            'password' => 'required|min:6|confirmed',
            'admin_type' => 'required',
        ]);

        try{

            $admin = $request->all();
            $admin['password'] = bcrypt($request->password);
            $admin = Admin::create($admin);


            return redirect()->route('admin.admin.index')->with('flash_success', 'admin Detail Save Successfully');

        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
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
        try{
            $users=NextUserDashboard::all();
            if($id==1){
            return back()->with('flash_error','Admin can not be Edited');
            }

            $admin=Admin::find($id);

            return view('admin.admin.edit',compact(['admin','users']));
        }
        catch(\Exception $e){
            return redirect()->back()->with('flash_error','Something Went Wrong!');
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
        $this->validate($request, [
            'name' => 'required|max:255',
        //    'company_name' => 'required|max:255',
            'email' => 'required|unique:admins,email,'.$id,
        ]);

        try {

            $admin = Admin::findOrFail($id);
            $admin->name = $request->name;
            $admin->admin_type = $request->admin_type;
            if($request->password != ''){
               if($request->password == $request->password_confirmation)
                {
                    $admin->password = bcrypt($request->password);
                }
                else
                {
                    throw new Exception("Password and Confirm Password does not match");
                }
            }
            
          
            $admin->save();

            return redirect()->route('admin.admin.index')->with('flash_success', 'admin Updated Successfully');    
        } 

        catch (Exception $e) {
            return back()->with('flash_error', $e->getmessage());
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
        if($id==1){
            return back()->with('flash_error','Admin can not be deleted');
        }
        try {

            $admin = Admin::findOrFail($id);
            $admin->delete();

            return back()->with('flash_success', 'admin Deleted Successfully');
        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'admin Not Found');
        }
    }
}
