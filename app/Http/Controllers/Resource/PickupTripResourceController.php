<?php

namespace App\Http\Controllers\Resource;

use App\Fare;
use App\User;
use DateTime;
use App\Zones;
use App\Comment;
use App\OrderLog;
use App\Provider;
use App\RiderLog;
use Carbon\Carbon;
use App\Department;
use App\UserRequests;
use App\PaymentHistory;
use App\DispatcherToZone;
use App\ZoneDispatchList;
use App\Model\Notification;
use Illuminate\Http\Request;
use App\AssignedRidersHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RiderLogController;

class PickupTripResourceController extends Controller
{
    public function dateSearch(Request $request)
    {
        try {
            if (isset($request->search)) {
                if ($request->satus == "All") {
                    $request->date = '';
                }
                if ($request->to_date == "") {
                    $tom = new DateTime('tomorrow');
                    $request->to_date = $tom->format('Y-m-d');
                } else if ($request->from_date == "") {
                    $tod = new DateTime('today');
                    $tod->modify('-1 month');
                    $request->from_date = $tod->format('Y-m-d');
                }
                $current = [];
                if ($request->from_date == "") {
                    $request->date = $request->from_date;
                    if ($request->status != "All") {
                        $requests = UserRequests::where(function ($query) use ($request) {
                            $query->where('created_at', 'LIKE', $request->date . '%')
                                ->orWhere('updated_at', 'LIKE', $request->date . '%');
                        })
                            ->where('status', $request->status);
                        if ($request->status == "TOBERETURNED" || $request->status == "RETURNED") {
                            $requests = UserRequests::where(function ($query) use ($request) {
                                $query->where('created_at', 'LIKE', $request->date . '%')
                                    ->orWhere('updated_at', 'LIKE', $request->date . '%');
                            })
                                ->whereIn('status', ["CANCELLED", "REJECTED"])
                                ->where("returned", $request->status == "RETURNED");
                        }
                        $current['status'] = $request->status;
                    } else {
                        $requests = UserRequests::where(function ($query) use ($request) {
                            $query->where('created_at', 'LIKE', $request->date . '%')
                                ->orWhere('updated_at', 'LIKE', $request->date . '%');
                        });
                        $current['status'] = null;
                    }
                } else {
                    if ($request->status != "All") {
                        $requests = UserRequests::whereBetween('created_at', array($request->from_date . " 00:00:00", $request->to_date . " 23:59:59"))
                            ->where('status', $request->status);

                        if ($request->status == "TOBERETURNED" || $request->status == "RETURNED") {
                            $requests = UserRequests::whereBetween('created_at', array($request->from_date . " 00:00:00", $request->to_date . " 23:59:59"))
                                ->whereIn('status', ["CANCELLED", "REJECTED"])
                                ->where("returned", $request->status == "RETURNED");
                        }
                        $current['status'] = $request->status;
                    } else {

                        $requests = UserRequests::whereBetween('created_at', array($request->from_date . " 00:00:00", $request->to_date . " 23:59:59"));

                        $current['status'] = null;
                    }
                }

                if ($request->searchField != "") {
                    $requests = $requests->where(function ($q) use ($request) {
                        $q->whereHas('user', function ($query) use ($request) {
                            $query->where('first_name', 'LIKE', '%' . $request->searchField . '%')
                                ->orWhere('first_name', 'LIKE', '%' . $request->searchField . '%')
                                ->orWhere('mobile', 'LIKE', '%' . $request->searchField . '%');
                        })->orWhereHas('item', function ($query) use ($request) {
                            $query->where('rec_name', 'LIKE', '%' . $request->searchField . '%')
                                ->orWhere('rec_mobile', 'LIKE', '%' . $request->searchField . '%');
                        })->orWhereHas('provider', function ($query) use ($request) {
                            $query->whereRaw("concat(first_name, ' ', last_name) like '%" . $request->searchField . "%' ")
                                ->orWhere('mobile', 'LIKE', '%' . $request->searchField . '%');
                        });
                    })
                        ->orWhere('booking_id', 'LIKE', '%' . $request->searchField . '%');
                }
                $requests = $requests->orderBy('created_at', 'DESC')->paginate(100);

                $requests->appends([
                    'search' => $request->search,
                    'to_date' => $request->to_date,
                    'from_date' => $request->from_date,
                    'searchField' => $request->searchField,
                    'status' => $request->status
                ]); // End of multilevel Pagination.

                foreach ($requests as $request) {
                    $request->log = RiderLog::where('request_id', $request->id)->first();

                    //lets find if the request is in sending or receiving sortcenter
                    $dispatch = ZoneDispatchList::where('request_id', $request->id)->first();
                    if ($dispatch) {
                        $request->dispatched = true;
                    } else {
                        $request->dispatched = false;
                    }
                }
                $totalRiders = Provider::select("id", "first_name")->where("status", "approved")->where('type', 'pickup')->orderBy('first_name')->get();
                $totalrequest = UserRequests::count();
                $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
                $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
                $allDates = UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
                    ->orWhere('updated_at', '>=', Carbon::now()->subMonth())
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(created_at) as date')
                    ));
                $dates = [];
                $i = 0;
                foreach ($allDates as $d) {
                    $dates[$i] = $d->date;
                    $i++;
                }
                $current['date'] = $request->date;
                return view('pickup.orders.orderByDate', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'dates', 'current']));
            } else {
                $requests = [];
                $totalRiders = [];
                $totalrequest = [];
                $totalcanceltrip = [];
                $totalpaidamount = [];
                $allDates = UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(created_at) as date')
                    ));
                $dates = [];
                $i = 0;
                foreach ($allDates as $d) {
                    $dates[$i] = $d->date;
                    $i++;
                }
                return view('pickup.orders.orderByDate', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'dates']));
            }
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function update(Request $request, $id)
    {
        try {
          
            $UserRequest = UserRequests::findOrFail($id);
            if ($request->ajax()) {
                if (isset($request->weight)) {
                    $zone_id=Zones::where('zone_name','Kathmandu')->pluck('id')->first(); //get Kathmandu ZOne ID
                    if($UserRequest->zone1==$UserRequest->zone2){
                        $fareObj=Fare::where('zone1_id',$UserRequest->zone1)
                                ->where('zone2_id',$UserRequest->zone2)
                                ->where('km','>',$UserRequest->distance)
                                ->orderBy('km','ASC')
                                ->first();
                    }
                    else{
                        $fareObj=Fare::where('zone1_id',$UserRequest->zone1)
                                ->where('zone2_id',$UserRequest->zone2)
                                ->first();
                    }

                    if($UserRequest->zone1==$UserRequest->zone2 && $zone_id==$UserRequest->zone1){
                       if($UserRequest->cargo=='1'){
                            // $new_fare = $request->weight*$UserRequest->fare;
                           $new_fare = Setting::get('cargo_amount') * $request->weight;
                        }
                        else{
                            //$new_fare = $request->weight*$UserRequest->fare;
                            if ($request->weight<=0.5){
                                $new_fare = $fareObj->fare_half_kg;
                            }
                            elseif($request->weight<2){
                                $fare =  $UserRequest->fare;
                                $kg = $request->weight;
                                $new_fare = $fare;
                            }
                            else{
                                $fare =  $UserRequest->fare;
                                $kg = $request->weight;
                                $new_fare = $fare+($fare/2)*($kg-2);
                            }                       
                        }
                    }
                    else{
                        if($UserRequest->cargo=='1'){
                            // $new_fare = $request->weight*$UserRequest->fare;
                            $new_fare = Setting::get('cargo_amount') * $request->weight;
                        }
                        else{
                            //$new_fare = $request->weight*$UserRequest->fare;
                            if ($request->weight<=0.5){
                                $new_fare = $fareObj->fare_half_kg;
                            }else{
                                $fare =  $UserRequest->fare;
                                $kg = $request->weight;
                                $new_fare = $fare+($fare/2)*($kg-1);
                            }                       
                        }
                    }
                    $request->request->add([
                        'amount_customer' => $new_fare
                    ]);
                    $UserRequest->weight = $request->weight;
                }

                if (isset($request->special_note)) {
                    $UserRequest->special_note = $request->special_note;
                } else if (isset($request->cod)) {
                    //if cod has been used in wallet(which is only when order is either completed or rejected)
                    if ($UserRequest->status == "COMPLETED" || $UserRequest->status == "REJECTED") {
                        // deducting old cod
                        $UserRequest->user->wallet_balance -= $UserRequest->cod;
                        // adding new cod
                        $UserRequest->user->wallet_balance += $request->cod;
                        // saving user wallet
                        $UserRequest->user->save();

                        //change old cod by new cod on payable of rider too
                        if ($UserRequest->provider) {
                            $UserRequest->provider->payable -= $UserRequest->cod;
                            $UserRequest->provider->payable += $request->cod;
                            $UserRequest->provider->save();
                        }
                    }
                    $UserRequest->cod = $request->cod;
                } else if (isset($request->amount_customer)) {
                    if ($UserRequest->status == "COMPLETED" || $UserRequest->status == "REJECTED") {
                        // adding old fare
                        $UserRequest->user->wallet_balance += $UserRequest->amount_customer;
                        // deducting new fare
                        $UserRequest->user->wallet_balance -= $request->amount_customer;
                        // saving user wallet
                        $UserRequest->user->save();

                        //change old fare by new fare on earning of rider too
                        if ($UserRequest->provider) {
                            $UserRequest->provider->earning -= ($UserRequest->amount_customer - 30);
                            $UserRequest->provider->earning += ($request->amount_customer - 30);
                            $UserRequest->provider->save();
                        }
                    }
                    $UserRequest->amount_customer = $request->amount_customer;
                } else if (isset($request->status)) {
                    //we cant set returned or to be returned if previous is not rejected
                    if ($UserRequest->status == $request->status) {
                    } else if (($request->status == "TOBERETURNED" ||  $request->status == "RETURNED") && !($UserRequest->status == "REJECTED" || $UserRequest->status == "TOBERETURNED" || $UserRequest->status == "RETURNED" || $UserRequest->status == "CANCELLED")) {
                        return response()->json([
                            'prev' => $UserRequest->status,
                            'status' => $request->status,
                            'showError' => true,
                            'error' => "Error! Please make sure item is rejected or cancelled to process return."
                        ]);
                    } else if ($request->status == "TOBERETURNED" ||  $request->status == "RETURNED") {
                        $UserRequest->returned = $request->status == "TOBERETURNED" ? 0 : 1;
                        $request->status = $UserRequest->status;
                    } else if (($request->status == "REJECTED" || $request->status == "CANCELLED") && ($UserRequest->status == "REJECTED" || $UserRequest->status == "CANCELLED")) {
                        $UserRequest->returned = 0;
                    }
                    //If status is unchanged from previous, dont do anything.
                    //If changed:
                    if ($UserRequest->status != $request->status) {
                        $prev = $UserRequest->user->wallet_balance;

                        //If previous is not completed and rejected, update wallet balance and status.
                        if ($UserRequest->status != "COMPLETED" && $UserRequest->status != "REJECTED") {
                            if ($request->status == "COMPLETED" || $request->status == "REJECTED") {
                                if ($request->status == "COMPLETED") {
                                    $UserRequest->user->wallet_balance += $UserRequest->cod;

                                    if ($UserRequest->provider) {
                                        $UserRequest->provider->payable += $UserRequest->cod;
                                    }
                                }
                                if ($UserRequest->amount_customer != "0.0") {
                                    $UserRequest->user->wallet_balance -= $UserRequest->amount_customer;
                                    if ($UserRequest->provider) {
                                        $UserRequest->provider->earning += ($UserRequest->amount_customer - 30);
                                    }
                                }
                            }
                        }
                        //if previous is completed or rejected
                        else {
                            //If prev is completed, decrease the cod and add fare
                            if ($UserRequest->status == "COMPLETED") {
                                $UserRequest->user->wallet_balance -= $UserRequest->cod;
                                $UserRequest->provider->payable -= $UserRequest->cod;
                                if ($UserRequest->amount_customer != "0.0") {
                                    $UserRequest->user->wallet_balance += $UserRequest->amount_customer;
                                    $UserRequest->provider->earning -= ($UserRequest->amount_customer - 30);
                                }

                                //check if the new is rejected. If it is rejected, reduce fare.
                                if ($request->status == "REJECTED") {
                                    if ($UserRequest->amount_customer != "0.0") {
                                        $UserRequest->user->wallet_balance -= $UserRequest->amount_customer;
                                        $UserRequest->provider->earning += ($UserRequest->amount_customer - 30);
                                    }
                                }
                            }
                            //If prev is rejected, add fare and check if new is completed
                            else if ($UserRequest->status == "REJECTED") {
                                if ($UserRequest->amount_customer != "0.0") {
                                    $UserRequest->user->wallet_balance += $UserRequest->amount_customer;
                                    $UserRequest->provider->earning -= ($UserRequest->amount_customer - 30);
                                }

                                //check if the new is completed. If it is completed, reduce fare and add cod.
                                if ($request->status == "COMPLETED") {
                                    $UserRequest->user->wallet_balance += $UserRequest->cod;
                                    $UserRequest->provider->payable += $UserRequest->cod;
                                    if ($UserRequest->amount_customer != "0.0") {
                                        $UserRequest->user->wallet_balance -= $UserRequest->amount_customer;
                                        $UserRequest->provider->earning += ($UserRequest->amount_customer - 30);
                                    }
                                }
                            }
                        }
                        $diff = $UserRequest->user->wallet_balance - $prev;
                        if ($diff != 0) {
                            $paymentHistory = new PaymentHistory;
                            $paymentHistory->user_id = $UserRequest->user->id;
                            $paymentHistory->request_id = $id;
                            $paymentHistory->changed_amount = $diff;
                            $paymentHistory->remarks = "Changed from " . $UserRequest->status . " to " . $request->status . " of booking id " . $UserRequest->booking_id;
                            $paymentHistory->save();
                        }
                        $UserRequest->user->save();
                        $UserRequest->provider ? $UserRequest->provider->save() : null;

                        if ($request->status == "PICKEDUP") {
                            $remarks = $request->has('remarks') ? $request->remarks : '';
                            $logRequest = new Request();
                            $logRequest->replace([
                                'request_id' => $id,
                                'pickup_id' => $UserRequest->provider_id,
                                'pickup_remarks' => $remarks
                            ]);
                            $riderLog = new RiderLogController;
                            $riderLog->create($logRequest);
                        } else if ($request->status == "COMPLETED" || $request->status == "REJECTED" || $request->status == "SCHEDULED") {
                            $remarks = $request->has('remarks') ? $request->remarks : '';
                            $logRequest = new Request();
                            $logRequest->replace([
                                'request_id' => $id,
                                'complete_id' => $UserRequest->provider_id,
                                'complete_remarks' => $remarks
                            ]);
                            $riderLog = new RiderLogController;
                            $riderLog->create($logRequest);
                        }


                        //clear rider if status is pending or sortcenter
                        if ($request->status == "PENDING" || $request->status == "SORTCENTER") {
                            AssignedRidersHistory::create([
                                'request_id' => $UserRequest->id,
                                'rider_id' => $UserRequest->provider_id,
                                'status' => $request->status
                            ]);
                            $UserRequest->provider_id = null;
                        }
                        $UserRequest->status = $request->status;
                    }
                } else if (isset($request->provider)) {
                    if ($request->provider == "N/A" || $request->provider == "Select Rider") {
                        AssignedRidersHistory::create([
                            'request_id' => $UserRequest->id,
                            'rider_id' => $UserRequest->provider_id,
                            'status' => $UserRequest->status
                        ]);
                        $UserRequest->provider_id = null;
                    } else {
                       
                        $UserRequest->provider_id = $request->provider;
                        $UserRequest->status="ACCEPTED";
                        $log=new OrderLog();
                        $log->create([
                            'request_id'=>$UserRequest->id,
                            'type' => "Rider",
                            'description' => 'Rider Assigned by '.Auth::user()->name
                        ]);
                        if ($UserRequest->status == "COMPLETED" || $UserRequest->status == "REJECTED" || $UserRequest->status == "SCHEDULED") {
                            $logRequest = new Request();
                            $logRequest->replace([
                                'request_id' => $id,
                                'complete_id' => $UserRequest->provider_id,
                                'complete_remarks' => 'Rider Changed'
                            ]);
                            $riderLog = new RiderLogController;
                            $riderLog->create($logRequest);
                        }
                        AssignedRidersHistory::create([
                            'request_id' => $UserRequest->id,
                            'rider_id' => $UserRequest->provider_id,
                            'status' => $UserRequest->status
                        ]);
                    }
                }
                $a = $UserRequest->save();
                return response()->json([
                    'success' => true,
                    'message' => "Data Uploaded Sucessfully"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function bulkAssign()
    {
        try {
            $requests = UserRequests::groupBy('user_id')
                ->select(
                    'user_id',
                    'status',
                    'provider_id',
                    's_address',
                    DB::raw('count(*) as count')
                )
                ->where('status', 'PENDING')
                ->get();
            foreach ($requests as $request) {
                $r = UserRequests::where('user_id', $request->user_id)
                    ->select(DB::raw("sum(if(user_requests.returned='0',1,0)) as r"))
                    ->whereIn('status', ["CANCELLED", "REJECTED"])
                    ->where('returned_to_hub', '1')
                    ->first();
                $request->r = $r->r;
            }
            $totalRiders = Provider::select("id", "first_name")->where("status", "approved")->where('type', 'pickup')->orderBy('first_name')->get();
            return view('pickup.orders.bulkassign', compact(['requests', 'totalRiders']));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function vendorAssign($id)
    {
        try {
            $requests = UserRequests::where('user_id',$id)
            ->where(function($query){
                $query->where('status','=','PENDING')->orWhere('status','=','ACCEPTED')->orWhere('status','=','PICKEDUP');
                })
            ->get();
           
            //dd($inbound_orders);
            // return $inbound_orders;
            $totalRiders = Provider::select("id", "first_name")->where("status", "approved")->where('type', 'pickup')->orderBy('first_name')->get();
            return view('pickup.orders.vendorWise', compact(['totalRiders','requests'] ));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function storeBulkAssign(Request $request, $id)
    {
        try {
            
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $orders_id = UserRequests::where('user_id', $id)
                ->where('status', 'PENDING')->get();
            UserRequests::where('user_id', $id)
                ->where('status', 'PENDING')
                ->update(array('provider_id' => $request->provider, 'status' => "ACCEPTED"));
            foreach ($orders_id as $order_id) {
                $log=new OrderLog();
                        $log->create([
                            'request_id'=>$order_id->id,
                            'type' => "Pickup",
                            'description' => 'Rider Assigned by '.Auth::user()->name
                        ]);
                $logRequest = new Request();
                $logRequest->replace([
                    'request_id' => $order_id->id,
                    'pickup_id' => $request->provider,
                    'pickup_remarks' => ""
                ]);
                $riderLog = new RiderLogController;
                $riderLog->create($logRequest);
            }
            DB::commit();
            return response()->json([
                'request' => $request,
                'error' => true
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'showError' => true,
                'error' => "Error! Please try again."
            ]);
        }
    }
    public function show($id)
    {
        try {
            $request = UserRequests::findOrFail($id);

            $promocode = $request->payment()->with('promocode')->first();

            $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
            $comments = Comment::where('request_id', '=', $id)->orderBy('created_at', 'ASC')->get();

            foreach ($comments as $comment) {
                if ($comment->dept_id == $dept) {
                    $dispatcherZone = DispatcherToZone::where('dispatcher_id', $comment->authorised_id)->pluck('zone_id')->first();
                    $comment->zone = Zones::where('id', $dispatcherZone)->pluck('zone_name')->first();
                }
            }
            $logs=OrderLog::where('request_id',$id)->orderBy('created_at','DESC')->get();

            // if(Auth::guard('dispatcher')->user()){
            //     return view('dispatcher.request.show', compact('request','promocode', 'comments'));    
            // }
            return view('pickup.orders.orderDetails', compact('request', 'promocode', 'comments','logs'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function pickupComment(Request $request, $req_id)
    {
        try {
            // $comment = new Comment();

            // $comment->request_id = $req_id;
            // //$comment->booking_id = $booking_id;
            // $comment->authorised_type = "admin";
            // $comment->authorised_id = Auth::user()->id;
            // $comment->comments = $request->input('admin_comment');
            // $comment->is_read_admin = '0';

            $dept = Department::where('dept', '=', 'Pickup')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = 'Pickup';
            $comment->comments = $request->input('comment');
            $comment->is_read_admin = '0';
            $comment->save();
            $solve_comment = UserRequests::findOrFail($req_id);
            $solve_comment->comment_status = 1;
            $solve_comment->update();
            //notify;
            $noti = new Notification;
            $token= $solve_comment->user->device_key;
            $title = 'Comment Received';
            $body = 'New comment received for your order of'.$solve_comment->item->rec_name;
            $noti->toSingleDevice($token,$title,$body,null,null,$solve_comment->user->id,$solve_comment->id);
            return back()->with('flash_success', 'Your message has send!!!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    public function pickupRemaining(){
        try{
          $remaining_data=  UserRequests::whereIn('status',['PENDING','ACCEPTED','PICKEDUP'])->whereDate('created_at', '<=', Carbon::today()->setTime(11, 00, 00)->toDateTimeString())->groupBy('user_id')->get();
        //   dd($remaining_data);
            return view('pickup.orders.pickupremaining',compact('remaining_data'));


        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
}
