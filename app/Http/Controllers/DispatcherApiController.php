<?php

namespace App\Http\Controllers;
use App\OrderLog;

use App\Provider;
use App\UserRequests;
use App\RiderPaymentLog;
use App\DispatchBulkList;
use App\DispatcherDevice;
use App\DispatcherToZone;
use App\UserRequestPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RiderLogController;

class DispatcherApiController extends Controller
{
    public function dashboard(){
        try{
            $pending=DispatchBulkList::where('received_all','=', '0')
                    ->where('incomplete_received', '=', '0')
                    ->where('draft', '=', '0')
                    ->where('Returned','!=','1')
                    ->where('zone2_id',Auth::user()->id)
                    ->withCount(['lists'])
                    ->get();

            $complete_received=DispatchBulkList::where('received',true)
                    ->where('received_all',true)
                    ->where('incomplete_received',false)
                    ->where('draft', false)
                    ->where('zone2_id',Auth::user()->id)
                    ->get();
            $incomplete_received=DispatchBulkList::where('received',true)
                    ->where('received_all',false)
                    ->where('incomplete_received', true)
                    ->where('draft', false)
                    ->where('zone2_id',Auth::user()->id)
                    ->get();

            $dispatch=DispatchBulkList::where('draft','=','0')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();

            $complete_reached=DispatchBulkList::where('received',true)
                    ->where('received_all',true)
                    ->where('incomplete_received',false)
                    ->where('draft','=','0')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();
            $incomplete_reached=DispatchBulkList::where('received_all',false)
                    ->where('incomplete_received', true)
                    ->where('draft','=','0')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();

            $draft=DispatchBulkList::where('received',false)
                    ->where('draft','=','1')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();
            
            $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
            $rider = Provider::whereIn('zone_id', $currentZones)->count();

            $Response=[
                'pending' => $pending,
                'complete_received' => $complete_received,
                'incomplete_received' => $incomplete_received,
                'dispatch' => $dispatch,
                'complete_reached' => $complete_reached,
                'incomplete_reached' => $incomplete_reached,
                'draft' => $draft,
                'rider' => $rider
            ];
            return $Response;
        }
            // return view('dispatcher.dashboard', compact(['pending', 'complete_received', 'incomplete_received', 'dispatch', 'complete_reached', 'incomplete_reached', 'draft', 'rider']));
           catch (Exception $e) {
            return response()->json(['error' => 'something went run'], 500);
        }
    }
    public function rider(){
        try{
            $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
            $Providers = Provider::where('status','approved')->where('settle',0)->whereIn('zone_id', $currentZones)
                    ->orderBy('id', 'DESC')->get();
            $Response=[
                'Providers' => $Providers
            ];
            return $Response;

        } catch (Exception $e) {
             return response()->json(['error' => 'something went run'], 500);
        }
    }
    public function logout(Request $request){
        try {
            DispatcherDevice::where('dispatcher_id', $request->id)->delete();
            return response()->json(['message' => trans('api.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    public function assignRider(Request $request){
        return $request->all();
        $this->validate($request,[
            'rider_id'=>'required|numeric|exists:providers,id',
            'booking_id'=>'required',
        ]);
        try{
            DB::beginTransaction();
            foreach($booking_id as $booking){
                $orders_id = UserRequests::where('booking_id', $booking)->first();
                UserRequests::where('booking_id', $booking)
                    ->update(array('provider_id' => $request->rider_id,'status' => "DELIVERING"));
                $log=new OrderLog();
                $log->create([
                        'request_id'=>$orders_id->id,
                        'type' => "status",
                        'description' => 'Order Assign to Rider',
                    ]);
                $logRequest = new Request();
                $logRequest->replace([
                        'request_id' => $orders_id->id,
                        'pickup_id' => $request->id,
                        'pickup_remarks' => ""
                    ]);
                $riderLog = new RiderLogController;
                $riderLog->create($logRequest);
            }
           DB::commit();
           return response()->json(['status'=>true,'message' =>'order assign successfu']);
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json(['error' =>"something went wrong"], 500);
        }
    }
        
}
