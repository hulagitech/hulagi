<?php

namespace App\Http\Controllers;

use App\AdminFaq;
use App\AdminHelps;
use App\AdminTerms;
use App\BankDetail;
use App\Card;
use App\Comment;
use App\Items;
use App\KhaltiDetail;
use App\PaymentRequest;
use App\RiderLog;
use App\User;
use App\UserRequests;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notice;
use Illuminate\Support\Facades\DB;
//use App\UserPaymentDetail;

use Illuminate\Support\Facades\Log;

class TripsController extends Controller
{
    protected $UserAPI;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status){
        if($status=="all")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips = $this->UserAPI->alltrips();
                $items = [];
                foreach ($trips as $trip) {
                   
                    $trip->item = Items::where('request_id', $trip->id)->latest()->first();
    
                    $trip->log = RiderLog::where('request_id', $trip->id)->first();
    
                    $comment_no = Comment::where('request_id', $trip->id)->where('is_read_user', '=', '1')->count();
                    $trip->comment_no = $comment_no;
                }
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="pending")
        {
           
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::where('status', 'PENDING')->where('user_id', Auth::user()->id)->orderBy('created_at','desc')->paginate(10);
                // return $trips;
                                        
                return view('user.status.status', compact('trips','status'));
                return $trips;
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="processing")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::whereIn('status', ['SORTCENTER', 'DISPATCHED', 'ASSIGNED', 'DELIVERING', 'PICKEDUP', 'ACCEPTED'])->where('user_id', Auth::user()->id)->orderBy('created_at','desc')->paginate(10);
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="complete")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::where('status', 'COMPLETED')->where('user_id', Auth::user()->id)->orderBy('created_at','asc')->paginate(10);
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="reject")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::where('status', 'REJECTED')->where('user_id', Auth::user()->id)->orderBy('created_at','asc')->paginate(10);
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="returned")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::whereIn('status', ['REJECTED', 'CANCELLED'])->where('user_id', Auth::user()->id)->where('returned', 1)->orderBy('created_at','asc')->paginate(10);
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="return")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::whereIn('status', ['REJECTED', 'CANCELLED'])->where('user_id', Auth::user()->id)->where('returned', 0)->orderBy('created_at','asc')->paginate(10);
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="cancel")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::where('status', 'CANCELLED')->where('user_id', Auth::user()->id)->orderBy('created_at','asc')->paginate(10);
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else if($status=="schedule")
        {
            $Response = $this->UserAPI->request_status_check1()->getData();
            // if(empty($Response->data))
            if (true) {
                $trips =  UserRequests::where('status', 'SCHEDULED')->where('user_id', Auth::user()->id)->orderBy('created_at','asc')->paginate(10);
                return view('user.status.status', compact('trips','status'));
            } else {
    
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
        else{
            $trip=UserRequests::where('user_id',Auth::user()->id)->orderBy('created_at','asc')->paginate(10);
           return view('user.status.status',compact('trips'));
        }


    }
   
     
}
