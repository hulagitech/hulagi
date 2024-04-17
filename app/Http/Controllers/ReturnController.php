<?php

namespace App\Http\Controllers;

use DB;

use Log;
use Auth;
//use DB as NewDB;
use Setting;
use App\Fare;
use App\User;
use DateTime;
use App\Zones;
use Exception;
use App\Comment;

use App\OrderLog;
use App\Provider;
use App\RiderLog;
use App\Complaint;
use Carbon\Carbon;
use App\Department;
use App\ReturnUser;
use App\ServiceType;

use App\UserRequests;
use App\RequestFilter;

use App\Helpers\Helper;
use App\PaymentHistory;
use App\ProviderService;

use App\CorporateAccount;
use App\DispatchBulkList;
use App\DispatcherToZone;
use App\ZoneDispatchList;
use App\Model\Notification;
use Illuminate\Http\Request;
use App\AssignedRidersHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB as NewDB;
use App\Http\Controllers\RiderLogController;
use Illuminate\Support\Facades\Notification as Notify;
use App\Notifications\CompletedOrderNortification;


class ReturnController extends Controller
{

    /**
     * ReturnUser Panel.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    protected $UserAPI;
	protected $ip_details = null;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI)
    {
        //$this->middleware('auth');
        $this->UserAPI = $UserAPI;
		
	}


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index()
    {
        return view('return.dashboard');
    }
    
    public function dashboard()
    {
        $mytime = Carbon::now();
        $services  	= 	ServiceType::all();
		$companies  =	NewDB::table('fleets')->get();
		$complaint  =   Complaint::count();
        $open_ticket =  Complaint::where('status','1')->count();
        $close_ticket =  Complaint::where('status','0')->count();
        $newticket = Complaint::whereDate('created_at',$mytime->toDateString())->where('status',1)->count();
        $ip_details =	$this->ip_details;
        
		if(Auth::guard('admin')->user()){
			return view('return.dashboard', compact('services', 'ip_details', 'companies','complaint','open_ticket','close_ticket','newticket'));
        }elseif(Auth::guard('return')->user()){
            return view('return.dashboard', compact('services', 'ip_details', 'companies','complaint','open_ticket','close_ticket','newticket'));
        }
    }

    public function profile()
    {
        return view('return.account.profile');
    }

    public function profile_update(Request $request)
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }
        $this->validate($request,[
            'name' => 'required|max:255',
            'mobile' => 'required|digits_between:6,13',
        ]);
        try{
            $return = Auth::guard('return')->user();
            $return->name = $request->name;
            $return->mobile = $request->mobile;
            //$account->save(); 
            return redirect()->back()->with('flash_success','Profile Updated');
        }
        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
    }
    public function password(){
        return view('return.account.change-password');
    }
    public function password_update(Request $request)
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error','Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

           $Return = ReturnUser::find(Auth::guard('return')->user()->id);

            if(password_verify($request->old_password, $Return->password))
            {
                $Return->password = bcrypt($request->password);
                $Return->save();

                return redirect()->back()->with('flash_success','Password Updated');
            }
            else{
                return back()->with('flas_error','checkpassword');
            }
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    // To Be Return Orders List
    public function tobe_return(){
        try {
            $return_orders = UserRequests::where(function($query){
                $query->where('returned', '=', '0')
                        ->where('returned_to_hub', '=', '0');
            })->where(function($query){
                $query->where('status', '=', 'CANCELLED')
                        ->orWhere('status', '=', 'REJECTED');
            })->paginate(100);
            return view('return.request.return', compact('return_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function inboundSearch(Request $request){
        try {
            if($request->has('searchField')){
                $return_orders = UserRequests::where('returned', '=', '0')
                ->where('returned_to_hub', '=', '0')
                ->whereIn('status',['CANCELLED','REJECTED'])
                ->whereHas('user',function($query) use ($request){
                            $query->where('first_name', 'LIKE' ,'%'.$request->searchField.'%')
                            ->orWhere('first_name', 'LIKE' ,'%'.$request->searchField.'%')
                            ->orWhere('mobile', 'LIKE' ,'%'.$request->searchField.'%')
                            ->orWhere('booking_id','LIKE','%'.$request->searchField.'%');
                        })->orWhereHas('item',function($query) use ($request){
                            $query->where('rec_name', 'LIKE' ,'%'.$request->searchField.'%')	
                            ->orWhere('rec_mobile', 'LIKE' ,'%'.$request->searchField.'%');
                        })->where('returned', '=', '0')->where('returned_to_hub', '=', '0')->whereIn('status',['CANCELLED','REJECTED'])
                    
              ->paginate(100);
        }
            return view('return.request.return', compact('return_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    // Change tobereturn into Arrive in Hub.
    public function orderIn_hub(Request $request, $req_id){
        try {
            $order_checkin = UserRequests::findOrFail($req_id);
            if($request->ajax()){
                if ($order_checkin->status=="CANCELLED" || $order_checkin->status=="REJECTED"){
                    $order_checkin->returned_to_hub = '1';
                    $log=new OrderLog();
                        $log->create([
                            'request_id'=>$order_checkin->id,
                            'type' => "Return inbound",
                            'description' => 'Order has been received by Head Office'
                        ]);
                }
                $order_checkin->save();
            }
            return response()->json([
                'request' => $request,
                //'error' => $a
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    // All Return Order in Hub List.
    public function allorder_inhub(){
        try {
            $requests = UserRequests::groupBy('user_id')
            ->select('user_id','status','provider_id','s_address','hold_date',
                    DB::raw('count(*) as count'))
            ->where(function($query){
                $query->where('returned', '=', '0')
                    ->where('returned_to_hub', '=', '1');
                })
               ->where('return_rider','=',null)
            ->get();
            foreach($requests as $request){
                $r = UserRequests::where('user_id',$request->user_id)
                                    ->where('status','=','PENDING')->count();
                $request->r=$r;
            }
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->where('type','pickup')->orderBy('first_name')->get();
            return view('return.request.inHub', compact(['requests','totalRiders']));
        }   catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    // Rider Assign to return orders towards vendor.
    public function return_Rider(Request $request, $id){
        try {
            // dd("hello");
           
            $returnRider = UserRequests::where('user_id',$id)
            ->where(function($query){
                $query->where('returned', '=', '0')
                    ->where('returned_to_hub', '=', '1');
                })->where(function($query){
                    $query->where('status', '=', 'CANCELLED')
                    ->orWhere('status', '=', 'REJECTED');
                })->where('return_rider','=',null)->update(array('return_rider'=>$request->provider));
            $UserRequest = UserRequests::where('user_id',$id)->where(function($query){
                    $query->where('returned', '=', '0')
                        ->where('returned_to_hub', '=', '1');
                    })->where(function($query){
                        $query->where('status', '=', 'CANCELLED')
                        ->orWhere('status', '=', 'REJECTED');})->first();
                // dd($UserRequest->returnRider);
            $noti = new Notification;
            $token= $UserRequest->user->device_key;

            $title = 'Dear '.$UserRequest->user->first_name;
            $body = 'Your return product is being returned by Rider: '.$UserRequest->returnRider->first_name . ' You can call in this number = ' .$UserRequest->returnRider->mobile . ' to confirm your return.';
            
            $notice = [
                'title'=> $title,
                'body'=>$body,
                'order_id'=>$UserRequest->id
            ];
            Notify::send($UserRequest->user, new CompletedOrderNortification($notice));
            if($token){
                $noti->toSingleDevice($token,$title,$body,null,null,$UserRequest->user->id,$UserRequest->id);
            }
            return response()->json([
                'request' => $returnRider,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    
    // Change "return orders in Hub" to "Order Completed"
    public function return_completed(Request $request, $req_id){
        try {
            $returnRider = UserRequests::where('user_id',$req_id)
            ->where(function($query){
                $query->where('returned', '=', '0')
                    ->where('returned_to_hub', '=', '1');
                })->where(function($query){
                    $query->where('status', '=', 'CANCELLED')
                    ->orWhere('status', '=', 'REJECTED');
                })->where('return_rider','!=',null)
                ->update(array('returned'=>'1'));
            return response()->json([
                'request' => $returnRider,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function return_incompleted(Request $request, $req_id){
        try {
            $returnRider = UserRequests::where('user_id',$req_id)
            ->where(function($query){
                $query->where('returned', '=', '0')
                    ->where('returned_to_hub', '=', '1');
                })->where(function($query){
                    $query->where('status', '=', 'CANCELLED')
                    ->orWhere('status', '=', 'REJECTED');
                })->where('return_rider','!=',null)
                ->update(array('return_rider'=>null));
            return response()->json([
                'request' => $returnRider,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function return_details($id){
        try {
            $return_orders = UserRequests::where('user_id',$id)
            ->where(function($query){
                $query->where('returned', '=', '0')
                    ->where('returned_to_hub', '=', '1');
                })
               ->where('return_rider','=',null)
            ->get();
            return view('return.request.details', compact(['return_orders']));
        }   catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }
    public function hold($id){
        try {
            $return_orders = UserRequests::where('user_id',$id)
            ->where(function($query){
                $query->where('returned', '=', '0')
                    ->where('returned_to_hub', '=', '1');
                })
               ->where('return_rider','=',null)
            ->get();
            foreach($return_orders as $return_order){
                $return_order->hold_date = Carbon::now();
                $return_order->save();
            }
            return back()->with('flash_success', 'This order has been put on hold.');
        }   catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }
    
    // Return Completed List.
    public function returned_order(){
        try {
            $return_orders = UserRequests::groupBy('user_id')
            ->select('user_id','status','return_rider','s_address','updated_at',
                    DB::raw('count(*) as count'))
            ->where(function($query){
                $query->where('returned', '=', '0')
                    ->where('returned_to_hub', '=', '1');
                })
               ->where('return_rider','!=',null)
            ->get();
            return view('return.request.returnedOrder', compact('return_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    // ___________________________________________________________________________________
    //             Order Comments
    // -----------------------------------------------------------------------------------
    public function returnUnsolve()
    {
        try{
            $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->paginate(100);
            $dep =Department::where('dept',"=",'Returns')->pluck('id')->first();
            foreach($allOrderComments as $allOrderComment){
                $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status','=','0')->first();
                $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
                $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->count();
            }
            return view('return.ordercomment.rerturnComment', compact('allOrderComments','dep'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    
    }

    public function solved_Comments()
    {
        try{
            $dept = Department::where('dept', '=', 'Return')->pluck('id')->first();
            $orderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '1')
                                ->where('user_requests.dept_id', $dept)
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->get();
            foreach($orderComments as $orderComment){
                $orderComment->ur = UserRequests::where('id','=',$orderComment->request_id)->where('comment_status', '=', '1')->first();
                $orderComment->user = User::where('id','=',$orderComment->ur->user_id)->first();
                $orderComment->noComment = Comment::where('request_id', $orderComment->request_id)->where('is_read_return','=',"1")->count();
            }
            return view('return.ordercomment.solvedComment', compact('orderComments'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }


    public function orderComment_Detail($id){
        try{
            $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
            $comments = Comment::where('request_id','=',$id)->orderBy('created_at', 'ASC')->get();
            foreach($comments as $comment){
                if ($comment->dept_id == $dept){
                    $dispatcherZone = DispatcherToZone::where('dispatcher_id', $comment->authorised_id)->pluck('zone_id')->first();
                    $comment->zone = Zones::where('id', $dispatcherZone)->pluck('zone_name')->first();
                }
            }
            $user_req = UserRequests::where('id', $id)->first();
            $depts = Department::orderBy('dept')->get();
            return view('return.ordercomment.comment_page', compact('comments', 'user_req', 'depts'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function orderCommentReply(Request $request, $req_id){
        try{
            $dept = Department::where('dept', '=', 'Return')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->comments = $request->input('comment');
            $comment->is_read_return = '0';
            $comment->save();
            return back()->with('flash_success', 'Your comment has send!!!');
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // To make Solved Order
    public function solvedOrder(Request $request, $req_id){
        try{
            $solve_order = UserRequests::findOrFail($req_id);
            $solve_order->comment_status = $request->input('status');

            $solve_order->update();
            return redirect('/return/unsolve_comments')->with('flash_success', 'Order problem solved successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // To make Unsolve Order
    public function unsolveOrder(Request $request, $req_id){
        try{
            $unsolve_order = UserRequests::findOrFail($req_id);
            $unsolve_order->comment_status = $request->input('status');

            $unsolve_order->update();
            return redirect('/return/solved_comments')->with('flash_success', 'Order problem reopen Successfully!');
        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // public function orderDepartment(Request $request, $id)
    // {
    //     try {
    //         $ur = UserRequests::findOrFail($id);
    //         if($request->ajax()) {
    //             $ur->dept_id= $request->department;
    //             $ur->save();
    //         }
    //         $a = $ur;
    //         return response()->json([
    //             'request' => $request,
    //             'error' => $a
    //         ]);
    //     }
    //     catch (Exception $e) {
    //         return response()->json([
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

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
                $totalRiders=Provider::select("id","first_name")->where("status","approved")->where('type','pickup')->orderBy('first_name')->get();
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
                Session::flash('success','Data Loaded Sucessfully');
                return view('return.orders.orderByDate', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates', 'current']));
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
              
                return view('return.orders.orderByDate', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error',$e->getMessage());
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


            return view('return.orders.orderDetails', compact('request','promocode', 'comments','logs'));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function returnComment(Request $request, $req_id){
        try{
            $dept = Department::where('dept', '=', 'Returns')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = 'Return';
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
            return back()->with('flash_error', $e->getMessage());
        }
    }

    // update the value
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


                    if($UserRequest->cargo=='1'){
                        // $new_fare = $request->weight*$UserRequest->fare;
                        $new_fare = $UserRequest->fare * $request->weight;
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
                    $request->request->add([
                        'amount_customer' => $new_fare
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
                    $UserRequest->amount_customer= $request->amount_customer;
                }
                else if(isset($request->status)){
                    if($request->status=="REJECTED" && !$UserRequest->rejected_at) {
                        $UserRequest->rejected_at = Carbon::now();
                        $UserRequest->save();
                    }

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
                else if(isset($request->ReturnRider)){
                    if($request->ReturnRider=="N/A" || $request->ReturnRider=="Select Rider"){
                        AssignedRidersHistory::create([
                            'request_id'=>$UserRequest->id,
                            'rider_id'=>$UserRequest->return_rider,
                            'status'=>$UserRequest->status
                        ]);
                        $UserRequest->return_rider=null;    
                    }
                    else{
                        $UserRequest->return_rider= $request->ReturnRider;
                        $noti = new Notification;
                        $token= $UserRequest->user->device_key;

                        $title = 'Dear '.$UserRequest->user->first_name;
                        $body = 'Your order of '. $UserRequest->item->rec_name.' from '.$UserRequest->item->rec_address. ' is being returned by '.$UserRequest->returnRider->first_name . '
                        You can call in this .' .$UserRequest->returnRider->mobile . ' to confirm the return.';
                        
                        $notice = [
                            'title'=> $title,
                            'body'=>$body,
                            'order_id'=>$UserRequest->id
                        ];
                        Notify::send($UserRequest->user, new CompletedOrderNortification($notice));
                        $noti->toSingleDevice($token,$title,$body,null,null,$UserRequest->user->id,$UserRequest->id);
                        if($UserRequest->status=="COMPLETED" || $UserRequest->status=="REJECTED" || $UserRequest->status=="SCHEDULED"){
                            $logRequest=new Request();
                            $logRequest->replace([
                                'request_id' => $id,
                                'complete_id' => $UserRequest->return_rider,
                                'complete_remarks' => 'Rider Changed'
                            ]);
                            $riderLog=new RiderLogController;
                            $riderLog->create($logRequest);
                        }
                        AssignedRidersHistory::create([
                            'request_id'=>$UserRequest->id,
                            'rider_id'=>$UserRequest->return_rider,
                            'status'=>$UserRequest->status
                        ]);
                        // $rider = UserRequests::where('id', $id)->pluck('provider_id')->first();
                        // return response()->json([
                        //     'message' => $rider,
                        // ]);
                }
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

    public function riderInside(){
        try{
             $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;

           $providers= Provider::where('zone_id',$zoneKtm)->get();
           foreach($providers as $provider){
            $provider->delivering_delay=UserRequests::where('status','Delivering')
                            ->where('provider_id',$provider->id)
                            ->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 5')->count();
           $provider->schedule_delay=UserRequests::where('status','SCHEDULED')
                            ->where('provider_id',$provider->id)
                            ->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 6')->count();
           }        
           return view('return.orders.rider',compact('providers'));

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function riderOutside(){
        try{
             $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;

           $providers= Provider::where('zone_id','!=',$zoneKtm)->get();
           foreach($providers as $provider){
            $provider->delivering_delay=UserRequests::where('status','Delivering')
                            ->where('provider_id',$provider->id)
                            ->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 5')->count();
           $provider->schedule_delay=UserRequests::where('status','SCHEDULED')
                            ->where('provider_id',$provider->id)
                            ->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 6')->count();
           }        
           return view('return.orders.rider',compact('providers'));
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function searchRider(Request $request)
    {
        try {
            if(isset($request->search)){
            $providers = Provider::where('first_name','LIKE','%'.$request->searchField.'%')
                            ->orWhere('email','LIKE','%'.$request->searchField.'%')
                            ->orWhere('mobile','LIKE','%'.$request->searchField.'%')->paginate(10);
            }
            return view('return.orders.rider', compact('providers'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }   
    }

    public function returnRemaining($id,$status){
        try{
             $request=UserRequests::where('provider_id',$id)->where('status',$status)->where('returned_to_hub',0)->where('returned',0)->get();
             $rider=Provider::where('id',$id)->first();
            //  dd($request);
            return view('return.orders.remaining',compact('request','rider','status'));

        }catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function return_inbound(){
        try{
            return view('return.orders.return_inbound');

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');

        }
    }

     public function return_inbound_post(Request $request){
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
                    $r=UserRequests::where('booking_id',$d)->first();
                    if($r==null){
                        throw new Exception("One or more orders not found ");
                    }
                    $r->update([
                            'returned_to_hub'=>1,
                            'returned'=>0
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
    public function delaysearch()
    {
        
        $log=UserRequests::where('status','Rejected')
                        ->where('returned_to_hub','1')
                        ->where('returned','0')
                        ->whereRaw('TIMESTAMPDIFF(day,updated_at, CURRENT_TIMESTAMP) >= 5')
                        ->get();
        return view('return.request.returndelay',compact('log'));
    }
    public function SearchRiderDetailOrder($status,$id){
        try {
            if($status=="REJECTEDTO"){
                $requests=UserRequests::where('status','REJECTED')->where('provider_id',$id)->where('returned_to_hub',0)
                ->where('returned',0)->get();
            }elseif($status=="DELIVERING"){
                $requests=UserRequests::where('status',$status)
                    ->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 5')->get();
            }elseif($status=="SCHEDULED"){
                $requests=UserRequests::where('status',$status)
                    ->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 6')->get();
            }
            else{

                $requests=UserRequests::where('status',$status)->where('provider_id',$id)->where('returned_to_hub',0)->where('returned',0)->get();
            }
            $index=0;
            foreach($requests as $request){
                $request->comments = Comment::where('request_id','=',$request->id)->orderBy('created_at', 'ASC')->get();
                $request->logs=OrderLog::where('request_id',$request->id)->orderBy('created_at','DESC')->get();
            }
            return view('return.layout.Order', compact('requests',));
        
        }   catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);

        }

    }
    public function outsideReturnOrder(){
        try {
			$id=DispatchBulkList::where('Returned','1')->pluck('id')->toArray();
            // dd($id);
            $requestsid=ZoneDispatchList::whereIn('dispatch_id',$id)->pluck('request_id')->toArray();
            $Order=UserRequests::whereIn('id',$requestsid)->get();
            return view('return.orders.outsideReturn',compact('Order'));
        //    $Order=UserRequests::whereIn('id',$requestid)->get();
           return $Order;
            }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}
