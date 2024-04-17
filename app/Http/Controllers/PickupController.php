<?php

namespace App\Http\Controllers;
use Setting;

use App\User;
use App\Zones;
use App\Ticket;
use App\Comment;
use App\Provider;
use App\Complaint;
use App\Department;
use App\SupportUser;
use App\UserRequests;
use App\TicketComment;
use App\Model\PickupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    public function dashboard()
    {
        $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
        $cancel_rides = UserRequests::where('status','CANCELLED')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
        $pending_rides = UserRequests::where('status','PENDING')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
        $picked_rides = UserRequests::where('status','PICKEDUP')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
        $accepted_rides = UserRequests::where('status','ACCEPTED')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
        $total_pending_rides = UserRequests::where('status','PENDING')->count();
        $total_accepted_rides = UserRequests::where('status','ACCEPTED')->count();
        $total_picked_rides = UserRequests::where('status','PICKEDUP')->count();
        $total_today_order  = UserRequests::whereRaw('DATE(created_at) = CURRENT_DATE')->count();
        $open_ticket =  Complaint::where('status','1')->count();
        $dep =Department::where('dept',"=",'Pickup')->pluck('id')->first();
        $tickets = Ticket::where('status','=',"open")->where('dept_id',$dep)->orderBy('created_at', 'ASC')->paginate();

        foreach($tickets as $ticket){
            $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
            $ticket->from_Dep = Department::where('id',$ticket->department)->first();
        }
         $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                 ->where('comments.authorised_type','Pickup')
                                ->where('user_requests.dept_id',$dep)
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->get();
            foreach($allOrderComments as $allOrderComment){

                $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status','=','0')->where('dept_id',$dep)->first();
                $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
                $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->count();
                $allOrderComment->comment=Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->orderBy('id', 'DESC')->first();
            }
            $trips=UserRequests::where('status','PENDING')->orderBy('created_at', 'ASC')->paginate(8);
        return view('pickup.dashboard',
            compact(
                'rides',
                'trips',
                'tickets',
                'allOrderComments',
                'cancel_rides',
                'pending_rides',
                'picked_rides',
                'accepted_rides',
                'total_pending_rides',
                'total_accepted_rides',
                'total_picked_rides',
                'total_today_order',
                'open_ticket'
            )
        );
    }

    public function mapView()
    {
        return view('pickup.map.index');
    }
    public function profile()
    {
        return view('pickup.account.profile');
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

            $account = Auth::guard('pickup')->user();
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
        return view('pickup.account.change-password');
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

           $Account = PickupUser::find(Auth::guard('pickup')->user()->id);

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
    public function pickedupRider(){
        try{
            $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;

          $providers= Provider::where('zone_id',$zoneKtm)->where('type','pickup')->paginate(10);
          return view('pickup.rider.index',compact('providers'));

       } catch (Exception $e) {
           return response()->json([
               'error' => $e->getMessage()
           ]);
       }
    }
    public function all_vendor($id){
        try {
            $inbound_orders = UserRequests::where('provider_id',$id)->Where('status','=','PICKEDUP')->get();
            $RiderName=Provider::where('id',$id)->pluck('first_name');
            //dd($inbound_orders);
            // return $inbound_orders;
            return view('pickup.orders.riderInbound', compact('inbound_orders','RiderName'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }

    }
    public function searchRider(Request $request)
    {
        try {
            if(isset($request->search)){
                        $providers = Provider::where('type','pickup')->where('first_name','LIKE','%'.$request->searchField.'%')
                            ->orWhere('email','LIKE','%'.$request->searchField.'%')
                            ->orWhere('mobile','LIKE','%'.$request->searchField.'%')
                            ->paginate(10);
            }
            return view('pickup.rider.index', compact('providers'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }   
    }
    public function returnRemaining($id,$status){
        $request=UserRequests::where('provider_id',$id)->where('status',$status)->get();
             $rider=Provider::where('id',$id)->first();
            return view('pickup.rider.remaining',compact('request','rider','status'));
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
   
}
