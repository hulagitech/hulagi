<?php

namespace App\Http\Controllers\Resource;

use App\Fare;
use DateTime;
use App\Items;
use App\Zones;
use Exception;
use App\Comment;
use App\OrderLog;
use App\Provider;
use App\RiderLog;
use Carbon\Carbon;
use App\Department;
use App\DateInbound;
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
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\RiderLogController;
use App\Http\Controllers\AjaxHandlerController;

class SortCenterTripResourceController extends Controller
{
    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }
    public function dateSearch(Request $request)
    {
        
        try {
            if(isset($request->search)){
                if($request->satus=="All"){
                    $request->date='';
                }
                if($request->to_date==""){
                    $tom=new DateTime('tomorrow');
                    $request->to_date=$tom->format('Y-m-d');
                }
                else if($request->from_date==""){
                    $tod=new DateTime('today');
                    $tod->modify('-1 month');
                    $request->from_date=$tod->format('Y-m-d');
                }
                $current=[];
                if($request->from_date==""){
                    $request->date=$request->from_date;
                    if($request->status!="All"){
                        $requests = UserRequests::where(function($query) use ($request){
                                        $query->where('created_at','LIKE',$request->date.'%')
                                        ->orWhere('updated_at','LIKE',$request->date.'%');
                                    })
                                    ->where('status',$request->status);
                        if($request->status=="TOBERETURNED" || $request->status=="RETURNED"){
                            $requests = UserRequests::where(function($query) use ($request){
                                            $query->where('created_at','LIKE',$request->date.'%')
                                            ->orWhere('updated_at','LIKE',$request->date.'%');
                                        })
                                        ->whereIn('status',["CANCELLED","REJECTED"])
                                        ->where("returned",$request->status=="RETURNED");
                        }
                        $current['status']=$request->status;
                    }
                    else{
                        $requests = UserRequests::where(function($query) use ($request){
                                        $query->where('created_at','LIKE',$request->date.'%')
                                        ->orWhere('updated_at','LIKE',$request->date.'%');
                                    });
                        $current['status']=null;
                    }
                }
                else{
                    if($request->status!="All"){
                        $requests = UserRequests::whereBetween('created_at', array($request->from_date . " 00:00:00", $request->to_date . " 23:59:59"))
                                    ->where('status',$request->status);

                        if($request->status=="TOBERETURNED" || $request->status=="RETURNED"){
                            $requests = UserRequests::whereBetween('created_at', array($request->from_date . " 00:00:00", $request->to_date . " 23:59:59"))
                                        ->whereIn('status',["CANCELLED","REJECTED"])
                                        ->where("returned",$request->status=="RETURNED");
                        }
                        $current['status']=$request->status;
                    }
                    else{
                        
                        $requests = UserRequests::whereBetween('created_at', array($request->from_date . " 00:00:00", $request->to_date . " 23:59:59"));
                        
                        $current['status']=null;
                    }
                }
                
                if($request->searchField!=""){
                    $requests=$requests->where(function($q) use ($request){
                        $q->whereHas('user',function($query) use ($request){
                            $query->where('first_name', 'LIKE' ,'%'.$request->searchField.'%')
                            ->orWhere('first_name', 'LIKE' ,'%'.$request->searchField.'%')
                            ->orWhere('mobile', 'LIKE' ,'%'.$request->searchField.'%');
                        })->orWhereHas('item',function($query) use ($request){
                            $query->where('rec_name', 'LIKE' ,'%'.$request->searchField.'%')	
                            ->orWhere('rec_mobile', 'LIKE' ,'%'.$request->searchField.'%');
                        })->orWhereHas('provider',function($query) use ($request){
                            $query->whereRaw("concat(first_name, ' ', last_name) like '%" .$request->searchField ."%' ")
                            ->orWhere('mobile', 'LIKE' ,'%'.$request->searchField.'%');
                        });
                    })
                    ->orWhere('booking_id','LIKE','%'.$request->searchField.'%');
                }
                $requests=$requests->orderBy('created_at','DESC')->paginate(100);

                $requests->appends([
					'search'=>$request->search,
					'to_date'=>$request->to_date,
					'from_date'=>$request->from_date,
					'searchField'=>$request->searchField,
					'status'=>$request->status
					]); // End of multilevel Pagination.

                foreach($requests as $request){
                    $request->log=RiderLog::where('request_id',$request->id)->first();

                    //lets find if the request is in sending or receiving sortcenter
                    $dispatch=ZoneDispatchList::where('request_id',$request->id)->first();
                    if($dispatch){
                        $request->dispatched=true;
                    }
                    else{
                        $request->dispatched=false;
                    }
                }
                $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
                $totalrequest = UserRequests::count();
                $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
                $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
                $allDates= UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
                    ->orWhere('updated_at', '>=', Carbon::now()->subMonth())
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(created_at) as date')
                    ));
                $dates=[];
                $i=0;
                foreach($allDates as $d){
                    $dates[$i]=$d->date;
                    $i++;
                }
                $current['date']=$request->date;
                return view('sortcenter.orders.orderByDate', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates', 'current']));
            }
            else{
                $requests = [];
                $totalRiders=[];
                $totalrequest = [];
                $totalcanceltrip = [];
                $totalpaidamount = [];
                $allDates= UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(created_at) as date')
                    ));
                $dates=[];
                $i=0;
                foreach($allDates as $d){
                    $dates[$i]=$d->date;
                    $i++;
                }
                return view('sortcenter.orders.orderByDate', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function update(Request $request, $id)
    {   
        /*$this->validate($request, [
            'first_name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
        ]);*/
        try {
            $UserRequest = UserRequests::findOrFail($id);
            if($request->ajax()) {

                // if(isset($request->cargo)){
                //     $UserRequest->cargo = $request->cargo;
                //     $UserRequest->fare = 85;
                //     $UserRequest->amount_customer = $UserRequest->weight * 85;

                // }
                
                if(isset($request->weight)){
                    //check if same zone
                    //get fareobj as in UserAPiController-> estimated_fare()
                    //if weight<500g, set UserRequest->fare=$fareObj->halfFare
                    //else set UserRequest->fare=$faraeObj->fullFare

                    //now use formula for cargo and others using $UserRequest->fare

                    //set request->amount_customer
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
                     $log=new OrderLog();
                    $log->create([
                        'request_id'=>$UserRequest->id,
                        'type' => "weight",
                        'description' => 'Weight changed from '.$UserRequest->weight." to ".$request->weight.". Status:".$UserRequest->status ." by ".Auth::user()->name
                    ]);
                    $UserRequest->weight = $request->weight;
                }

                if(isset($request->special_note)){
                    $UserRequest->special_note= $request->special_note;
                }
                
                else if(isset($request->cod)){
                    //if cod has been used in wallet(which is only when order is either completed or rejected)
                    if($UserRequest->status=="COMPLETED" || $UserRequest->status=="REJECTED"){
                        // deducting old cod
                        $UserRequest->user->wallet_balance -= $UserRequest->cod;
                        // adding new cod
                        $UserRequest->user->wallet_balance += $request->cod;
                        // saving user wallet
                        $UserRequest->user->save();

                        //change old cod by new cod on payable of rider too
                        if($UserRequest->provider) {
                            $UserRequest->provider->payable-=$UserRequest->cod;
                            $UserRequest->provider->payable+=$request->cod;
                            $UserRequest->provider->save();
                        }
                    }
                    $UserRequest->cod= $request->cod;
                }
                else if(isset($request->amount_customer)){
                    if($UserRequest->status=="COMPLETED" || $UserRequest->status=="REJECTED"){
                        // adding old fare
                        $UserRequest->user->wallet_balance += $UserRequest->amount_customer;
                        // deducting new fare
                        $UserRequest->user->wallet_balance -= $request->amount_customer;
                        // saving user wallet
                        $UserRequest->user->save();

                        //change old fare by new fare on earning of rider too
                        if($UserRequest->provider) {
                            $UserRequest->provider->earning-=($UserRequest->amount_customer-30);
                            $UserRequest->provider->earning+=($request->amount_customer-30);
                            $UserRequest->provider->save();
                        }
                    }
                    $log=new OrderLog();
                    $log->create([
                        'request_id'=>$UserRequest->id,
                        'type' => "weight",
                        'description' => 'Fare changed from '.$UserRequest->amount_customer." to ".$request->amount_customer.". Status:".$UserRequest->status ." by ".Auth::user()->name
                    ]);
                    $UserRequest->amount_customer= $request->amount_customer;
                    
                }
                else if(isset($request->status)){

                    //we cant set returned or to be returned if previous is not rejected
                    if($UserRequest->status == $request->status){}
                    else if(($request->status=="TOBERETURNED" ||  $request->status=="RETURNED") && !($UserRequest->status=="REJECTED" || $UserRequest->status=="TOBERETURNED" || $UserRequest->status=="RETURNED" || $UserRequest->status=="CANCELLED")){
                        return response()->json([
                            'prev' => $UserRequest->status,
                            'status' => $request->status,
                            'showError' => true,
                            'error' => "Error! Please make sure item is rejected or cancelled to process return."
                        ]);
                    }
                    else if($request->status=="TOBERETURNED" ||  $request->status=="RETURNED"){
                        $UserRequest->returned=$request->status=="TOBERETURNED"?0:1;
                        $request->status=$UserRequest->status;
                    }
                    else if(($request->status=="REJECTED" || $request->status=="CANCELLED") && ($UserRequest->status=="REJECTED" || $UserRequest->status=="CANCELLED")){
                        $UserRequest->returned=0;
                    }

                    //If status is unchanged from previous, dont do anything.
                    //If changed:
                    if($UserRequest->status != $request->status){
                        $prev=$UserRequest->user->wallet_balance;

                        //If previous is not completed and rejected, update wallet balance and status.
                        if($UserRequest->status !="COMPLETED" && $UserRequest->status !="REJECTED"){
                            if($request->status=="COMPLETED" || $request->status=="REJECTED"){
                                if($request->status=="COMPLETED"){
                                    $UserRequest->user->wallet_balance+=$UserRequest->cod;

                                    if($UserRequest->provider) {
                                        $UserRequest->provider->payable+=$UserRequest->cod;
                                    }
                                }
                                if($UserRequest->amount_customer!="0.0"){
                                    $UserRequest->user->wallet_balance-=$UserRequest->amount_customer;
                                    if($UserRequest->provider) {
                                        $UserRequest->provider->earning+=($UserRequest->amount_customer-30);
                                    }
                                }
                            }
                        }
                        //if previous is completed or rejected
                        else{
                            //If prev is completed, decrease the cod and add fare
                            if($UserRequest->status =="COMPLETED"){
                                $UserRequest->user->wallet_balance-=$UserRequest->cod;
                                $UserRequest->provider->payable-=$UserRequest->cod;
                                if($UserRequest->amount_customer!="0.0"){
                                    $UserRequest->user->wallet_balance+=$UserRequest->amount_customer;
                                    $UserRequest->provider->earning-=($UserRequest->amount_customer-30);
                                }

                                //check if the new is rejected. If it is rejected, reduce fare.
                                if($request->status =="REJECTED"){
                                    if($UserRequest->amount_customer!="0.0"){
                                        $UserRequest->user->wallet_balance-=$UserRequest->amount_customer;
                                        $UserRequest->provider->earning+=($UserRequest->amount_customer-30);
                                    }
                                }
                            }
                            //If prev is rejected, add fare and check if new is completed
                            else if($UserRequest->status =="REJECTED"){
                                if($UserRequest->amount_customer!="0.0"){
                                    $UserRequest->user->wallet_balance+=$UserRequest->amount_customer;
                                    $UserRequest->provider->earning-=($UserRequest->amount_customer-30);
                                }

                                //check if the new is completed. If it is completed, reduce fare and add cod.
                                if($request->status =="COMPLETED"){
                                    $UserRequest->user->wallet_balance+=$UserRequest->cod;
                                    $UserRequest->provider->payable+=$UserRequest->cod;
                                    if($UserRequest->amount_customer!="0.0"){
                                        $UserRequest->user->wallet_balance-=$UserRequest->amount_customer;
                                        $UserRequest->provider->earning+=($UserRequest->amount_customer-30);
                                    }
                                }
                            }
                        }
                        $diff=$UserRequest->user->wallet_balance-$prev;
                        if($diff!=0){
                            $paymentHistory=new PaymentHistory;
                            $paymentHistory->user_id=$UserRequest->user->id;
                            $paymentHistory->request_id=$id;
                            $paymentHistory->changed_amount=$diff;
                            $paymentHistory->remarks="Changed from ".$UserRequest->status." to ".$request->status." of booking id ".$UserRequest->booking_id;
                            $paymentHistory->save();
                        }
                        $UserRequest->user->save();
                        $UserRequest->provider ? $UserRequest->provider->save() : null;

                        if($request->status=="PICKEDUP"){
                            $remarks= $request->has('remarks')?$request->remarks: '';
                            $logRequest=new Request();
                            $logRequest->replace([
                                'request_id' => $id,
                                'pickup_id' => $UserRequest->provider_id,
                                'pickup_remarks' => $remarks
                            ]);
                            $riderLog=new RiderLogController;
                            $riderLog->create($logRequest);
                        }
                        else if($request->status=="COMPLETED" || $request->status=="REJECTED" || $request->status=="SCHEDULED"){
                            $remarks= $request->has('remarks')?$request->remarks: '';
                            $logRequest=new Request();
                            $logRequest->replace([
                                'request_id' => $id,
                                'complete_id' => $UserRequest->provider_id,
                                'complete_remarks' => $remarks
                            ]);
                            $riderLog=new RiderLogController;
                            $riderLog->create($logRequest);
                        }


                        //clear rider if status is pending or sortcenter
                        if($request->status=="PENDING" || $request->status=="SORTCENTER"){
                            AssignedRidersHistory::create([
                                'request_id'=>$UserRequest->id,
                                'rider_id'=>$UserRequest->provider_id,
                                'status'=>$request->status
                            ]);
                            $UserRequest->provider_id=null;
                        }
                        $UserRequest->status= $request->status;
                    }
                }
                else if(isset($request->provider)){
                    if($request->provider=="N/A" || $request->provider=="Select Rider"){
                        AssignedRidersHistory::create([
                            'request_id'=>$UserRequest->id,
                            'rider_id'=>$UserRequest->provider_id,
                            'status'=>$UserRequest->status
                        ]);
                        $UserRequest->provider_id=null;    
                    }
                    else{
                        $UserRequest->provider_id= $request->provider;
                        if($UserRequest->status=="COMPLETED" || $UserRequest->status=="REJECTED" || $UserRequest->status=="SCHEDULED"){
                            $logRequest=new Request();
                            $logRequest->replace([
                                'request_id' => $id,
                                'complete_id' => $UserRequest->provider_id,
                                'complete_remarks' => 'Rider Changed'
                            ]);
                            $riderLog=new RiderLogController;
                            $riderLog->create($logRequest);
                        }
                        AssignedRidersHistory::create([
                            'request_id'=>$UserRequest->id,
                            'rider_id'=>$UserRequest->provider_id,
                            'status'=>$UserRequest->status
                        ]);
                        // $rider = UserRequests::where('id', $id)->pluck('provider_id')->first();
                        // return response()->json([
                        //     'message' => $rider,
                        // ]);
                    }
                    // $UserRequest->provider->save();
                }
                $a=$UserRequest->save();
                return response()->json([
                        'request' => $request,
                        'error' => $a
                    ]);
            }
        } 

        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    //
    public function all_inbound()
    {
        try {
            // $inbound_orders = UserRequests::whereIn('status',['PENDING','ACCEPTED','PICKEUP',])->orwhere(function($query){
            //     $query->where('status','NOTPICKEDUP')->whereRaw('TIMESTAMPDIFF(day, updated_at, CURRENT_TIMESTAMP) > 5');
            // })
            $inbound_orders = UserRequests::where('status','=','PENDING')->orWhere('status','=','ACCEPTED')->orWhere('status','=','PICKEDUP')->orWhere(function($q){
                $q->where('status','=','NOTPICKEDUP')->whereRaw('TIMESTAMPDIFF(day, updated_at, CURRENT_TIMESTAMP) < 4');
            })->with(['user','item'])
            ->get();
            
            //dd($inbound_orders);
            return view('sortcenter.orders.inbound', compact('inbound_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function sortCenterOrders(){
        $requests=UserRequests::where('status','SORTCENTER')
                                    ->pluck('booking_id')
                                    ->toArray();
        return response($requests);
    }

    public function outbound()
    {
        try {
            $riders= Provider::where('status','approved')->orderBy('first_name','ASC')->get();
            return view('sortcenter.orders.outbound', compact('riders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function newOutbound(Request $request){
        $request->flash();
        DB::beginTransaction();
		try{
			if(isset($request->btn1) && $request->btn1==1)
			{
				$this->validate($request,[
                    'data' => 'required',
                    'rider' => 'required|exists:providers,id'
				]);
	
				$data=explode(",",$request->data);
                //set all to delivering and save to a batch
                foreach($data as $d){
                    $r=UserRequests::where('booking_id',$d)->first();
                    if($r->status!='SORTCENTER'){
                        throw new Exception($r->booking_id. " not found in sortcenter");
                    }
                    if($r==null){
                        throw new Exception("One or more orders not found in sortcenter");
                    }
                    $rider=Provider::findOrFail($request->rider);
                    $r->update([
                            'status'=>"DELIVERING",
                            'provider_id'=>$rider->id
                        ]);
                }
                DB::commit();
                $request->flush();
				return back()->with('message','Orders updated');
			}else{
				return back()->with('flash_error', 'Something went wrong!!');
			}
			
        }
        catch(Exception $e){
            DB::rollBack();
            return back()->withErrors([$e->getMessage()]);
        }
	}

    public function inboundOrder(Request $request, $req_id){
        
        try {
            $inbound_order = UserRequests::findOrFail($req_id);
            
            if($request->ajax()){
                if ($inbound_order->status=="PENDING" || $inbound_order->status=="ACCEPTED" || $inbound_order->status=="PICKEDUP"){
                    $inbound_order->provider_id = null;
                    $inbound_order->status = "SORTCENTER";
                    $inbound_order->save();
                    return response()->json([
                        'success' => true, 'message' => 'Order Inbound successful'
                    ]);
                }
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function insideValley()
    {
        try {
            $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;
            $requests = UserRequests::where('status','SORTCENTER')->where('zone2',$zoneKtm)->RequestHistory()->paginate(1000);
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();            
            
        //  return $requests;
            return view('sortcenter.orders.insideValley', compact('requests','totalRiders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function show($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            
            $promocode = $request->payment()->with('promocode')->first();

            $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
            $comments = Comment::where('request_id','=',$id)->orderBy('created_at', 'ASC')->get();

            foreach($comments as $comment){
                if ($comment->dept_id == $dept){
                    $dispatcherZone = DispatcherToZone::where('dispatcher_id', $comment->authorised_id)->pluck('zone_id')->first();
                    $comment->zone = Zones::where('id', $dispatcherZone)->pluck('zone_name')->first();
                }
            }
            $logs=OrderLog::where('request_id',$id)->orderBy('created_at','DESC')->get();


            // if(Auth::guard('dispatcher')->user()){
            //     return view('dispatcher.request.show', compact('request','promocode', 'comments'));    
            // }
            return view('sortcenter.orders.orderDetails', compact('request','promocode', 'comments','logs'));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function sortcenterComment(Request $request, $req_id){
        try{
            // $comment = new Comment();

            // $comment->request_id = $req_id;
            // //$comment->booking_id = $booking_id;
            // $comment->authorised_type = "admin";
            // $comment->authorised_id = Auth::user()->id;
            // $comment->comments = $request->input('admin_comment');
            // $comment->is_read_admin = '0';

            $dept = Department::where('dept', '=', 'Sortcenter')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = 'Sortcenter';
            $comment->comments = $request->input('comment');
            $comment->is_read_admin = '0';

            $comment->save();
            $solve_comment = UserRequests::findOrFail($req_id);
            $solve_comment->comment_status = 1;
            $solve_comment->update();

            return back()->with('flash_success', 'Your message has send!!!');
        } catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

     public Function exchangeOrder(Request $request){
        // dd($request->all());
        $order=UserRequests::find($request->trip_id);
        // dd($order);
        // $exchangeOrder=[];
        $request->request->add([
           'special_note' => 'This is exchnage Order of '.$order->booking_id,
    				'cod' => '',
    				'rec_name' => $order->item->rec_name,
    				'rec_mobile' =>  $order->item->rec_mobile,
    				's_address' => $order->s_address,
    				'd_address' =>  $order->d_address,
    				's_latitude' 	=> $order->s_latitude,
                    's_longitude' 	=> $order->s_longitude,
                    'd_latitude' 	=>  $order->d_latitude,
                    'd_longitude' 	=>  $order->d_longitude,
    				'device' => 'WEB',
                'service_type' => 1,
                'payment_mode' => 'CASH',
                'weight' => $order->weight,
                'cargo'=>'0',
                'phone' => $order->Pickedup_number,
                'exchage_order_id' => $order->booking_id,
                'user_id'=>$order->user_id,
        ]);
        // dd($request->all());
        try{
        $ajaxController= new AjaxHandlerController($this->UserAPI);
            $fares= $ajaxController->estimated_fare($request);
            // dd($fares);
            $request->request->add([
                'distance' => $fares->getData()->distance,
                'fare' => $fares->getData()->estimated_fare,
                ]);
    		$data = $this->UserAPI->send_requestSupport($request);
            // dd($data);
            if(isset($data->getData()->error) && $data->getData()->error=='dashboard')
            {
                if($request->ajax()){
                     $order->exchange=1;
                     $log=new OrderLog();
                        $log->create([
                            'request_id'=>$order->id,
                            'type' => "status",
                            'description' => 'Exchange Order Placed by '.Auth::user()->name,
                        ]);
                     $order->save();
                     return redirect('dashboard')->with('flash_success', 'Your Order has been placed in Exchange Successfully');
                }
                $item=Items::latest()
                    ->first()
                    ->update(['request_id'=> $data->getData()->request_id]);
                    $order->exchange=1;
                    $log=new OrderLog();
                        $log->create([
                            'request_id'=>$order->id,
                            'type' => "status",
                           'description' => 'Exchange Order Placed By '.Auth::user()->name,
                        ]);
                    $order->save();
                    if(Auth::guard('return')->user()){
                        return redirect('return/dashboard')->with('flash_success', 'Your Order has been placed in Exchange Successfully');
                    }
                return redirect('sortcenter/dashboard')->with('flash_success', 'Your Order has been placed in Exchange Successfully');
            }
             if(Auth::guard('return')->user()){
                        return redirect('return/dashboard')->with('flash_error', 'Something Went Wrong! Please Try Again Later');
                    }
             return redirect('sortcenter/dashboard')->with('flash_error', 'Something Went Wrong! Please Try Again Later');
        }
        catch (Exception $e) {
             if(Auth::guard('return')->user()){
                        return redirect('return/dashboard')->with('flash_error', 'Something Went Wrong! Please Try Again Later');
                    }
            
             return redirect('sortcenter/dashboard')->with('flash_error', 'Something Went Wrong! Please Try Again Later');
        } 
    }
    public function commentSortcenter(Request $request, $req_id){
        try{

            $dept = Department::where('dept', '=', 'Sortcenter')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = 'Sortcenter';
            $comment->comments = $request->input('comment');
            $comment->is_read_admin = '0';
            $comment->save();
            $solve_comment = UserRequests::findOrFail($req_id);
            $solve_comment->comment_status = 1;
            $solve_comment->update();

            //notify

            $noti = new Notification;
            $token= $solve_comment->user->device_key;
            $title = 'Comment Received';
            $body = 'New comment received for your order of '.$solve_comment->item->rec_name.', '.$solve_comment->d_address;
            $noti->toSingleDevice($token,$title,$body,null,null,$solve_comment->user->id,$solve_comment->id);

            return back()->with('flash_success', 'Your message has send!!!');
        } catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
    public function rider()
    {
        try {
            $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;
            $riders = Provider::where('zone_id',$zoneKtm)
                            ->where('status','approved')
                            ->paginate(10);
            return view('sortcenter.orders.rider', compact('riders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function searchRider(Request $request)
    {
        try {
            if(isset($request->search)){
            $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;
            $riders = Provider::where('zone_id',$zoneKtm)
                            ->where('first_name','LIKE','%'.$request->searchField.'%')
                            ->orWhere('email','LIKE','%'.$request->searchField.'%')
                            ->orWhere('mobile','LIKE','%'.$request->searchField.'%')->paginate(10);
            }
            return view('sortcenter.orders.rider', compact('riders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }   
    }

    public function order($id,$status)
    {
        try{
            $order=UserRequests::where('provider_id',$id)
                                ->where('status',$status)->get();
            return view('sortcenter.orders.orderdetail', compact('order','status'));
        }
        catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');

        }
    }
    // public function scheduleorder($id)
    // {
    //     try{
    //         $order=UserRequest::where('provider_id',id)
    //                             ->where('status','SCHEDULED');
    //     }
    //     catch (Exception $e) {
    //         return back()->with('flash_error','Something Went Wrong!');

    //     }
    public function bulk_inbound(){
        try{
            return view('sortcenter.orders.bulk_inbound');

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');

        }
    }

    public function bulk_inbound_post(Request $request){
        DB::beginTransaction();
		try{
			if(isset($request->btn1) && $request->btn1==1)
			{
				$this->validate($request,[
                    'data' => 'required',
				]);
	
				$data=explode(",",$request->data);
                //set all to delivering and save to a batch
                foreach($data as $d){
                    $order=new DateInbound;
                    $r=UserRequests::where('booking_id',$d)->first();
                    if($r==null){
                        throw new Exception("One or more orders not found ");
                    }
                    $r->update([
                            'status'=>"SORTCENTER",
                            'provider_id'=>null
                        ]);
                    $order->create([
                        'Booking_id'=>$d,
                    ]);
                }
                DB::commit();
				return back()->with('message','Orders updated');
			}else{
				return back()->with('flash_error', 'Something went wrong!!');
			}
			
        }
        catch(Exception $e){
            DB::rollBack();
            return back()->withErrors([$e->getMessage()]);
        }
    }
    public function ktm(){
        try {
            $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;

            $remaining_data=UserRequests::whereIn('status',['DELIVERING','SORTCENTER','SCHEDULED'])->whereDate('created_at', '<=', Carbon::today()->setTime(11, 00, 00)->toDateTimeString())->where('zone2',$zoneKtm)->get();
            return view('sortcenter.orders.ktm_delivery_remaining',compact(['remaining_data']));
       } 
       catch (Exception $e) {
           return back()->with('flash_error', 'Order Not Found');
       }
    }
    public function inBound(Request $request){
    if(isset($request->search))
    {
        $inbound=DateInbound::where('created_at', 'LIKE' ,'%'.$request->date.'%')->get();
        if($request->searchField){
            $inbound=DateInbound::where('booking_id', 'LIKE' ,'%'.$request->searchField.'%')->get();
        }

        
        return view('sortcenter.orders.dateinbound',compact('inbound'));
    }
    else
    {
        $inbound=[];
        return view('sortcenter.orders.dateinbound',compact('inbound'));
    }

    }
    
}
