<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ReturnUser;
use App\Department;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Setting;

class ReturnResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returns = ReturnUser::orderBy('created_at' , 'ASC')->get();
        return view('admin.return.index', compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $depts = Department::orderBy('dept')->get();
        return view('admin.return.create');
    }

    //Check mail id "Not to be same"
    public function checkEmail(Request $request){
        try {
            if($request->ajax()){
                if(ReturnUser::where('email','=',$request->input('email'))->exists()){
                    //return "exist";
                    return response()->json([
                        //'message' => "Already Exists",
                        'exist' => true,
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
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
            'email' => 'required|unique:return_users,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try{

            $return = $request->all();
            $return['password'] = bcrypt($request->password);
            $return = ReturnUser::create($return);

            return back()->with('flash_success','ReturnUser Details Saved Successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'ReturnUser Not Found');
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
            $return = ReturnUser::findOrFail($id);
            // $depts = Department::orderBy('dept')->get();

            return view('admin.return.edit',compact('return'));
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

            $return = ReturnUser::findOrFail($id);
            $return->name = $request->name;
            $return->mobile = $request->mobile;
            $return->enable = $request->enable;
            $return->save();

            return redirect()->back()->with('flash_success', 'Return User Updated Successfully!');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Return User Not Found!');
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
            ReturnUser::find($id)->delete();
            return back()->with('message', 'Return User deleted successfully!');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Return User Not Found!');
        }
    }
}
