<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DeptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depts=Department::where('enable', '=', '1')->get();
        //dd($depts);
        return view('admin.dept.index',compact('depts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dept.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $depts = new Department();
            
            $depts->dept = $request->input('dept');
            $depts->save();

            return redirect()->route('admin.dept.index')->with('flash_success', 'Department Save Successfully!');
        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
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
        $dept = Department::findOrFail($id);
        return view('admin.dept.edit',compact('dept'));
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
            'dept' => 'required|max:255'
        ]);

        try{
            $department = Department::findOrFail($id);
            
            $department->dept = $request->input('dept');
            $department->save();

            return redirect()->route('admin.dept.index')->with('flash_success', 'Department Update Successfully!');
        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     Department::find($id)->delete();
    //     return back()->with('message', 'Department deleted successfully');
    // }
}
