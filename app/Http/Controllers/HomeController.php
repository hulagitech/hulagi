<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Setting;
use App\Card;
use App\Fare;
use App\User;
use App\Esewa;
use App\Items;
use App\Zones;
use App\khalti;
use App\Notice;
use App\Ticket;
use App\Comment;
use App\AdminFaq;
use App\Provider;
use App\RiderLog;
use Carbon\Carbon;
use App\AdminHelps;
use App\AdminTerms;
use App\BankDetail;
use App\Department;
use App\UserInvoice;
use PayPal\Api\Item;
use App\KhaltiDetail;
use App\UserRequests;
//use App\UserPaymentDetail;

use App\Helpers\Helper;
use App\PaymentHistory;
use App\PaymentRequest;
use App\ProviderRating;
use App\DispatcherToZone;
use App\Model\Notification;
use Zend\Validator\Between;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserApiController;
use Request as Req;

class HomeController extends Controller
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
    public function index()
    {
        $Response = $this->UserAPI->request_status_check1()->getData();
        //never show last order but show intended
        //this is to remove the feature of only one order at a time
        // if(empty($Response->data))
        if (true) {
            $trips = $this->UserAPI->alltrips();
            // dd($trips);
            $rides = UserRequests::has('user')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $all_ride = $rides->where('user_id', Auth::user()->id)->count();
            $rides = $rides->where('user_id', Auth::user()->id);
            $Complete_ride = UserRequests::where('status', 'COMPLETED')->where('user_id', Auth::user()->id)->count();
            $pending_ride= UserRequests::where('status', 'PENDING')->where('user_id', Auth::user()->id)->count();
            $process_ride = UserRequests::whereIn('status',array('SORTCENTER', 'DISPATCHED', 'ASSIGNED', 'DELIVERING', 'PICKEDUP', 'ACCEPTED'))->where('user_id', Auth::user()->id)->count();
            // $returned_ride = UserRequests::where('status', '')->where('user_id', Auth::user()->id)->count();
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('user_id', Auth::user()->id)->count();
            $returned = UserRequests::whereIn('status', ['REJECTED', 'CANCELLED'])->where('user_id', Auth::user()->id)->where('returned', 1)->count();
            $not_returned = UserRequests::whereIn('status', ['REJECTED', 'CANCELLED'])->where('user_id', Auth::user()->id)->where('returned', 0)->count();
            $rejected_rides = UserRequests::where('status', 'REJECTED')->where('user_id', Auth::user()->id)->count();
            $scheduled_rides = UserRequests::where('status', 'SCHEDULED')->where('user_id', Auth::user()->id)->count();
            // $comments = UserRequests::where('user_id', Auth::user()->id)->whereHas('comment', function ($query) {
            //      $query->where('comment_status', 1);
            //  })->get();
            $tickets = Ticket::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
                    


            
                //  ( "label"=>"Processing Order", "value"=> 30) ,
                //  ( "label"=> "Scheduled Order", "value"=> 20))
            
            //  $data=[];
            //  foreach ($comments as $comment)
            //  {$data[]= $comment->id;}
            //  return $data;
             
            $invoices=UserInvoice::where("user_id",Auth::user()->id)->get();
            //  return $comments['comments']->id;
            // // foreach ($trips as $trip) {
            // //     $comments = Comment::where('request_id', $comment->id)->orderBy('created_at', 'ASC')->get();
            // // }
            // $comment = UserRequests::where('user_id', Auth::user()->id)->has("comment")->get();
            // return $Comment;
            
            
            
            // $notices = Notice::orderByRaw('updated_at DESC')->simplePaginate(5);
            $days = Req::input('days', 7);

            $range = \Carbon\Carbon::now()->subDays($days);
            
            $stats = UserRequests::where('created_at', '>=', $range)
            ->where('user_id', Auth::user()->id)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->select([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ])
            ->get();

            $donutData=[];
            $donutData[]= array("label"=>"Pending","value"=>$pending_ride) ;
            $donutData[]= array("label"=>"Processing","value"=>$process_ride) ;
            $donutData[]= array("label"=>"Schedule","value"=>$scheduled_rides) ;
            if(Auth::user()->Business_Person=='Person' && $all_ride>50){
                Auth::user()->Business_Person='Business';
                Auth::user()->save();
            }
            

            return view('user.dashboard', compact('stats','donutData','tickets','trips','invoices', 'scheduled_rides','pending_ride', 'cancel_rides', 'rides', 'all_ride', 'Complete_ride', 'process_ride',  'rejected_rides', 'returned', 'not_returned',));
        } else {
            

            return view('user.ride.waiting')->with('request', $Response->data[0]);
        }
    }
    public function searchOrder(Request $request){
        try{
            if(isset($request->search)){
                $orders = UserRequests::where('user_id',Auth::user()->id);
                if($request->has('searchField')){
                $orders=$orders->where(function($q) use ($request){
                        $q->orWhereHas('item',function($query) use ($request){
                            $query->where('rec_name', 'LIKE' ,'%'.$request->searchField.'%')	
                            ->orWhere('rec_mobile', 'LIKE' ,'%'.$request->searchField.'%');
                        })->orWhereHas('provider',function($query) use ($request){
                            $query->whereRaw("concat(first_name, ' ', last_name) like '%" .$request->searchField ."%' ")
                            ->orWhere('mobile', 'LIKE' ,'%'.$request->searchField.'%');
                        });
                    })
                    ->orWhere('booking_id','LIKE','%'.$request->searchField.'%')
                    ->where('user_id',Auth::user()->id);
                }
                $orders=$orders->get();
                return view('user.status.search',compact('orders'));
            }
            else{
                $orders =[];
                return view('user.status.search',compact('orders'));
            }
        }
        catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
            

    }

    //chart function

    // public function getApi()
    // {
    //     $days = Req::input('days', 7);

    //     $range = \Carbon\Carbon::now()->subDays($days);
        
    //     $stats = UserRequests::where('created_at', '>=', $range)
    //     ->where('user_id', Auth::user()->id)
    //     ->groupBy('date')
    //     ->orderBy('date', 'DESC')
    //     ->remember(60)
    //     ->get([
    //         DB::raw('Date(created_at) as date'),
    //         DB::raw('COUNT(*) as value')
    //     ])
    //     ->toJSON();
        
    //     return $stats;
    // }

    public function mytrips(Request $request)
    {
        // $Response = $this->UserAPI->request_status_check1()->getData();
       
        // if(empty($Response->data))
        if(isset($request->search)){
            if (true) { 
                if(( $request->from_date=='' || $request->to_date=='')){
                    if (true) {
                        $trips = $this->UserAPI->alltrips();
                        $items = [];
                        foreach ($trips as $trip) {
                        
                            $trip->item = Items::where('request_id', $trip->id)->latest()->first();
        
                            $trip->log = RiderLog::where('request_id', $trip->id)->first();
        
                            $comment_no = Comment::where('request_id', $trip->id)->where('is_read_user', '=', '1')->count();
                            $trip->comment_no = $comment_no;
                        }
                        return view('user.ride.mytrips', compact('trips',));
                    } else {
        
                        // return view('user.ride.waiting')->with('request', $Response->data[0]);
                    }
                }
                else{
                $trips= UserRequests::where('user_id', Auth::user()->id)->whereBetween('created_at',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->orderBy('created_at','asc')->paginate(50);
                // return $trips;
                return view('user.ride.mytrips', compact('trips'));
                }
                }
                else{
                    return view('user.ride.waiting')->with('request', $Response->data[0]);
                }
        }
        else{
            if (true) {
                $trips = $this->UserAPI->alltrips();
                $items = [];
                foreach ($trips as $trip) {
                
                    $trip->item = Items::where('request_id', $trip->id)->latest()->first();

                    $trip->log = RiderLog::where('request_id', $trip->id)->first();

                    $comment_no = Comment::where('request_id', $trip->id)->where('is_read_user', '=', '1')->count();
                    $trip->comment_no = $comment_no;
                }
                return view('user.ride.mytrips', compact('trips'));
            } else {

                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        }
    }

    public function mytrips_update(Request $request, $id)
    {
        try {
            $UserRequest = UserRequests::findOrFail($id);
            if ($request->ajax() && ($UserRequest->status == "PENDING" || $UserRequest->status == "ACCEPTED")) {
                if (isset($request->rec_name)) {
                    $UserRequest->item->rec_name = $request->rec_name;
                } else if (isset($request->rec_mobile)) {
                    $UserRequest->item->rec_mobile = $request->rec_mobile;
                } else if (isset($request->cod) && is_numeric($request->cod)) {
                    $UserRequest->cod = $request->cod;
                } else if (isset($request->special_note)) {
                    $UserRequest->special_note = $request->special_note;
                }
                $UserRequest->item->save();
                $a = $UserRequest->save();
                return response()->json([
                    'request' => $request,
                    'success' => $a,
                ]);
            } else {
                return response()->json([
                    'request' => "Invalid",
                    'success' => 'false',
                ]);
            }
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }

    public function mytrips_details(Request $request)
    {
        
            $trips = $this->UserAPI->alltrip_details($request);

            foreach ($trips as $trip) {
                $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
                $comments = Comment::where('request_id', $trip->id)->orderBy('created_at', 'ASC')->get();
                foreach($comments as $comment){
                    if ($comment->dept_id == $dept){
                        $dispatcherZone = DispatcherToZone::where('dispatcher_id', $comment->authorised_id)->pluck('zone_id')->first();
                        $comment->zone = Zones::where('id', $dispatcherZone)->pluck('zone_name')->first();
                    }
                }
            }
            $rating_comments=ProviderRating::where('user_request_id',$trips[0]->id)->first();
            
            return view('user.ride.mytrips_detail', compact('comments','trips','rating_comments'))->with('trip', $trips[0]);
         
    }

    public function mytrips_rating(Request $request,$provider_id,$order_id){
        try{
            $rating=$request->rating;

            $provider_rating =new ProviderRating;

            $provider_rating->rating=$request->rating;
            $provider_rating->provider_id=$provider_id;
            $provider_rating->user_request_id=$order_id;
            $provider_rating->comment=$request->comment;
            $provider_rating->save();
            return redirect()->back();


        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    public function userComment(Request $request, $request_id)
    {
        try {

            $user_request = UserRequests::findOrFail($request_id);
            $user_request->comment_status = "0";
            $user_request->update();

            $comment = new Comment();

            $comment->request_id = $request_id;
            // $comment->booking_id = $booking_id;
            $comment->authorised_type = "user";
            $comment->authorised_id = Auth::user()->id;
            $comment->comments = $request->input('user_comment');
            $comment->is_read_user = '0';

            $comment->save();
            return back()->with('flash_success', 'Your comment has send!!!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('user.account.profile');
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_profile()
    {
        return view('user.account.edit_profile');
    }

    /**
     * Update profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        return $this->UserAPI->update_profile($request);
    }

    /**
     * Show the application change password.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password()
    {
        return view('user.account.change_password');
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        return $this->UserAPI->change_password($request);
    }

    /**
     * Trips.
     *
     * @return \Illuminate\Http\Response
     */
    public function trips(Request $request)
    {
        $url = str_replace(url('/'), '', url()->previous());
        $array = explode('?', $url);

        /*if($array[0]!='/PassengerSignin')
        {
        Session::forget('s_address');
        Session::forget('d_address');
        }*/

        $services = $this->UserAPI->services();
        $trips = $this->UserAPI->trips();
       

        $ip = \Request::getClientIp(true);
        $ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
        $esewa_id=Helper::generate_esewa_id();
        return view('user.ride.multi_trips', compact('trips', 'services', 'ip_details','esewa_id'));
        // return view('user.ride.trips',compact('trips','services', 'ip_details' ));
    }

    public function remove_session_trips(Request $request)
    {
        
        Session::forget('s_address');
        Session::forget('d_address');
        Session::forget('service_type');
        Session::forget('s_latitude');
        Session::forget('d_latitude');
        Session::forget('d_longitude');
        Session::forget('s_longitude');

        $services = $this->UserAPI->services();
        $trips = $this->UserAPI->trips();

        $ip = \Request::getClientIp(true);
        $ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
        $esewa_id=Helper::generate_esewa_id();

        return view('user.ride.multi_trips', compact('trips', 'services', 'ip_details','esewa_id'));
        // return view('user.ride.trips',compact('trips','services', 'ip_details' ));
    }

    public function multi_trips(Request $request)
    {

        Session::forget('s_address');
        Session::forget('d_address');
        Session::forget('service_type');
        Session::forget('s_latitude');
        Session::forget('d_latitude');
        Session::forget('d_longitude');
        Session::forget('s_longitude');

        $services = $this->UserAPI->services();
        $trips = $this->UserAPI->trips();

        $ip = \Request::getClientIp(true);
        $ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));

        return view('user.ride.multi_trips_bulk', compact('trips', 'services', 'ip_details'));
    }

    /**
     * Payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        $cards = Card::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $users = User::where('paypal_id', '!=', '')->orderBy('created_at', 'desc')->get();
        return view('user.account.payment', compact('cards', 'users'));
    }

    /**
     * Wallet.
     *
     * @return \Illuminate\Http\Response
     */
    public function wallet(Request $request)
    {
        // $cards = Card::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();

        // $data = \DB::select("SELECT (@curRow := @curRow + 1) AS RANK_POS, user.id, user.first_name, user.wallet_balance, pr.created_at
        //         FROM users AS user
        //         JOIN (
        //             SELECT user_id, created_at
        //             FROM payment_requests
        //             WHERE paid_amount = '0'
        //             GROUP BY user_id
        //         ) AS pr ON user.id = pr.user_id
        //         JOIN  (SELECT @curRow := 0) r
        //         WHERE user.wallet_balance > 0
        //         order by created_at asc");
        // $key = array_search(Auth::user()->id, array_column($data, 'id'));
        // $request_position = ($key && array_key_exists($key, $data)) ? $data[$key] : null;

        $k_infos = KhaltiDetail::where('user_id', Auth::user()->id)->where('status', true)->latest()->first();
        $b_infos = BankDetail::where('user_id', Auth::user()->id)->where('status', true)->latest()->first();

        //Fatching recent date and time from Payment Request table (created_at).
        $requested_time = PaymentRequest::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
        $esewa_id=Helper::generate_esewa_id();

        //After Certain Time = 48 hrs.
        $after_ct = null;
        $queueNo = 0;
        if ($requested_time) {
            if ($requested_time->is_paid == 0) {
                $after_ct = "0";
                $unpaidList = PaymentRequest::where('is_paid', false)->orderBy("created_at", "ASC")->get();
                $queueNo = $unpaidList->search(function ($list) {
                    return $list->user_id === Auth::user()->id;
                });
                $queueNo += 1;
            } else {
                $after_ct = Carbon::now()->parse($requested_time->updated_at)->addHour(168);
                // $after_ct = Carbon::now()->parse($requested_time->updated_at)->addHour(48);
            }
        }

        $payment_req = PaymentRequest::where('is_paid', false)->where('user_id', Auth::user()->id)->latest()->first();

        return view('user.account.wallet', compact('k_infos', 'b_infos', 'requested_time', 'after_ct', 'queueNo', 'payment_req','esewa_id'));
        // return view('user.account.wallet',compact('payment_infos', 'requested_time', 'after_ct', 'queueNo', 'payment_req'));
        // return view('user.account.wallet',compact('cards', 'request_position', 'payment_infos', 'requested_time', 'after_ct'));
    }

    /**
     * Promotion.
     *
     * @return \Illuminate\Http\Response
     */
    public function promotions_index(Request $request)
    {
        $promocodes = $this->UserAPI->promocodes();

        //dd( $promocodes );

        return view('user.account.promotions', compact('promocodes'));
    }

    /**
     * Add promocode.
     *
     * @return \Illuminate\Http\Response
     */
    public function promotions_store(Request $request)
    {
        return $this->UserAPI->add_promocode($request);
    }

    /**
     * Upcoming Trips.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming_trips()
    {
        $trips = $this->UserAPI->upcoming_trips();
        return view('user.ride.upcoming', compact('trips'));
    }

    public function upcoming_trips_details(Request $request)
    {
        $trips = $this->UserAPI->upcoming_trip_details($request);
        return view('user.ride.upcoming_detail', compact('trips'));
    }

    public function helpsget()
    {
        try {
            $AdminHelps = AdminHelps::HelpsList()->get();
            return $AdminHelps;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    public function helps()
    {
        $helps = $this->helpsget();
        return view('user.help', compact('helps'));
    }

    public function termsget()
    {
        try {
            $AdminTerms = AdminTerms::TermsList()->get();
            return $AdminTerms;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    public function terms()
    {
        $terms = $this->termsget();
        return view('user.termsandcondition', compact('terms'));
    }

    public function faqsget()
    {
        try {
            $AdminFaq = AdminFaq::FaqList()->get();
            return $AdminFaq;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    public function faqs()
    {
        $faqs = $this->faqsget();
        return view('user.faq', compact('faqs'));
    }

    public function save_payment_mode(Request $request)
    {
        try {
            $hobby = implode(",", array_keys($request->except(['_method', '_token'])));

            //Exclude the parameters from the $request using except() method
            //now in your $hobby variable, you will have "art,artitecture,business"

            $add_payment_mode = User::where('id', Auth::user()->id)->update(['multiple_payment_method' => $hobby]);
            /* $add_payment_mode->mulitple_payment_method = $hobby;
            $add_payment_mode->save();*/
            return back()->with('flash_success', 'Payment mode saved Successfully');
        } catch (Exception $e) {

            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }

    public function create_item(Request $request)
    {
        if(Auth::user()->settle==1){
            return response()->json(['error' => 'You cannot Place Order as your Account has been Settle. Contact Hulagi for Further Information'], 500);
        }
        if(Auth::guard('support')->check() || Auth::guard('pickup')->check()){
            if ($request->isMethod('post')) {
            $post = $request->all();
            //echo "<pre/>";
            //print_r($post);die;

            return $this->UserAPI->add_item($request);
            }

            return response()->json(['response' => 'This is get method']);
        }
        else{
            $User=User::where('id',Auth::user()->id)->first();
            if($User->new_wallet(Auth::user()->id)< -1500){
                return response()->json(['error' => 'Your Balance is Lower than Limit, So Please Load your Wallet. Contact Hulagi for Further Information'], 500);
            }
             if ($request->isMethod('post')) {
            $post = $request->all();
            //echo "<pre/>";
            //print_r($post);die;

            return $this->UserAPI->add_item($request);
        }

        return response()->json(['response' => 'This is get method']);
        }
       
        //return $this->UserAPI->add_item($request);
    }
    public function openComment()
    {
        try {
            // $order=UserRequests::where('id',137)->get();
            // return $order;
            $comments = UserRequests::where('user_id', Auth::user()->id)->whereHas('comment', function ($query) {
                $query->where('comment_status', 1);
            })->paginate(50);
            // return $comments;
            return view('user.comment.openComment', compact('comments'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function allComment()
    {
        try {
            $comments = UserRequests::where('user_id', Auth::user()->id)->whereHas("comment", function ($query) {
                $query->where('comment_status', 0);
            })->paginate(50);
            return view('user.comment.commentAll', compact('comments'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function notice()
    {
        try{
            $notices=Notice::orderby('created_at','DESC')->where(function($query){
                $query->where('domain_name','=','all')->orWhere('domain_name','=',env('APP_NAME', 'Hulagi'));
                })->get();
            $notifis=Notification::orderby('created_at','DESC')->where('notifiable_id',Auth::id())->get();
            return view('user.notice',compact('notices','notifis'));

        }
        catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function verify(Request $request)
    {
        $status = $request->q;
        // dd($status);
        $oid = $request->oid;
        $refId = $request->refId;
        $amt = $request->amt;
        // dump($oid, $refId, $amt);

        if ($status == 'su') {
            $url = "https://esewa.com.np/epay/transrec";
            $data = [
                'amt' => $amt,
                'rid' => $refId,
                'pid' => $oid,
                'scd' => env('Merchant_Key'),
            ];

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            if (strpos($response, "Success") == true) {
                $this->validate($request, [
                    'amt'=>'required',
                    'oid' => 'required',
                    'refId' => 'required',

                ]);
                try{
                    $user = User::findOrFail(Auth::user()->id);
                    $paymentHistory = new PaymentHistory;
                    $paymentHistory->user_id = Auth::user()->id;
                    $paymentHistory->changed_amount = $request->amt;
                    $paymentHistory->remarks ="PAID THROUGH ESEWA";
                    $paymentHistory->save();
                    $user->wallet_balance =$user->wallet_balance + $request->amt;
                    $user->save();
                    // dd($user->wallet_balance);
                    // dd($user);
                    $esewa= null;
                    $esewa['User_ID']=Auth::user()->id;
                    $esewa['User_Name']=Auth::user()->first_name;
                    $esewa['Amount']=$request->amt;
                    $esewa['Payment_ID']=$request->oid;
                    $esewa['Reference_ID']=$request->refId;

                    //to create esewa table

                    $esewa=Esewa::create($esewa);



                    return redirect('wallet')->with('flash_success', 'Payment Done Successfully');
                }
                catch (Exception $e) {
                    return back()->with('flash_error', 'Something went Wrong');
                }

            } else {
                return redirect('wallet')->with('flash_error', 'Transaction Failed');
            }
        } else {
            return redirect('wallet')->with('flash_error', 'Transaction Failed');
        }
    }


    public function Load(Request $request)
    {
        $status = $request->q;
        // dd($status);
        $oid = $request->oid;
        $refId = $request->refId;
        $amt = $request->amt;
        // dump($oid, $refId, $amt);

        if ($status == 'su') {
            $url = "https://esewa.com.np/epay/transrec";
            $data = [
                'amt' => $amt,
                'rid' => $refId,
                'pid' => $oid,
                'scd' => env('Merchant_Key'),
            ];

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            if (strpos($response, "Success") == true) {
                $this->validate($request, [
                    'amt'=>'required',
                    'oid' => 'required',
                    'refId' => 'required',

                ]);
                try{
                    $user = User::findOrFail(Auth::user()->id);
                    $paymentHistory = new PaymentHistory;
                    $paymentHistory->user_id = Auth::user()->id;
                    $paymentHistory->changed_amount = $request->amt;
                    $paymentHistory->remarks ="LOAD THROUGH ESEWA";
                    $paymentHistory->save();
                    $user->wallet_balance =$user->wallet_balance + $request->amt;
                    $user->save();
                    // dd($user->wallet_balance);
                    // dd($user);
                    $esewa= null;
                    $esewa['User_ID']=Auth::user()->id;
                    $esewa['User_Name']=Auth::user()->first_name;
                    $esewa['Load_Amount']=$request->amt;
                    $esewa['Payment_ID']=$request->oid;
                    $esewa['Reference_ID']=$request->refId;

                    //to create esewa table

                    $esewa=Esewa::create($esewa);



                    return redirect('wallet')->with('flash_success', 'Wallet Loaded Successfully');
                }
                catch (Exception $e) {
                    return back()->with('flash_error', 'Something went Wrong');
                }

            } else {
                return redirect('wallet')->with('flash_error', 'Failed to Load Wallet');
            }
        } else {
            return redirect('wallet')->with('flash_error', 'Failed To Load Wallet');
        }
    }

public function trips_map(){
         try{
            return view('user.trips.map');

        }
        catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }


    public function get_locations($type=null){
        try{
           switch($type){
            case "pending":
                return $this->pendingOrders();
                break;
            case "sortcentered":
                return $this->sortCenteredOrders();
                break;
            case "delivering":
                return $this->deliveringOrders();
                break;
            case "scheduled":
                return $this->scheduledOrders();
                break;
            case "return":
                return $this->returnRemainingOrders();
                break;
            default:
               return $this->pendingOrders();
               break;
            }

        }
        catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function pendingOrders(){
         $data = UserRequests::whereIn('status',['PENDING','ACCEPTED'])
        ->where('d_latitude','!=',0)
        ->where('d_longitude','!=',0)
        ->where('user_id',Auth::id())
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->d_latitude;
            $item->longitude = (double)$item->d_longitude;
            $item['icon'] = 'pending';
            return $item;
        });
        return $data->toArray();
    }
    public function sortCenteredOrders(){
         $data = UserRequests::whereIn('status',['PICKEDUP','SORTCENTER'])
        ->where('d_latitude','!=',0)
        ->where('d_longitude','!=',0)
        ->where('user_id',Auth::id())
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->d_latitude;
            $item->longitude = (double)$item->d_longitude;
            $item['icon'] = 'sortcentered';
            return $item;
        });
        return $data->toArray();
    }
    public function scheduledOrders(){
         $data = UserRequests::where('status','SCHEDULED')
        ->where('d_latitude','!=',0)
        ->where('d_longitude','!=',0)
        ->where('user_id',Auth::id())
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->d_latitude;
            $item->longitude = (double)$item->d_longitude;
            $item['icon'] = 'scheduled';
            return $item;
        });
        return $data->toArray();
    }
    public function deliveringOrders(){
         $data = UserRequests::whereIn('status',['DELIVERING','DISPATCHED'])
        ->where('d_latitude','!=',0)
        ->where('d_longitude','!=',0)
        ->where('user_id',Auth::id())
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->d_latitude;
            $item->longitude = (double)$item->d_longitude;
            $item['icon'] = 'delivering';
            return $item;
        });
        return $data->toArray();
    }
     public function returnRemainingOrders(){
         $data = UserRequests::whereIn('status',['REJECTED','CANCELLED'])
        ->where('d_latitude','!=',0)
        ->where('d_longitude','!=',0)
        ->where('user_id',Auth::id())
        ->where('returned','!=',1)
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->d_latitude;
            $item->longitude = (double)$item->d_longitude;
            $item['icon'] = 'return';
            return $item;
        });
        return $data->toArray();
    }


    public function get_location_details($type,$id){
            try{
            switch($type){
                case "pending":

                    return $this->ordersDetails($id);
                    break;
                case "sortcentered":
                    return $this->ordersDetails($id);
                    break;
                case "delivering":
                    return $this->ordersDetails($id);
                    break;
                case "scheduled":
                    return $this->ordersDetails($id);
                    break;
                case "return":
                    return $this->ordersDetails($id);
                    break;
                default:
                return null;
                break;
                }

            }
            catch (Exception $e) {

                return back()->with('flash_error', 'Something Went Wrong!');
            }
        }

    public function ordersDetails($id)
    {
        $rq =  UserRequests::find($id);
        
        return view('user.trips.mapDetailLocation',compact('rq'));
    }
   

    public function checkPhone($number){
        try{
            $items=Items::where('rec_mobile',$number)->get();
            $accepted_count=0;
            $processing_count=0;
            $rejected_count=0;
            $completed_count=0;
            foreach($items as $item){
               $accepted = UserRequests::where('id',$item->request_id)->where('status','ACCEPTED')->first();
               if(isset($accepted)){
                    $accepted_count+=1;
               }
               $processing = UserRequests::where('id',$item->request_id)->whereNotIn('status',['PENDING','RETURNED','REJECTED','CANCELLED','ACCEPTED'])->first();
               if(isset($processing)){
                    $processing_count+=1;
               } 
               $rejected = UserRequests::where('id',$item->request_id)->where('status','REJECTED')->first();
               if(isset($rejected)){
                    $rejected_count+=1;
               }
               $completed=UserRequests::where('id',$item->request_id)->where('status','COMPLETED')->first();
               if(isset($completed)){
                    $completed_count+=1;
               }
            }
            return response()->json([
                'accepted'=>$accepted_count,
                'processing'=>$processing_count,
                'rejected'=>$rejected_count,
                'Completed'=>$completed_count,
            ]);
        }
            catch (Exception $e) {

                return back()->with('flash_error', 'Something Went Wrong!');
            }
    }
    public function fare(){
        $fares=Fare::where('domain_name',env('APP_NAME', 'Hulagi'))->get();
        return view('user.fare',compact('fares'));
    }
    public function khaltiVerify(Request $request){
        try{
            $args = http_build_query(array(
                'token' => $request->token,
                'amount'  => $request->amount,
            ));
            
            $url = "https://khalti.com/api/v2/payment/verify/";
            
            # Make the call using API.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $headers = ['Authorization: Key '.env('secret_key_khalti')];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            // Response
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($status_code==200){
                // create khalti table
                $khalti= new khalti();
                $khalti->create([
                        'User_ID'=>Auth::User()->id,
                        'User_Name'=>Auth::User()->first_name,
                        'idx'=>$request->idx,
                        'Mobile'=>$request->mobile,
                        'Paid_Amount'=>$request->amount/100,
                        'Payment_ID'=>$request->product_identity,
                        'Reference_ID'=>$request->token
                ]);
                $user = User::findOrFail(Auth::user()->id);
                    $paymentHistory = new PaymentHistory;
                    $paymentHistory->user_id = Auth::user()->id;
                    $paymentHistory->changed_amount = $request->amount/100;
                    $paymentHistory->remarks ="PAID THROUGH KHALTI";
                    $paymentHistory->save();
                    $user->wallet_balance =$user->wallet_balance + $request->amt;
                    $user->save();

                

                return response()->json([
                    'success'=>'Payment Success',
                ]);
            }else{
                return response()->json([
                    'success'=>'Payment Failed',
                ]);
            }
        }
        catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
        
    }
    public function stricker(){
         try {
            $inbound_orders = UserRequests::where('user_id',Auth::user()->id)
            ->where(function($query){
                $query->where('status','=','PENDING')->orWhere('status','=','ACCEPTED');
                })
            ->get();
           
            // dd($inbound_orders);
            // return $inbound_orders;
            return view('user.ride.stricker', compact('inbound_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function invoice(Request $request)
    {
        // return response()->json($request);
        $orders = [];
        foreach($request->order_id as $id){
            $orders[] = UserRequests::where('id','=',$id)->first();
            // if ($order->status=="PENDING" || $order->status=="ACCEPTED" || $order->status=="PICKEDUP"){
            //     $order->provider_id = null;
            //     $order->status = "SORTCENTER";
            //     $order->save();
            // }
        }
        // $order = UserRequests::where('id','=',$id)->first();
        // if ($order->status=="PENDING" || $order->status=="ACCEPTED" || $order->status=="PICKEDUP"){
        //     $order->provider_id = null;
        //     $order->status = "SORTCENTER";
        //     $order->save();
        // }
        return view('user.invoice.invoice', compact('orders'));
    }
    public function singleSortCenterInvoice(Request $request, $id)
    {
        $order = UserRequests::where('id',$id)->first();
        return view('user.invoice.singleInvoice',compact('order'));
    }
  
}
