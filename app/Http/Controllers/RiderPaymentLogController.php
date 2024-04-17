<?php

namespace App\Http\Controllers;

use App\RiderPaymentLog;
use Illuminate\Http\Request;

class RiderPaymentLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        try{
            $this->validate($request, [
                'provider_id'=> 'required',
                'transaction_type'=>'required',
                'amount' => 'required',
            ]);
            //check if log for the specific request already exists
            $log= new RiderPaymentLog;
            $log->provider_id=$request->provider_id;
            $log->transaction_type=$request->transaction_type;
            $log->amount=$request->amount;
            $log->remarks=$request->remarks?$request->remarks:0;
            $log->save();
            return true;
        }
        catch(Exception $e){
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
    }
    public function edit($id){
        try {
            $log = RiderPaymentLog::findOrFail($id);
            return view('account.providers.provider-payment',compact('log'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    public function update(Request $request, $id){
        try {

            $log = RiderPaymentLog::findOrFail($id);

            $log->amount = $request->amount;
            $log->remarks = $request->remarks;
            $log->save();

            return redirect()->route('account.providers.log.update',$log->provider_id)->with('flash_success', 'Log Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Log Not Found');
        }
    }
    public function destroy($id,$provider_id)
    {
        try {
         
            RiderPaymentLog::find($id)->delete();
            return redirect()->route('account.providers.log.update',$provider_id)->with('flash_success', 'Log deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Log Not Found');
        }
    }
}
