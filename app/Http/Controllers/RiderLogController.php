<?php

namespace App\Http\Controllers;

use App\RiderLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RiderLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        try{
            $this->validate($request, [
                'request_id'=> 'required'
            ]);
            //check if log for the specific request already exists
            $log= RiderLog::where('request_id',$request->request_id)->get();
            if(count($log)>0 && $request->has('complete_id')){
                // $this->validate($request,[
                //     'complete_id' => 'required'
                // ]);
                $log=$log->first();
                $log->complete_id=$request->complete_id;
                $log->complete_remarks=($request->has('complete_remarks')? $request->complete_remarks : '');
                $log->completed_date=$request->completed_date;
                $log->save();
            }
            else if($request->has('pickup_id')){
                // $this->validate($request,[
                //     'pickup_id' => 'required'
                // ]);
                $log=new RiderLog;
                $log->request_id=$request->request_id;
                $log->pickup_id=$request->pickup_id;

                $log->pickup_remarks=($request->has('pickup_remarks')? $request->pickup_remarks : '');
                $log->save();
            }
            else{
                $log=new RiderLog;
                $log->request_id=$request->request_id;
                $log->complete_id=$request->complete_id;
                $log->complete_remarks=($request->has('complete_remarks')? $request->complete_remarks : '');
                $log->completed_date=$request->completed_date;
                $log->save();
            }
            return true;
        }
        catch(Exception $e){
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
    }
}
