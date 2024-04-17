<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use Session;
use Setting;
//use DB as NewDB;
use App\User;
use DateTime;
use App\Items;
use App\Zones;
use Exception;

use App\Ticket;
use App\Comment;
use App\OrderLog;
use App\Provider;
use App\RiderLog;
use App\Complaint;
use Carbon\Carbon;
use App\Department;
use App\ServiceType;
use App\SupportUser;

use App\UserRequests;
use App\RequestFilter;
use App\Helpers\Helper;


use App\ProviderService;
use App\CorporateAccount;
use App\DispatcherToZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as NewDB;


class SupportController extends Controller
{

    /**
     * SupportUser Panel.
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
    
    public function dashboard()
    {
        $mytime = Carbon::now();
        $services  	= 	ServiceType::all();
// 		$all_zones	=	$this->getZonesWithProvider();
		$companies  =	NewDB::table('fleets')->get();
		$complaint  =   Complaint::count();
        $open_ticket =  Complaint::where('status','1')->count();
        $close_ticket =  Complaint::where('status','0')->count();
        $newticket = Complaint::whereDate('created_at',$mytime->toDateString())->where('status',1)->count();
        $ip_details =	$this->ip_details;

        $todayTicket = Ticket::where('created_at','LIKE',date("Y-m-d").'%')->count();
        $openTicket = Ticket::where('status', '=', 'open')->count();
        $closeTicket = Ticket::where('status', '=', 'close')->count();

        // $unsolve_orders = UserRequests::where('comment_status', '=', '0')->get();
        // foreach($unsolve_orders as $unsolve_order){
        //     $unsolve_comment = Comment::where('request_id', '=', $unsolve_order->id)->get()->count();
        // }
        $unsolve_comment = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->count();
        
        // $solve_orders = UserRequests::where('comment_status', '=', '1')->get();
        // foreach($solve_orders as $solve_order){
        //     $solve_comment = Comment::where('request_id', '=', $solve_order->id)->get()->count();
        // }

        $solve_comment = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '1')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->count();
        $tickets=Ticket::where('status', '=', 'open')->orderby('id','desc')->paginate(3);
         $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'Desc')
                                ->having('count', '>=', 1)
                                ->paginate(50);

            foreach($allOrderComments as $allOrderComment){
                $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status','=','0')->orderby('id','desc')->first();
                $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
                $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->orderby('id','desc')->where('is_read_cs','=',"1")->count();
                $allOrderComment->comment = Comment::where('request_id', $allOrderComment->request_id)->orderby('id','desc')->first();
            }
        // return $allOrderComments;
		return view('support.dashboard', compact('services', 'ip_details','allOrderComments','tickets', 'companies','complaint','open_ticket','close_ticket','newticket', 'todayTicket', 'openTicket', 'closeTicket', 'unsolve_comment', 'solve_comment'));
    }
         /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('support.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
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

            $account = Auth::guard('support')->user();
            $account->name = $request->name;
            $account->mobile = $request->mobile;
            // $account->save(); 
            return redirect()->back()->with('flash_success','Profile Updated');
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
    }

    public function openTicket($type){

        $mytime = Carbon::now();
        if($type == 'new'){

            $data = Complaint::whereDate('created_at',$mytime->toDateString())->where('status',1)->get();
            $title = "New Queries";

        }
        if($type == 'open'){

            $data = Complaint::where('status',1)->get();
            $title = "Open Queries";
        }
        else{

            $data = Complaint::where('status',0)->get();
            $title = "Close Queries";
        }

       
        return view('support.open_ticket', compact('data','title'));
    }
    
        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('support.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
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

           $Account = SupportUser::find(Auth::guard('support')->user()->id);

            if(password_verify($request->old_password, $Account->password))
            {
                $Account->password = bcrypt($request->password);
                $Account->save();

                return redirect()->back()->with('flash_success','Password Updated');
            }
            else{
                return back()->with('flash_error','check your password!');
            }
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }
        
    public function closeTicket(){

        $data = Complaint::where('status',0)->get();
        return view('support.close_ticket', compact('data'));
    }
    public function openTicketDetails($id){

        $data = Complaint::where('id',$id)->first();
        return view('support.open_ticket_details', compact('data'));
    }
    public function transfer($id,Request $request){

        $data = Complaint::where('id',$id)->first();
        $data->status = $request->status;
        $data->transfer = $request->transfer;
        $data->reply = $request->reply;
        $data->save();
        // sendMail('Ticket System',$data->email,$data->name,'Ticket System');
        return redirect()->back()->with('flash_success','Ticket Updated');
       
    }

    public function cs_orderSearch()
    {
        return view('support.request.index');
    }


    // public function allRequests()
    // {
    //     try {
    //         $requests = UserRequests::where('status','!=','CANCELLED')->RequestHistory()->get();
    //         foreach($requests as $request){
    //             $request->log=RiderLog::where('request_id',$request->id)->first();
    //         }
    //         $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
    //         $totalrequest = UserRequests::count();
    //         $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
    //         $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
    //         return view('support.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount','totalRiders']));
    //     }   catch (Exception $e) {
    //         return back()->with('flash_error','Something Went Wrong!');
    //     }
    // }

    public function dateSearch(Request $request)
    {
        try {
            if(isset($request->search)){
                if($request->date=="All"){
                    $request->date='';
                }
                if($request->to_date==""){
                    $tom=new DateTime('tomorrow');
                    $request->to_date=$tom->format('Y-m-d');
                }
                else if($request->from_date=""){
                    $tod=new DateTime('today');
                    $tod->modify('-1 month');
                    $request->from_date=$tod->format('Y-m-d');
                }
                // dd($request->request);
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
                        $requests = UserRequests::where(function($query) use ($request){
                                        $query->where('created_at','>=',$request->from_date)
                                        ->orWhere('updated_at','>=',$request->from_date);
                                    })
                                    ->where(function($query) use ($request){
                                        $query->where('created_at','<=',$request->to_date)
                                        ->orWhere('updated_at','<=',$request->to_date);
                                    })
                                    ->where('status',$request->status);
                        if($request->status=="TOBERETURNED" || $request->status=="RETURNED"){
                            $requests = UserRequests::where(function($query) use ($request){
                                            $query->where('created_at','>=',$request->from_date)
                                            ->orWhere('updated_at','>=',$request->from_date);
                                        })
                                        ->where(function($query) use ($request){
                                            $query->where('created_at','<=',$request->to_date)
                                            ->orWhere('updated_at','<=',$request->to_date);
                                        })
                                        ->whereIn('status',["CANCELLED","REJECTED"])
                                        ->where("returned",$request->status=="RETURNED");
                        }
                        $current['status']=$request->status;
                    }
                    else{
                        $requests = UserRequests::where(function($query) use ($request){
                                        $query->where('created_at','>=',$request->from_date)
                                        ->orWhere('updated_at','>=',$request->from_date);
                                    })
                                    ->where(function($query) use ($request){
                                        $query->where('created_at','<=',$request->to_date)
                                        ->orWhere('updated_at','<=',$request->to_date);
                                    });
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
                
                //$requests=$requests->get();
                // Multilevel Pagination
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
                return view('support.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates', 'current']));
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
                return view('support.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function dropoffNo(Request $request, $id)
    {
        try {
            if($request->rec_mobile){

           
            $item = Items::where('request_id', '=', $id)->first();
            if($request->ajax()) {
                $item->rec_mobile = $request->rec_mobile;
                $item->save();
            }
            $a = $item;
        }else{
            $item = UserRequests::where('id', '=', $id)->first();
        
            if($request->ajax()) {
                $item->status = $request->status;
                $item->returned='1';
                $item->save();
            }
            $a = $item;
            
        }
            return response()->json([
                'request' => $request,
                'error' => $a
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function statusChange(Request $request, $id)
    {
        
        try {
            $item = UserRequests::where('id', '=', $id)->first();
        
            if($request->ajax()) {
                $item->status = $request->status;
                $item->returned='1';
                $item->save();
            }
            $a = $item;
            return response()->json([
                'request' => $request,
                'error' => $a
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function change_cargo(Request $request, $req_id){
        try {
            $UserRequest = UserRequests::findOrFail($req_id);
            if($request->cargo==0){
                $UserRequest->cargo = $request->cargo;
                $UserRequest->amount_customer = $UserRequest->fare;
                $UserRequest->save();
                    return response()->json([
                        'request' => $request,
                        'error' => $UserRequest
                    ]);
            }
            else{           
            // return $UserRequest->zone_1;
                $cargo=Fare::where('zone1_id',$UserRequest->zone1)->where('zone2_id',$UserRequest->zone2)->where('cargo',1)->first();
                if($cargo){
                    if($request->ajax()) {
                        if(isset($request->cargo)){
                            $UserRequest->cargo = $request->cargo;
                            $UserRequest->amount_customer = $UserRequest->weight * Setting::get('cargo_amount');
                        }
                    }
                    $a=$UserRequest->save();
                    return response()->json([
                        'request' => $request,
                        'error' => $a
                    ]);
                }
                else{
                    return response()->json([
                        'request' => $request,
                        'error' => "No Cargo"
                    ],400);
                }
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
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
            $depts = Department::orderBy('dept')->get();
            // if(Auth::guard('dispatcher')->user()){
            //     return view('dispatcher.request.show', compact('request','promocode', 'comments'));    
            // }
            return view('support.request.orderDetails', compact('request','promocode', 'comments','logs','depts'));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function supportComment(Request $request, $req_id){
        try{
            $dept = Department::where('dept', '=', 'Customer Service')->pluck('id')->first();

            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = 'Customer Support';
            $comment->comments = $request->input('comment');
            $comment->is_read_admin = '0';

            $comment->save();
            return back()->with('flash_success', 'Your message has send!!!');
        } catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
    public function users(Request $request)
    {
        if(isset($request->search)){
            $users = User::orderBy('created_at' , 'desc')
                        ->where('first_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('last_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('company_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('email','LIKE','%'.$request->searchField.'%')
                        ->orWhere('mobile','LIKE','%'.$request->searchField.'%')
                        ->get();
            $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
            $revenue = User::sum('wallet_balance');
            return view('support.request.orderDetails', compact('request','promocode', 'comments'));
            return view('support.users.index', compact('users','rides','revenue'));
            
        }
    }
    public function changeuserpassword(Request $request)
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error','Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request,[
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        try {
            
            $provider = User::findOrFail($request->id);
			if( !$provider  ) {
				throw new Exception('Provider Not Found');
			}
            
            if($request->password!="")
            {
                $provider->password = bcrypt($request->password);
            }
            $provider->save();

            return redirect()->back()->with('flash_success', 'Password Updated Successfully'); 
           
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

}
