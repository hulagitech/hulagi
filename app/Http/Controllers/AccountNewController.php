<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use Setting;
use App\User;
use App\Esewa;
use App\Fleet;
use App\Zones;

use Exception;
use App\Account;
use App\Comment;
use App\Provider;
use \Carbon\Carbon;
use App\BankDetail;

use App\Department;
use App\ServiceType;
use App\UserInvoice;
use App\UserPayment;
use App\UserRequests;
use App\Helpers\Helper;
use App\PaymentHistory;
use App\PaymentRequest;
use App\RiderPaymentLog;
use App\DispatcherToZone;
use App\UserPaymentDetail;
use App\Model\Notification;
use App\Model\RiderInvoice;
use App\UserRequestPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccountNewController extends Controller
{
    // ___________________________________________________________________________________
    //             Order Comments
    // -----------------------------------------------------------------------------------
    public function unsolve_Comments()
    {
        // user_requests.comment_status = 0  ----> {Unsolve}
        try {
            $dept = Department::where('dept', '=', 'Accounts')->pluck('id')->first();
            $orderComments = DB::table('comments')
                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                ->where('user_requests.comment_status', '=', '0')
                ->where('user_requests.dept_id', $dept)
                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                ->groupBy('comments.request_id')
                ->orderBy('comments.created_at', 'ASC')
                ->having('count', '>=', 1)
                ->get();
            foreach ($orderComments as $orderComment) {
                $orderComment->ur = UserRequests::where('id', '=', $orderComment->request_id)->where('comment_status', '=', '0')->first();
                $orderComment->user = User::where('id', '=', $orderComment->ur->user_id)->first();
                $orderComment->noComment = Comment::where('request_id', $orderComment->request_id)->where('is_read_account', '=', "1")->count();
            }

            return view('account.ordercomment.unsolveComment', compact('orderComments'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function getTotalRequest(Request $request){
        try{
            $posts= PaymentRequest::where('is_paid',0)->count();
            return response()->json([
                'count' => $posts,
                'data' => 'true'
            ]);
        }
        catch (Exception $e) {
            return response()->json(['data' => "false"], 500);
        }
    }

    public function solved_Comments()
    {
        try {
            $dept = Department::where('dept', '=', 'Accounts')->pluck('id')->first();
            $orderComments = DB::table('comments')
                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                ->where('user_requests.comment_status', '=', '1')
                ->where('user_requests.dept_id', $dept)
                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                ->groupBy('comments.request_id')
                ->orderBy('comments.created_at', 'ASC')
                ->having('count', '>=', 1)
                ->get();

            foreach ($orderComments as $orderComment) {
                $orderComment->ur = UserRequests::where('id', '=', $orderComment->request_id)->where('comment_status', '=', '1')->first();
                $orderComment->user = User::where('id', '=', $orderComment->ur->user_id)->first();
                $orderComment->noComment = Comment::where('request_id', $orderComment->request_id)->where('is_read_account', '=', "1")->count();
            }

            //dd($orderComments);


            return view('account.ordercomment.solvedComment', compact('orderComments'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }


    public function orderComment_Detail($id)
    {
        try {
            $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
            $comments = Comment::where('request_id', '=', $id)->orderBy('created_at', 'ASC')->get();

            foreach ($comments as $comment) {
                if ($comment->dept_id == $dept) {
                    $dispatcherZone = DispatcherToZone::where('dispatcher_id', $comment->authorised_id)->pluck('zone_id')->first();
                    $comment->zone = Zones::where('id', $dispatcherZone)->pluck('zone_name')->first();
                }
            }

            $user_req = UserRequests::where('id', $id)->first();
            $depts = Department::orderBy('dept')->get();

            return view('account.ordercomment.comment_page', compact('comments', 'user_req', 'depts'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function orderCommentReply(Request $request, $req_id)
    {
        try {
            $dept = Department::where('dept', '=', 'Accounts')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->comments = $request->input('comment');
            $comment->is_read_account = '0';
            $comment->save();
            $solve_comment = UserRequests::findOrFail($req_id);
            $solve_comment->comment_status = 1;
            $solve_comment->update();

            $noti = new Notification;
            $token= $solve_comment->user->device_key;
            $title = 'Comment Received';
            $body = 'New comment received for your order of '.$solve_comment->item->rec_name.', '.$solve_comment->d_address;
            $noti->toSingleDevice($token,$title,$body,null,null,$solve_comment->user->id,$solve_comment->id);
            return back()->with('flash_success', 'Your comment has send!!!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // To make Solved Order
    public function solvedOrder(Request $request, $req_id)
    {
        try {
            $solve_order = UserRequests::findOrFail($req_id);
            $solve_order->comment_status = $request->input('status');

            $solve_order->update();
            return redirect('/account/unsolve_comments')->with('flash_success', 'Order problem solved successfully!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // To make Unsolve Order
    public function unsolveOrder(Request $request, $req_id)
    {
        try {
            $unsolve_order = UserRequests::findOrFail($req_id);
            $unsolve_order->comment_status = $request->input('status');

            $unsolve_order->update();
            return redirect('/account/solved_comments')->with('flash_success', 'Order problem reopen Successfully!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // public function orderDepartment(Request $request, $id)
    // {
    //     try {
    //         $ur = UserRequests::findOrFail($id);
    //         if($request->ajax()) {
    //             //if(isset($request->department)){
    //                 //dd($request->department);
    //                 $ur->dept_id= $request->department;
    //                 $ur->save();
    //                 //$a=$ticket->save();
    //             //}
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





    //-----------------------------------------------------------
    //         Bank Details
    //-----------------------------------------------------------
    public function index()
    {
        try {
            $details = BankDetail::where('status', true)->paginate(100);

            return view('account.wallet.bank_detail', compact('details'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function totalPayableUserAndVendor()
    {
        try{
            if(Auth::user()->head==1)
            {
                $totalAmountRequested=PaymentRequest::where('is_paid',0)->sum('requested_amt');
                $usersReceivable=Cache::remember('user',60*60*10, function(){
                    $users = User::where('settle',0)->get();
                    $negativeUser=array();
                    $i=0;
                    $amount=0;
                    foreach ($users as $index => $user) {
                    $user->totalOrder=UserRequests::where('user_id',$user->id)->count();
            
                    $user->status=UserRequests::where('user_id',$user->id)->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) <= 7')->count();
                                
                    //new wallet
                    $totalOrder=UserRequests::where('user_id',$user->id)
                    ->where('status','COMPLETED')
                    ->where('created_at','>=','2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                    \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                    $totalReject=UserRequests::where('user_id',$user->id)
                    ->where('status','REJECTED')
                    ->where('created_at','>=','2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                    $totalPaid=PaymentHistory::where('remarks','NOT LIKE','Changed from%')
                    ->where('remarks','NOT LIKE','%djustment%')
                    ->where('user_id',$user->id)
                    ->where('created_at','>=','2020-10-15')
                    ->select([
                        \DB::raw("SUM(changed_amount) as paid")
                        ])
                        ->first();
                        //paid is negative so, we add it which is same as subtraction
                    $user->newPayment=$totalOrder->sum_cod-$totalOrder->sum_fare-$totalReject->sum_fare+$totalPaid->paid;
                    if($user->newPayment<0 && $user->user_type==env('APP_NAME', 'Hulagi')){
                        $negativeUser[$i]=$user;
                        $amount=$amount+$user->newPayment;
                        $i++;
                    }
                }
                return $data=[
                    'Alluser' =>$users,
                    'negativeUser'=>$negativeUser,
                    'amount'=>$amount
                ];
                });
                // dd($usersReceivable);
                $riderReceivable=Cache::remember('rider',60*60*10,function(){
                    $Providers = Provider::where('settle',0)->get();
                    $amount=0;
                    $rider=array();
                    $i=0;
                    foreach($Providers as $provider){
                        $Rides = UserRequests::where('provider_id', $provider->id)
                            ->where('status', '<>', 'CANCELLED')
                            ->get()->pluck('id');

                        $provider->rides_count = $Rides->count();

                        $provider->payment = UserRequestPayment::whereIn('request_id', $Rides)
                            ->select(\DB::raw(
                                'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                            ))->get();
                        $totalOrder = UserRequests::where('provider_id', $provider->id)
                            ->where('status', 'COMPLETED')
                            ->where('created_at', '>=', '2020-10-15')
                            ->select([\DB::raw("SUM(cod) as sum_cod"),
                                \DB::raw("SUM(amount_customer) as sum_fare")])
                            ->first();
                        $totalReject = UserRequests::where('provider_id', $provider->id)
                            ->where('status', 'REJECTED')
                            ->where('created_at', '>=', '2020-10-15')
                            ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                            ->first();
                        $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                            ->where('provider_id', $provider->id)
                            ->where('created_at', '>=', '2020-10-15')
                            ->where('transaction_type', 'earning')
                            ->select([
                                \DB::raw("SUM(amount) as paid"),
                            ])
                            ->first();
                        $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                            ->where('provider_id', $provider->id)
                            ->where('created_at', '>=', '2020-10-15')
                            ->where('transaction_type', 'payable')
                            ->select([
                                \DB::raw("SUM(amount) as paid"),
                            ])
                            ->first();
                        //paid is negative so, we add it which is same as subtraction
                        $provider->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
                        $provider->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
                        if($provider->newPayable>0){
                            $rider[$i]=$provider;
                            $amount=$amount+$provider->newPayable;
                            $i++;
                        }
                }
                return $data=[
                    'rider'=>$rider,
                    'amount'=>$amount
                ];
                });
                return view('account.total_payable',compact('usersReceivable','riderReceivable','totalAmountRequested'));
            }
            else{
                return back()->with('flash_error', '!!Sorry, You Cannot Access this View!');
            }
    
        }
        catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function cacheFlush(){
        Cache::flush();
        return back()->with('flash_success', 'Cache Flushed Successfully!');
    }

    public function create()
    {
        $users = User::all();
        return view('account.wallet.create_bankDetail', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $bank = new BankDetail;
            $bank->user_id = $request->input('user_id');
            $bank->bank_name = $request->input('bank_name');
            $bank->branch = $request->input('branch');
            $bank->ac_no = $request->input('ac_no');
            $bank->ac_name = $request->input('ac_name');
            $bank->createdby_ac = 1;
            $bank->save();

            //return back()->with('flash_success', 'Your Payment Information Save Successfully!');
            return redirect('/account/bank_infos')->with('status', 'Payment information saved Successfully!!!');
        } catch (Exception $e) {
            //dd("Exception", $e);
            return back()->with('flash_error', 'Submit Unsuccess!!!');
        }
    }

    public function edit($id)
    {
        try {
            $users = User::all();
            $detail = BankDetail::findOrFail($id);
            // $depts = Department::all();

            return view('account.wallet.edit_bankDetail', compact('detail', 'users'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $bank = BankDetail::findOrFail($id);
            $bank->user_id = $request->user_id;
            $bank->bank_name = $request->bank_name;
            $bank->branch = $request->branch;
            $bank->ac_no = $request->ac_no;
            $bank->ac_name = $request->ac_name;
            $bank->status = $request->status;
            // $bank->createdby_ac = 1;
            $bank->save();
            // return back()->with('flash_success', 'Branch Manager Updated Successfully!');
            return redirect('/account/bank_infos')->with('status', 'Payment information saved Successfully!!!');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Branch Manager Not Found!');
        }
    }
    public function userInvoice()
    {
        // try {
        //     $invoices=UserRequests::where('paid',1)->groupBy('invoice')->get();

        // foreach ($invoices as $key => $a) {
        //     $sum=0;
        //    if ($a->status="COMPLETED") {
        //        $amount=$a->cod-$a->amount_customer;
        //        $sum+=$amount;
        //        $a->total=$sum;    
        //    }
        //    else{
        //     $amount=0-$amount_customer;
        //     $sum+=$amount; 
        //     $a->total=$sum; 
        //    } 
        // }

        // return $invoices;
        $invoices = UserInvoice::get();
        return view('account.invoice.userInvoice', compact('invoices'));
        // } 

        // catch (ModelNotFoundException $e) {
        //     return back()->with('flash_error', 'Invoice Not Found!');
        // }    
    }

    public function invoiceDetails($id)
    {
        $payments=UserInvoice::find($id);
        return view('account.invoice.detail',compact('payments'));
    }

    public function riderInvoice()
    {
        $invoices = RiderInvoice::get();
        return view('account.invoice.riderInvoice', compact('invoices'));
    }

    public function riderInvoiceDetails($id)
    {
        $payments=RiderInvoice::find($id);
        
        return view('account.invoice.riderDetail',compact('payments'));
    }

    public function getEsewaPayment(){
        $Esewa=Esewa::paginate(100);
        return view('account.invoice.esewa',compact('Esewa'));
    }

    public function todayPaymentHistory(){
       $payable=PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')->where('remarks', 'NOT LIKE', '%adjustment%')->where('remarks', 'NOT LIKE', '%ESEWA')->whereDate('created_at', Carbon::today())->get();
         return view('account.invoice.todayPaymentHistory',compact('payable'));
    }

    public function todayriderHistory(){
        $payable=RiderPaymentLog::where('transaction_type','payable')->whereDate('created_at', Carbon::today())->get();
          return view('account.invoice.todayRiderPaymentHistory',compact('payable'));
     }

     public function payementdate(Request $request){
        $payable=PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')->where('remarks', 'NOT LIKE', '%adjustment%')->where('remarks', 'NOT LIKE', '%ESEWA')->whereBetween('created_at',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->get();
        return view('account.invoice.todayPaymentHistory',compact('payable'));
    }   

    public function riderpayementdate(Request $request){
        $payable=RiderPaymentLog::where('transaction_type','payable')->whereBetween('created_at',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->get();
        return view('account.invoice.todayRiderPaymentHistory',compact('payable'));
    }     

    public function totalRequest(){
        $users=Cache::remember('dashboarduser',60*60*10, function(){
            $users = User::whereHas('payment_request', function ($query) {
                $query->where('is_paid', false);
            })->get();
            foreach ($users as $index => $user) {
            $user->requested_at = PaymentRequest::where('user_id', $user->id)
                ->latest()->first();
            $user->totalOrder=UserRequests::where('user_id',$user->id)->count();
    
            $user->status=UserRequests::where('user_id',$user->id)->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) <= 7')->count();
            
            $user->payment_req = PaymentRequest::where('user_id', $user->id)->where('is_paid', false)->latest()->first();
            $Rides = UserRequests::where('user_id',$user->id)
                    ->where('status','<>','CANCELLED')
                    ->get()->pluck('id');
                    
                    $completedRides = UserRequests::where('user_id',$user->id)
                    ->whereIn('status',['COMPLETED','REJECTED'])
                    ->get()->pluck('id');
                    
                    $user->rides_count = $Rides->count();
                    
                    $user->payment = UserRequests::whereIn('id', $completedRides)
                    ->select(\DB::raw(
                        'SUM(ROUND(cod)) as overall, SUM(ROUND(amount_customer)) as commission' 
                        ))->get();
                        
                        //new wallet
                        $totalOrder=UserRequests::where('user_id',$user->id)
                        ->where('status','COMPLETED')
                        ->where('created_at','>=','2020-10-15')
                        ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                        ->first();
                        $totalReject=UserRequests::where('user_id',$user->id)
                        ->where('status','REJECTED')
                        ->where('created_at','>=','2020-10-15')
                        ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                        ->first();
                        $totalPaid=PaymentHistory::where('remarks','NOT LIKE','Changed from%')
                        ->where('remarks','NOT LIKE','%djustment%')
                        ->where('user_id',$user->id)
                        ->where('created_at','>=','2020-10-15')
                        ->select([
                            \DB::raw("SUM(changed_amount) as paid")
                            ])
                            ->first();
                            //paid is negative so, we add it which is same as subtraction
                            $user->newPayment=$totalOrder->sum_cod-$totalOrder->sum_fare-$totalReject->sum_fare+$totalPaid->paid;
        }
        return $users;
        });
        return view('account.request.allrequest',compact('users'));
    }

    public function totalNegativeUser(){
        try{
        $users=Cache::get('user')['negativeUser'];
        return view('account.users.allNegative',compact('users'));
        }
        catch(Exception $e){
            return back()->with('flash_error', 'Something Went Wrong!');
        }   
    }

    public function totalRider(){
        $Rider=Cache::get('rider')['rider'];
        // dd($Rider);
        return view('account.providers.allRider',compact('Rider'));
    }
    

}


