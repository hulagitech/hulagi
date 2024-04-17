<?php

namespace App\Http\Controllers;

use Setting;

use App\User;
use App\Ticket;
use App\Comment;
use App\OrderLog;
use App\Complaint;
use Carbon\Carbon;
use App\Department;
use App\UserRequests;
use App\TicketComment;
use App\Model\Notification;
use Illuminate\Support\Facades\Notification as Notify;
use Illuminate\Http\Request;
use App\Model\SortCenterUser;
use App\AssignedRidersHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SortCenterController extends Controller
{
  public function dashboard(){
        $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->
            where('created_at','LIKE',date("Y-m-d").'%')->count();
        $completed_rides = UserRequests::where('status','COMPLETED')->
            where('created_at','LIKE',date("Y-m-d").'%')->count();
        $rejected_rides = UserRequests::where('status','REJECTED')->
            where('rejected_at','LIKE',date("Y-m-d").'%')->count();
        $scheduled_rides = UserRequests::where('status','SCHEDULED')->
                where('created_at','LIKE',date("Y-m-d").'%')->count();
        $sortcenter = UserRequests::where('status','SORTCENTER')->
                    where('created_at','LIKE',date("Y-m-d").'%')->count();
        $delivering = UserRequests::where('status','DELIVERING')->
                where('created_at','LIKE',date("Y-m-d").'%')->count();
        $assigned = UserRequests::where('status','ASSIGNED')->
            where('created_at','LIKE',date("Y-m-d").'%')->count();
            
            // total data 
        $total_rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
        $total_completed_rides = UserRequests::where('status','COMPLETED')->count();
        $total_rejected_rides = UserRequests::where('status','REJECTED')->count();
        $total_scheduled_rides = UserRequests::where('status','SCHEDULED')->count();
        $total_sortcenter = UserRequests::where('status', 'SORTCENTER')->count();
        $total_delivering = UserRequests::where('status', 'DELIVERING')->count();
        $total_assigned = UserRequests::where('status', 'ASSIGNED')->count();

        //
        $open_ticket =  Complaint::where('status','1')->count();

        //for new dashbaord
        $dep =Department::where('dept',"=",'Sortcenter')->pluck('id')->first();
        $tickets = Ticket::where('status','=',"open")->where('dept_id',$dep)->orderBy('created_at', 'ASC')->paginate();

        foreach($tickets as $ticket){
            $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
            $ticket->from_Dep = Department::where('id',$ticket->department)->first();
        }
        $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->where('user_requests.dept_id',$dep)
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->get();                        
        foreach($allOrderComments as $allOrderComment){

            $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status','=','0')->first();
            $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
            $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->count();
            $allOrderComment->comment=Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->orderBy('id', 'DESC')->first();
        }
        $trips=UserRequests::where('status','SORTCENTER')->orderBy('created_at', 'ASC')->paginate(8);
        return view('sortcenter.dashboard',compact('scheduled_rides',
            'rides',
            'trips',
            'tickets',
            'allOrderComments',
            'completed_rides', 
            'rejected_rides',
            'sortcenter',
            'delivering',
            'scheduled_rides',
            'assigned', 
            'total_rides', 
            'total_completed_rides', 
            'total_sortcenter', 
            'total_rejected_rides', 
            'total_assigned', 
            'total_delivering', 
            'total_scheduled_rides',
            'open_ticket')
        );
    }
    public function hold(Request $request){
        try{
            $request=UserRequests::find($request->hold_id);
            $request->hold_date = Carbon::now();
            $log=new OrderLog();
            $log->create([
                'request_id'=>$request->id,
                'type' => "Hold",
                'description' => "This Order had Been hold by ".Auth::user()->name
            ]);
             $dept = Department::where('dept', '=', 'Sortcenter')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $request->id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = 'Sortcenter';
            $comment->comments = 'Your Order has been put on Hold by '.Auth::user()->name.' at '.Carbon::now().' Your Fare Will be increased by Rs.'. Setting::get('hold_amount').  ' Everyday untill it is rejected or Completed';
            $comment->is_read_admin = '0';    
            $noti = new Notification;
            $token= $request->user->device_key;
            if($token){
                $title = 'Comment Received';
                $body = 'Your Order has been put on Hold by '.Auth::user()->name.' at '.Carbon::now().' Your Fare Will be increased by Rs.'. Setting::get('hold_amount'). ' Everyday untill it is rejected or Completed';
                $noti->toSingleDevice($token,$title,$body,null,null,$request->user->id,$request->id);
            }
            $request->save();
            $comment->save();       
        return back()->with('flash_success', 'This order has been put on hold.');
        }   catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }
    public function all_vendor($id)
    {
        
        try {
            $inbound_orders = UserRequests::where('user_id',$id)
            ->where(function($query){
                $query->where('status','=','PENDING')->orWhere('status','=','ACCEPTED')->orWhere('status','=','PICKEDUP')->orWhere('status','=','NOTPICKEDUP');
                })
            ->get();
           
            //dd($inbound_orders);
            // return $inbound_orders;
            return view('sortcenter.orders.vendorInbound', compact('inbound_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function riderAssign(Request $request, $id)
    {  
        try {
            $UserRequest = UserRequests::findOrFail($id);
            if($request->ajax()) {
                    if($request->provider=="N/A" || $request->provider=="Select Rider"){
                        AssignedRidersHistory::create([
                            'request_id'=>$UserRequest->id,
                            'rider_id'=>$UserRequest->provider_id,
                            'status'=>$UserRequest->status,
                        ]);
                        $UserRequest->provider_id=null;    
                    }  else{
                        $UserRequest->provider_id= $request->provider;
                        $UserRequest->status= "DELIVERING";
                        AssignedRidersHistory::create([
                            'request_id'=>$UserRequest->id,
                            'rider_id'=>$UserRequest->provider_id,
                            'status'=>"DELIVERING"
                        ]);
                    } 
                }
                $a=$UserRequest->save();
                return response()->json([
                        'request' => $request,
                        'error' => $a
                    ]); 
             } 
            //  } 
        

        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function profile()
    {
        return view('sortcenter.account.profile');
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

            $account = Auth::guard('sortcenter')->user();
            $account->name = $request->name;
            $account->mobile = $request->mobile;
            $account->save(); 
            return redirect()->back()->with('flash_success','Profile Updated');
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
    }

    public function password()
    {
        return view('sortcenter.account.change-password');
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

           $Account = SortCenterUser::find(Auth::guard('sortcenter')->user()->id);

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
}
