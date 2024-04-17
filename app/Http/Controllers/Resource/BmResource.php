<?php

namespace App\Http\Controllers\Resource;

use Setting;
use Exception;

use App\Department;
use App\Dispatcher;
use App\BranchManager;
use App\ManagerToDispatcher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BmResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bms = BranchManager::orderBy('created_at' , 'ASC')->get();
        return view('admin.bm.index', compact('bms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dispatchers = Dispatcher::all();
        return view('admin.bm.create',compact('dispatchers'));
    }

    //Check mail id "Not to be same"
    public function checkEmail(Request $request){
        try {
            if($request->ajax()){
                if(BranchManager::where('email','=',$request->input('email'))->exists()){
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
            'dispatcher'=>'required',
        ]);

        try{

            $bm = $request->all();
            $bm['password'] = bcrypt($request->password);
            $bm = BranchManager::create($bm);
            $dispatcher=explode(',',$request->dispatcher);
            foreach($dispatcher as $index=>$dispatcher){
                $Dispatcher_id=Dispatcher::where('name',$dispatcher)->pluck('id')->first();
                if($Dispatcher_id){
                    if($index==0){
                        ManagerToDispatcher::where('branch_manager_id',$bm->id)->delete();
                    }
                    $connDispatch=new ManagerToDispatcher;
                    $connDispatch->branch_manager_id=$bm->id;
                    $connDispatch->dispatcher_id=$Dispatcher_id;
                    $connDispatch->save();
                }
            }

            return back()->with('flash_success','BranchManager Details Saved Successfully');
        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'BranchManager Not Found');
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
            $bm = BranchManager::findOrFail($id);
            // $depts = Department::all();

            return view('admin.bm.edit',compact('bm'));
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
            'dispatcher'=>'required'
        ]);

        try {

            $bm = BranchManager::findOrFail($id);
            $bm->name = $request->name;
            $bm->mobile = $request->mobile;
            $bm->enable = $request->enable;
            $bm->save();
            $dispatcher=explode(',',$request->dispatcher);
            foreach($dispatcher as $index=>$dispatcher){
                $Dispatcher_id=Dispatcher::where('name',$dispatcher)->pluck('id')->first();
                if($Dispatcher_id){
                    if($index==0){
                        ManagerToDispatcher::where('branch_manager_id',$bm->id)->delete();
                    }
                    $connDispatch=new ManagerToDispatcher;
                    $connDispatch->branch_manager_id=$bm->id;
                    $connDispatch->dispatcher_id=$Dispatcher_id;
                    $connDispatch->save();
                }
            }

            return back()->with('flash_success', 'Branch Manager Updated Successfully!');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Branch Manager Not Found!');
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
            BranchManager::find($id)->delete();
            return back()->with('message', 'Branch Manager deleted successfully!');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Branch Manager Not Found!');
        }
    }
}
