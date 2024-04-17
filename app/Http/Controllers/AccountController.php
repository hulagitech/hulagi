<?php

namespace App\Http\Controllers;

use Setting;
use App\User;

use DateTime;
use App\Fleet;
use App\Zones;
use Exception;

use App\Account;
use App\Comment;
use App\MiniZone;
use App\OrderLog;
use App\Provider;
use App\RiderLog;
use App\Complaint;
use \Carbon\Carbon;
use App\billUpdate;
use App\Department;
use App\ServiceType;
use App\UserInvoice;
use App\UserPayment;
use App\UserRequests;
use App\settlementLog;
use App\PaymentHistory;
use App\PaymentRequest;
use App\RiderPaymentLog;
use App\UserExcelReport;
use App\DispatcherToZone;
use App\ZoneDispatchList;
use App\NextUserDashboard;
use App\UserPaymentDetail;
use App\UserRequestRating;
use App\UserRequestPayment;
use App\RequestPaymentItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('account');
    }

    /**
     * Dashboard.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {

        try {
            if ($request->has('from_date')) {
                $total_rides = UserRequests::
                whereBetween('created_at',array($request->from_date. " 00:00:00",$request->to_date." 23:59:59"))->count();
                $cancelled_rides = UserRequests::where('status', 'CANCELLED')
                ->whereBetween('updated_at',array($request->from_date. " 00:00:00" ,$request->to_date ." 23:59:59"))->count();
                $scheduled_rides = UserRequests::where('status', 'SCHEDULED')
                ->whereBetween('updated_at',array($request->from_date. " 00:00:00" ,$request->to_date ." 23:59:59"))->count();
                // $rejected_rides = RiderLog::whereHas('request', function($query) use($request){
                //             $query->where('status','REJECTED')
                //                 ->whereBetween('rejected_at', array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"));
                //         })->count();
                $rejected_rides = RiderLog::whereHas('request',function($query) use($request){
                            $query->where('status','REJECTED')
                            ->whereBetween('rejected_at', array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"));
                    })->count();

                // $rejected_rides = UserRequests::with('riderLog')->whereHas('user',function($query){
                //                     $query->where('settle',0);})->where(function($query) use ($request){
                //             $query->where('created_at','>=',$request->from_date)
                //             ->orWhere('updated_at','>=',$request->from_date);
                //         })
                //         ->where(function($query) use ($request){
                //             $query->where('created_at','<=',$request->to_date)
                //             ->orWhere('updated_at','<=',$request->to_date);
                //         })
                //         ->where('status',$request->status)->get();
                // $rejected_rides = $rejected_rides->riderLog ?? null;

                $completed_rides = RiderLog::whereHas('request',function($query){
                        $query->where('status','COMPLETED');
                    })->whereBetween('completed_date',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->count();
            }
            else{
                $total_rides = UserRequests::
                whereDate('created_at', Carbon::today())->count();
                $cancelled_rides = UserRequests::where('status', 'CANCELLED')
                ->whereDate('updated_at', Carbon::today())->count();
                $scheduled_rides = UserRequests::where('status', 'SCHEDULED')
                ->whereDate('updated_at', Carbon::today())->count();
                // $rejected_rides = RiderLog::whereHas('request',function($query){
                //     $query->where('status','REJECTED');})->whereDate('rejected_at', Carbon::today())->count();

                $rejected_rides = RiderLog::whereHas('request',function($query){
                    $query->where('status','REJECTED')
                        ->whereDate('rejected_at', Carbon::today());
                })->count();

                $completed_rides = RiderLog::whereHas('request',function($query){
                    $query->where('status','COMPLETED');})
                    ->whereDate('completed_date', Carbon::today())->count();
                }  
            $rides = UserRequests::has('user')->orderBy('id', 'desc')->take(10)->get();
            $revenue = UserRequestPayment::sum('total');
            $collection=RiderPaymentLog::where('transaction_type','payable')->whereDate('created_at', Carbon::today())->sum('amount');
            $payable=PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')->where('remarks', 'NOT LIKE', '%adjustment%')->where('remarks', 'NOT LIKE', '%ESEWA')->whereDate('created_at', Carbon::today())->where('changed_amount','<','0')->sum('changed_amount');
            $providers = Provider::take(10)->orderBy('rating', 'desc')->get();
            // dd($riderReceivable);
            return view('account.dashboard', compact(
                'providers', 'scheduled_rides' , 'rides', 
                'cancelled_rides', 'total_rides', 'revenue','rejected_rides','completed_rides','collection','payable',
            ));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->route('account.dashboard')->with('flash_error', 'Something Went Wrong with Dashboard!');
        }
    }

    public function completedOrder(Request $request)
    {
        if ($request->has('from_date')) {
           
            $completed_rides = RiderLog::whereHas('request',function($query){
                $query->where('status','COMPLETED');})->
            whereBetween('completed_date',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->get();
        }
        else{
            $completed_rides = RiderLog::whereHas('request',function($query){
                $query->where('status','COMPLETED');})->whereDate('completed_date', Carbon::today())->get();

        }
        return view('account.completed_orders',compact('completed_rides'));
    }

    public function rejectedOrder(Request $request)
    {
        if ($request->has('from_date')) {
           
            $completed_rides = RiderLog::whereHas('request',function($query) use($request){
                    $query->where('status','REJECTED')
                    ->whereBetween('rejected_at', array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"));
            })->get();
        }else{
            $completed_rides = RiderLog::whereHas('request',function($query){
                $query->where('status','REJECTED')
                    ->whereDate('rejected_at', Carbon::today());
            })->get();
        }
        return view('account.rejected_orders',compact('completed_rides'));
    }
    public function riderCompletedOrder(Request $request)
    {
        if ($request->has('from_date')) {
           
            $completed_rides = RiderLog::
            whereBetween('completed_date',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))
            ->get();
        }
        else{
            $completed_rides = RiderLog::whereDate('completed_date', Carbon::today())
            ->get();
        }
        // return $completed_rides;
        return view('account.completedOrder.rider_wise',compact('completed_rides'));
    }
    public function vendorCompletedOrder(Request $request)
    {if ($request->has('from_date')) {
        $completed_rides = RiderLog::
        whereBetween('completed_date',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->get();
    }
    else{
        $completed_rides = RiderLog::whereDate('completed_date', Carbon::today())->get();
    }
        return view('account.completedOrder.vendor_wise',compact('completed_rides'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('account.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|digits_between:6,13',
        ]);

        try {
            $account = Auth::guard('account')->user();
            $account->name = $request->name;
            $account->mobile = $request->mobile;
            // $account->save();

            return redirect()->back()->with('flash_success', 'Profile Updated');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('account.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $Account = Account::find(Auth::guard('account')->user()->id);

            if (password_verify($request->old_password, $Account->password)) {
                $Account->password = bcrypt($request->password);
                $Account->save();

                return redirect()->back()->with('flash_success', 'Password Updated');
            }
            else{
                return back()->with('flash_error', 'check your password!');
            }
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    /**
     * account statements.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement($type = 'individual', $request = null)
    {

        try {

            $page = 'Ride Statement';

            if ($type == 'individual') {
                $revenues = UserRequestPayment::sum('total');
                $commision = UserRequestPayment::sum('commision');
                $page = 'Driver Ride';

            } elseif ($type == 'today') {

                $page = 'Today Statement - ' . date('d M Y');

            } elseif ($type == 'monthly') {

                $page = 'This Month Statement - ' . date('F');

            } elseif ($type == 'yearly') {

                $page = 'This Year Statement - ' . date('Y');

            } elseif ($type == 'range') {

                $page = 'Ride Statement from ' . Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d M Y') . ' to ' . Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d M Y');
            }

            $rides = UserRequests::with('payment')->orderBy('id', 'desc');
            $cancel_rides = UserRequests::where('status', 'CANCELLED');
            $revenue = UserRequestPayment::select(\DB::raw(
                'SUM(fixed + distance) as overall, SUM(commision) as commission,SUM(tax) as tax,SUM(discount) as discount'
            ));

            $revenues = UserRequestPayment::sum('total');
            $commision = UserRequestPayment::sum('commision');

            if ($type == 'today') {

                $rides->where('created_at', '>=', Carbon::today());
                $cancel_rides->where('created_at', '>=', Carbon::today());
                $revenue->where('created_at', '>=', Carbon::today());

            } elseif ($type == 'monthly') {

                $rides->where('created_at', '>=', Carbon::now()->month);
                $cancel_rides->where('created_at', '>=', Carbon::now()->month);
                $revenue->where('created_at', '>=', Carbon::now()->month);

            } elseif ($type == 'yearly') {

                $rides->where('created_at', '>=', Carbon::now()->year);
                $cancel_rides->where('created_at', '>=', Carbon::now()->year);
                $revenue->where('created_at', '>=', Carbon::now()->year);

            } elseif ($type == 'range') {

                if ($request->from_date == $request->to_date) {
                    $rides->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                    $cancel_rides->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                    $revenue->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                } else {
                    $rides->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $request->from_date), Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                    $cancel_rides->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $request->from_date), Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                    $revenue->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $request->from_date), Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                }
            }

            $rides = $rides->get();
            $cancel_rides = $cancel_rides->count();
            $revenue = $revenue->get();

            return view('account.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'commision'))
                ->with('page', $page);

        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function provider_payment_logs($id)
    {
        try {
            $logs = RiderPaymentLog::where('provider_id', $id)->get();
            $rides = UserRequests::where('provider_id', $id)->count();
            $Provider = Provider::find($id);
            return view('account.providers.logs', compact('logs', 'rides', 'Provider'))
                ->with('page', "Payment Logs ");
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    /**
     * account statements today.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_today()
    {
        return $this->statement('today');
    }

    /**
     * account statements today.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_range(Request $request)
    {
        return $this->statement('range', $request);
    }

    /**
     * account statements monthly.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_monthly()
    {
        return $this->statement('monthly');
    }

    /**
     * account statements monthly.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_yearly()
    {
        return $this->statement('yearly');
    }

    /**
     * account statements.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_provider(Request $request)
    {

        try {
            // $commision = UserRequestPayment::sum('commision');
            // $revenues = UserRequestPayment::sum('total');

            $Providers = null;
            if ($request->has('searchField')) {
                $Providers = Provider::where('settle','!=',1)->where('first_name', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('mobile', 'LIKE', '%' . $request->searchField . '%')
                    ->paginate(5);
            } else {
                $Providers = Provider::where('settle','!=',1)->where('status', 'approved')
                    ->paginate(10);
            }

            // foreach ($Providers as $index => $Provider) {

            //     $Rides = UserRequests::where('provider_id', $Provider->id)
            //         ->where('status', '<>', 'CANCELLED')
            //         ->get()->pluck('id');

            //     $Providers[$index]->rides_count = $Rides->count();

            //     $Providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
            //         ->select(\DB::raw(
            //             'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
            //         ))->get();
            //     $totalOrder = UserRequests::where('provider_id', $Provider->id)
            //         ->where('status', 'COMPLETED')
            //         ->where('created_at', '>=', '2020-10-15')
            //         ->select([\DB::raw("SUM(cod) as sum_cod"),
            //             \DB::raw("SUM(amount_customer) as sum_fare")])
            //         ->first();
            //     $totalReject = UserRequests::where('provider_id', $Provider->id)
            //         ->where('status', 'REJECTED')
            //         ->where('created_at', '>=', '2020-10-15')
            //         ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
            //         ->first();
            //     $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
            //         ->where('provider_id', $Provider->id)
            //         ->where('created_at', '>=', '2020-10-15')
            //         ->where('transaction_type', 'earning')
            //         ->select([
            //             \DB::raw("SUM(amount) as paid"),
            //         ])
            //         ->first();
            //     $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
            //         ->where('provider_id', $Provider->id)
            //         ->where('created_at', '>=', '2020-10-15')
            //         ->where('transaction_type', 'payable')
            //         ->select([
            //             \DB::raw("SUM(amount) as paid"),
            //         ])
            //         ->first();
            //     //paid is negative so, we add it which is same as subtraction
            //     $Providers[$index]->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
            //     $Providers[$index]->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
            // }
            return view('account.providers.provider-statement', compact('Providers'))->with('page', 'Rider Statement');

        } catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function settledRider(){
        try {
            $Providers = Provider::where('settle','=',1)->paginate(10);
            return view('account.providers.riderSettle', compact('Providers'))->with('page', 'Rider Statement');

        } catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function settleUserStatement($id){
        try{
            $user = User::findorFail($id);
            $total_Order=UserRequests::where('user_id',$id)->count();
            $total_completed=UserRequests::where('user_id',$id)->where('status','COMPLETED')->count();
            $Complete_ride = UserRequests::where('status', 'COMPLETED')->where('user_id', $id)->count();
            $pending_ride= UserRequests::where('status', 'PENDING')->where('user_id', $id)->count();
            $process_ride = UserRequests::whereIn('status',array('SORTCENTER', 'DISPATCHED', 'ASSIGNED', 'PICKEDUP', 'ACCEPTED'))->where('user_id', $id)->count();
            $delivering= UserRequests::where('status', 'DELIVERING')->where('user_id', $id)->count();
            // $returned_ride = UserRequests::where('status', '')->where('user_id', Auth::user()->id)->count();
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('user_id', $id)->count();
            $returned = UserRequests::whereIn('status', ['REJECTED', 'CANCELLED'])->where('user_id', $id)->where('returned', 1)->count();
            $not_returned = UserRequests::whereIn('status', ['REJECTED', 'CANCELLED'])->where('user_id', $id)->where('returned', 0)->count();
            $rejected_rides = UserRequests::where('status', 'REJECTED')->where('user_id', $id)->count();
            $scheduled_rides = UserRequests::where('status', 'SCHEDULED')->where('user_id', $id)->count();
            // dd($user);
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
            // dd($user);
            return view('account.users.settlement',compact(['user','total_Order','total_completed','Complete_ride','pending_ride','process_ride','delivering','cancel_rides','returned','not_returned','rejected_rides','scheduled_rides','totalOrder','totalReject','totalPaid']));

        }
        catch(Exception $e){
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function settleUsersStatement(Request $request,$id){
        $this->validate($request, [
            'amount' => 'required',
            'remarks' => 'required',
        ]);
        try{
            $prcessing=UserRequests::whereNotIn('status',['COMPLETED','REJECTED','CANCELLED','NOTPICKEDUP'])->where('user_id',$id)->count();
            if($prcessing>0){
                return back()->with('flash_error', 'You can not settle this user, because Orders are in processing Status');
            }
            $user = User::findOrFail($id);
            $user->settle = 1;
            $settlement =new settlementLog;
            $settlement->amount = $request->input('amount');
            $settlement->remarks = $request->input('remarks');
            $settlement->provider_id = $user->id;
            $settlement->type = 'User';
            $settlement->save();
            $user->save();
            return redirect()->route('account.user.user')->with('flash_success', 'Settlement Done Successfully');

        }
        catch(expetion $e){
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    //bill statement

    public function bill(){
        $bill=billUpdate::Orderby('created_at','asc')->where('verify_done',1)->paginate(100);
        return view('account.providers.bill',compact(['bill']));
    }
    public function billSearch(Request $request){
        
        $bill=billUpdate::whereHas('provider',function($query) use($request){
            $query->where('first_name','like','%'.$request->searchField.'%');
        })->paginate(100);
        return view('account.providers.bill',compact(['bill']));
    }
    public function billPaymenyVefify($id){
        try{
            $bill=billUpdate::findorFail($id);
            $bill->verify_done=1;
            $a=$bill->remarks;
            $bill->remarks=$a.',verify_done by ' .Auth::user()->name;
            $bill->save();
            return back()->with('flash_success','Payment verification has been done');
        }
        catch(exception $e){
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function RiderPaymentDone($id){
        try{
            $bill=billUpdate::findorFail($id);
            if($bill->verify_done!=1){
                return back()->with('flash_error','Payment not verified');
            }
            $bill->payment_done=1;
           
            $Provider=Provider::findorFail($bill->provider_id);
            // dd($Provider);
            $Provider->payable -= $bill->amount;
            // dd($Provider->payable);
                    $logRequest = new Request();
                    $logRequest->replace([
                        'provider_id' => $Provider->id,
                        'transaction_type' => "payable",
                        'amount' =>$bill->amount,
                        'remarks' => 'paid done from bill sent by user at '.$bill->created_at,
                    ]);
                    $riderLog = new RiderPaymentLogController;
                    $riderLog->create($logRequest);
            $Provider->save();
            $bill->save();
            return back()->with('flash_success','Payment has been done');
        }
        catch(exception $e){
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function billDestroy($id){
        try{
            $bill=billUpdate::findorFail($id);
            $bill->delete();
            return back()->with('flash_success','Bill has been deleted');
        }
        catch(exception $e){
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function billUnverified(){
        $bill=billUpdate::Orderby('created_at','asc')->where('verify_done','!=',1)->paginate(100);
        return view('account.providers.bill',compact(['bill']));
    }
    public function RiderPaymentBillEdit(Request $request ,$id){
        // dd($id);
        try{
            $bill=billUpdate::findorFail($id);
            if($request->amount!=null){
                $bill->amount=$request->amount;
            }
            $bill->Remarks=$request->remarks;
            // $bill->amount=$request->amount;
            $a=$bill->save();
            return response()->json([
                'request' => $request,
                'success' => $a,
            ]);
        }
        catch(exception $e){
            return response()->json([
                'request' => "Invalid",
                'success' => 'false',
            ]);
        }
    }

    // Banned Statement of Rider
    public function banned_statement(Request $request)
    {
        try {
            // $commision = UserRequestPayment::sum('commision');
            // $revenues = UserRequestPayment::sum('total');

            $Providers = null;
            if ($request->has('searchField')) {
                $Providers = Provider::where('first_name', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('mobile', 'LIKE', '%' . $request->searchField . '%')
                    ->where('status', 'banned')
                    ->paginate(5);
            } else {
                $Providers = Provider::where('status', 'banned')
                    ->paginate(10);
            }

            // foreach ($Providers as $index => $Provider) {

            //     $Rides = UserRequests::where('provider_id', $Provider->id)
            //         ->where('status', '<>', 'CANCELLED')
            //         ->get()->pluck('id');

            //     $Providers[$index]->rides_count = $Rides->count();

            //     $Providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
            //         ->select(\DB::raw(
            //             'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
            //         ))->get();
            // }
            return view('account.providers.provider-statement', compact('Providers'))->with('page', 'Rider Statement');

        } catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function riderSearchPaymentBill(Request $request){
        $bill=billUpdate::whereBetween('created_at',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->Orderby('created_at','asc')->paginate(500);
        return view('account.providers.bill',compact(['bill']));
    }

    public function provider_statement($id)
    {
        try {
            $totalRiders = Provider::select("id", "first_name")->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            $requests = UserRequests::where('user_requests.provider_id', $id)->RequestHistory()->get();
            foreach ($requests as $request) {
                $request->log = RiderLog::where('request_id', $request->id)->first();
            }

            return view('account.request.index', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders']));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function user_statement($id)
    {
        try {
            DB::beginTransaction();
            $totalUsers = User::select("id", "first_name")->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            $requests = UserRequests::where('user_requests.user_id', $id)->RequestHistory()->get();
            foreach ($requests as $request) {
                $request->log = RiderLog::where('request_id', $request->id)->first();
            }
            DB::commit();

            $type = "user_statement";

            return view('account.request.index', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'id', 'type']));
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function searchUserStatementDetail(Request $request, $id)
    {
        try {
            $zoneKtm=Zones::where('zone_name','Kathmandu')->select('id')->first()->id;
            // return $zoneKtm;
            $totalUsers = User::select("id", "first_name")->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            // $requests = UserRequests::where('user_requests.user_id', $id)
            //         ->where('created_at', '>=', $request->from_date)
            //         ->where('created_at', '<=', $request->to_date)
            //         ->where('zone2','=',$zoneKtm)
            //         ->RequestHistory()
            //         ->get();
            //     return($requests);
            // dd($request);
            if($request->from_date=="" || $request->to_date=="")
            {
                if($request->status=="INSIDEVALLEY")
                {
                    $requests = UserRequests::where('user_requests.user_id', $id)
                    ->Where('zone2','=',$zoneKtm)
                    ->RequestHistory()
                    ->get();
                }
                elseif($request->status=="OUTSIDEVALLEY")
                {
                    $requests = UserRequests::where('user_requests.user_id', $id)
                    ->where('zone2','!=',$zoneKtm)
                    ->RequestHistory()
                    ->get();
                }
                else{

                    $requests = UserRequests::where('user_requests.user_id', $id)
                    // ->Where('zone2','!=',$zoneKtm)
                    ->RequestHistory()
                    ->get();

                }
            }
            else
            {
                if($request->status=="OUTSIDEVALLEY")
                {
                    $requests = UserRequests::where('user_requests.user_id', $id)
                    ->Where('zone2','!=',$zoneKtm)
                    ->where('created_at', '>=', $request->from_date)
                    ->where('created_at', '<=', $request->to_date)
                    ->RequestHistory()
                    ->get();
                }
                elseif($request->status=="INSIDEVALLEY")
                {
                    $requests = UserRequests::where('user_requests.user_id', $id)
                    ->where('zone2','=',$zoneKtm)
                    ->where('created_at', '>=', $request->from_date)
                    ->where('created_at', '<=', $request->to_date)
                    ->RequestHistory()
                    ->get();
                }
                else{

                    $requests = UserRequests::where('user_requests.user_id', $id)
                    ->where('created_at', '>=', $request->from_date)
                    ->where('created_at', '<=', $request->to_date)
                    ->RequestHistory()
                    ->get();

                }
            }
            foreach ($requests as $request) {
                $request->log = RiderLog::where('request_id', $request->id)->first();
            }

            $type = "user_statement";

            return view('account.request.index', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'id', 'type']));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function provider_update(Request $request, $id)
    {
        try {
            $Provider = Provider::findOrFail($id);
            if ($request->ajax()) {
                $remarks = $request->remarks ? $request->remarks : " ";
                if (isset($request->earning)) {
                    $request->earning = $request->earning ? $request->earning : 0;
                    $Provider->earning -= $request->earning;
                    $logRequest = new Request();
                    $logRequest->replace([
                        'provider_id' => $Provider->id,
                        'transaction_type' => "earning",
                        'amount' => $request->earning,
                        'remarks' => $remarks,
                    ]);
                    $riderLog = new RiderPaymentLogController;
                    $riderLog->create($logRequest);
                } else if (isset($request->payable)) {
                    $request->payable = $request->payable ? $request->payable : 0;
                    $Provider->payable -= $request->payable;
                    $logRequest = new Request();
                    $logRequest->replace([
                        'provider_id' => $Provider->id,
                        'transaction_type' => "payable",
                        'amount' => $request->payable,
                        'remarks' => $remarks,
                    ]);
                    $riderLog = new RiderPaymentLogController;
                    $riderLog->create($logRequest);
                } else {
                    return response()->json([
                        'request' => "No request",
                        'success' => 'false',
                    ]);
                }
                $a = $Provider->save();
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
            return response()->json([
                'request' => "Invalid",
                'success' => 'false',
            ]);
        }
    }

    public function statement_user(Request $request)
    {

        try {

            $users = null;
            $domainUsers = NextUserDashboard::all();
            if(isset($request->search)){
                if($request->domain_name!='All')
                {
                    $users = User::where('user_type',$request->domain_name)
                        ->where(function ($q) use($request){
                            $q->where('first_name', 'LIKE', '%' . $request->searchField . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $request->searchField . '%')
                            ->orWhere('company_name', 'LIKE', '%' . $request->searchField . '%')
                            ->orWhere('email', 'LIKE', '%' . $request->searchField . '%')
                            ->orWhere('mobile', 'LIKE', '%' . $request->searchField . '%');
                        })->paginate(100);
                }
                else
                {     
                   $users=User::where('first_name', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('company_name', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->searchField . '%')
                    ->orWhere('mobile', 'LIKE', '%' . $request->searchField . '%')
                    ->paginate(100);
                }
            }
            else {
                $users = User::whereHas('payment_request', function ($query) {
                    $query->where('is_paid', false);
                })
                    ->paginate(100);
            }
            foreach ($users as $index => $user) {
                $user->requested_at = PaymentRequest::where('user_id', $user->id)
                    ->latest()->first();
                $user->totalOrder=UserRequests::where('user_id',$user->id)->count();

                $user->status=UserRequests::where('user_id',$user->id)->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) <= 7')->count();
                
                $user->payment_req = PaymentRequest::where('user_id', $user->id)->where('is_paid', false)->latest()->first();
                $user->type=PaymentRequest::where('user_id', $user->id)->count();
            }
            return view('account.users.user-statement', compact(['users','domainUsers']))->with('page', 'User Statement');

        } catch (Exception $e) {
            return $e;
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function newUserRequest(){
        $users = User::withCount('payment_request');
        // doesntHave('payment_request')
        $users=$users->has('payment_request','<',4)->get();
        foreach($users as $user){
            $user->totalOrder=UserRequests::where('user_id',$user->id)->count();

                $user->status=UserRequests::where('user_id',$user->id)->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) <= 7')->count(); 
        }
        return view('account.users.new-user-request', compact('users'))->with('page', 'New User Request');
        // return $users;
        // $users = $users->where('get();
    }

    // public function ac_paymentdetail($id){
    //     $payment_infos = UserPaymentDetail::where('user_id', Auth::user()->id)->first();
    //     return view('account.users.user-statement')->with('payment_infos', $payment_infos);
    // }

    public function saveExl_report(Request $request)
    {
        try {
            if ($request->hasFile('xls_file')) {

                $this->validate($request, [
                    'xls_file' => 'mimes:,xlsx',
                ]);
                //$xls_reports = new UserExcelReport();
                $xls_reports->user_id = Auth::user()->id;
                // $xls_reports->xls_file = $request->store('xls_file', storage_path('uploads/xls_files'));

                $xls_reports->xls_file = UserExcelReport::store('xls_file', storage_path('uploads/xls_files'));

                // $request->xls_file->store('dispatch', 'uploads/xls_files');
                // $xls_reports->xls_file = $request->xls_file->hashName();
                $xls_reports->save();
            }

            return back()->with('flash_success', 'Excel File Uploaded Successfully!!!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function user_payments($id)
    {

        try {
            DB::beginTransaction();
            $payments = PaymentHistory::where('user_id', $id)->orderBy('created_at', 'desc')->get();
            $user = User::find($id);
            DB::commit();

            return view('account.users.user-payments', compact('payments', 'user'))->with('page', 'User Payment History');

        } catch (Exception $e) {
            DB::rollback();

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function destroyPaymentHistory($id){
        try {
            $payment = PaymentHistory::find($id);
            $payment->delete();
            return back()->with('flash_success', 'Payment Deleted Successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function makePayment(Request $request)
    {
        // return response()->json( $request);
        try {
            //get invoice_no
            $last_order = UserInvoice::latest()->first();

            if ($last_order) {
                $expNum = explode('-', $last_order->invoice_no);
                //    return $expNum;
                //check first day in a year
                if ($expNum[0] != Carbon::now()->firstOfYear()->format('Y')) {
                    $nextBillNumber = date('Y') . '-0001';
                } else {
                    //increase 1 with last invoice number
                    $nextBillNumber = $expNum[0] . '-' . (str_pad($expNum[1] + 1, 4, '0', STR_PAD_LEFT));
                }
            } else {
                $nextBillNumber = date('Y') . '-0001';
            }
            $user = User::findOrFail($request->id);
            //    return response()->json($request);

            //    return $nextBillNumber;
            switch ($request->submit) {
                case 'pay':
             
                    DB::beginTransaction();
                    $request->paid = $request->paid ? $request->paid : 0;
                    //check for payment requests to update
                    $paymentRequest = PaymentRequest::where('user_id', $user->id)->latest()->first();
                    $existsRequest = PaymentRequest::where('user_id', $user->id)->where('is_paid', false)->count();
                    //update the payment request and set updated
                    if ($existsRequest > 0) {
                        $paymentRequest->is_paid = true;
                        $paymentRequest->save();
                        $invoice = new UserInvoice();
                        $invoice->invoice_no = $nextBillNumber;
                        $invoice->paid_amount = $request->paid;
                        $invoice->user_id = $user->id;
                        $invoice->save();
                        foreach ($request->order_id as $order) {
                            $userRequest = UserRequests::find($order);
                            $userRequest->paid = '1';
                            $userRequest->invoice = $invoice->id;
                            $userRequest->save();
                        }
                    } else {
                        $payRequest = new PaymentRequest();
                        $payRequest->user_id = $user->id;
                        $payRequest->is_paid = true;
                        $payRequest->save();

                        $invoice = new UserInvoice();
                        $invoice->invoice_no = $nextBillNumber;
                        $invoice->paid_amount = $request->paid;
                        $invoice->user_id = $user->id;
                        $invoice->save();
                        foreach ($request->order_id as $order) {
                            $userRequest = UserRequests::find($order);
                            $userRequest->paid = '1';
                            $userRequest->invoice = $invoice->id;
                            $userRequest->save();
                        }
                    }
                    //change wallet balance as submitted by decreasing the paid amount
                    $paymentHistory = new PaymentHistory;
                    $paymentHistory->user_id = $user->id;
                    $paymentHistory->changed_amount = -$request->paid;
                    $paymentHistory->remarks = $request->pay_remarks ? $request->pay_remarks : "Changed by account";
                    $paymentHistory->save();
                    $user->wallet_balance -= $request->paid;
                    $user->save();
                    DB::commit();
                    session()->flash('flash_success', 'Payment Updated');
                    if (isset($payRequest)) {
                        return redirect()->route('account.paymentslip', $invoice->id);

                    } else {
                        return redirect()->route('account.paymentslip', $invoice->id);
                    }
                    break;
                case 'settle':
                    DB::beginTransaction();
                    $invoice = new UserInvoice();
                    $invoice->invoice_no = $nextBillNumber;
                    $invoice->paid_amount = $request->paid;
                    $invoice->user_id = $user->id;
                    $invoice->save();
                    foreach ($request->order_id as $order) {

                        $orders = UserRequests::find($order);
                        if ($orders) {
                            $orders->paid = '1';
                            $orders->invoice = $invoice->id;
                            $orders->save();
                        }

                    }
                    DB::commit();

                    session()->flash('flash_success', 'Payment Settled');

                    return redirect()->route('account.paymentslip', $invoice->id);
                    break;
            }
            //get user whose payment is changed

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('flash_error', $e->getMessage());
        }
    }

    public function openTicket($type)
    {

        $mytime = Carbon::now();

        if ($type == 'new') {

            $data = Complaint::whereDate('created_at', $mytime->toDateString())->where('transfer', 3)->where('status', 1)->get();
            $title = 'New Tickets';
        }
        if ($type == 'open') {

            $data = Complaint::where('transfer', 3)->where('status', 1)->get();
            $title = 'Open Tickets';
        }

        return view('account.open_ticket', compact('data', 'title'));
    }
    public function closeTicket()
    {

        $data = Complaint::where('transfer', 3)->where('status', 0)->get();

        return view('account.close_ticket', compact('data'));
    }

    public function openTicketDetail($id)
    {
        $data = Complaint::where('id', $id)->first();
        return view('account.open_ticket_details', compact('data'));
    }
    public function lost_management()
    {
        $data = LostItem::get();
        return view('account.open_ticket_details', compact('data'));
    }

    public function transfer($id, Request $request)
    {

        $data = Complaint::where('id', $id)->first();
        $data->status = $request->status;
        $data->transfer = $request->transfer;
        $data->reply = $request->reply;
        $data->save();
        return redirect()->back()->with('flash_success', 'Ticket Updated');

    }

    public function negative_wallet()
    {
        try {
            $users = User::paginate(1000);

            foreach ($users as $index => $user) {
                $Rides = UserRequests::where('user_id', $user->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $completedRides = UserRequests::where('user_id', $user->id)
                    ->whereIn('status', ['COMPLETED', 'REJECTED'])
                    ->get()->pluck('id');
                $users[$index]->rides_count = $Rides->count();

                $users[$index]->payment = UserRequests::whereIn('id', $completedRides)
                    ->select(\DB::raw(
                        'SUM(ROUND(cod)) as overall, SUM(ROUND(amount_customer)) as commission'
                    ))->get();
                //new wallet
                $totalOrder = UserRequests::where('user_id', $user->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('user_id', $user->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalPaid = PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')
                    ->where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('user_id', $user->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([
                        \DB::raw("SUM(changed_amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $users[$index]->newPayment = $totalOrder->sum_cod - $totalOrder->sum_fare - $totalReject->sum_fare + $totalPaid->paid;
                $user->requested_at = PaymentRequest::where('user_id', $user->id)
                    ->latest()->first();

                $user->payment_req = PaymentRequest::where('user_id', $user->id)->where('is_paid', false)->latest()->first();
            }
            // dd($users);
            return view('account.users.negativeWallet', compact('users'))->with('page', 'User Statement');

        } catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    public function stament_details(Request $request, $user_id)
    {
        try
        {
            $users = User::where('id', $user_id)
                ->take(500)->get();

            foreach ($users as $index => $user) {
                $Rides = UserRequests::where('user_id', $user->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $completedRides = UserRequests::where('user_id', $user->id)
                    ->whereIn('status', ['COMPLETED', 'REJECTED'])
                    ->get()->pluck('id');

                $users[$index]->rides_count = $Rides->count();

                $users[$index]->payment = UserRequests::whereIn('id', $completedRides)
                    ->select(\DB::raw(
                        'SUM(ROUND(cod)) as overall, SUM(ROUND(amount_customer)) as commission'
                    ))->get();

                //new wallet
                $totalOrder = UserRequests::where('user_id', $user->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('user_id', $user->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalPaid = PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')
                    ->where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('user_id', $user->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([
                        \DB::raw("SUM(changed_amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $users[$index]->newPayment = $totalOrder->sum_cod - $totalOrder->sum_fare - $totalReject->sum_fare + $totalPaid->paid;
                $user->requested_at = PaymentRequest::where('user_id', $user->id)
                    ->latest()->first();
                $user->payment_req = PaymentRequest::where('user_id', $user->id)->where('is_paid', false)->latest()->first();
            }
            return view('account.users.statementDetails', compact('users'))->with('page', 'User Statement');
        } catch (Exception $e) {
            return $e;
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function userOrderLog($id){
        try{
            $requestId=UserRequests::where('user_id',$id)->pluck('id');
            // dd($requestId);
            $orderLog=OrderLog::whereIn('Request_id',$requestId)->with('request')->orderBy('created_at','desc')->get();
            // dd($orderLog);
            return view('account.users.entireOrderLog',compact('orderLog'))->with('page','User Order Log');
        }
        catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function get_payment($id)
    {
        
        try {
            $users = User::where('id', $id)->get();
            $userDetails=$users[0];
            foreach ($users as $index => $user) {
                $completedRides = UserRequests::where('user_id', $user->id)
                    ->whereIn('status', ['COMPLETED', 'REJECTED'])
                    ->get()->pluck('id');
                $users[$index]->payment = UserRequests::whereIn('id', $completedRides)
                    ->select(\DB::raw(
                        'SUM(ROUND(cod)) as overall, SUM(ROUND(amount_customer)) as commission'
                    ))->get();
                //new wallet
                $totalOrder = UserRequests::where('user_id', $user->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('user_id', $user->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalPaid = PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')
                    ->where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('user_id', $user->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([
                        \DB::raw("SUM(changed_amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $users[$index]->newPayment = $totalOrder->sum_cod - $totalOrder->sum_fare - $totalReject->sum_fare + $totalPaid->paid;
                $user->requested_at = PaymentRequest::where('user_id', $user->id)
                    ->latest()->first();
                $user->payment_req = PaymentRequest::where('user_id', $user->id)->where('is_paid', false)->latest()->first();
            }
            $orders = UserRequests::where('user_id', $id)
                ->whereIn('status', ['COMPLETED', 'REJECTED'])
                ->where('paid', '0')->get();
            return view('account.users.payment', compact('users', 'orders','userDetails'));
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function payment_slip($id)
    {
        try {
            $payments = UserInvoice::find($id);
            return view('account.users.paymentSlip', compact('payments'));
        } catch (\Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }

    }

    public function update_paid(Request $request)
    {
        //get user whose payment is changed
        $user = User::findOrFail($request->id);
        $request->paid = $request->paid ? $request->paid : 0;

        //check for payment requests to update
        $paymentRequest = PaymentRequest::where('user_id', $user->id)->latest()->first();
        $existsRequest = PaymentRequest::where('user_id', $user->id)->where('is_paid', false)->count();

        //update the payment request and set updated
        if ($existsRequest > 0) {
            $paymentRequest->is_paid = true;
            $paymentRequest->save();
        } else {
            $payRequest = new PaymentRequest();
            $payRequest->user_id = $user->id;
            $payRequest->is_paid = true;
            $payRequest->save();
        }

        //change wallet balance as submitted by decreasing the paid amount
        $paymentHistory = new PaymentHistory;
        $paymentHistory->user_id = $user->id;
        $paymentHistory->changed_amount = -$request->paid;
        $paymentHistory->remarks = $request->remarks ? $request->remarks : "Changed by account";
        $paymentHistory->save();
        $user->wallet_balance -= $request->paid;
        $user->save();

        return back()->with('flash_success', 'Payment Updated');
    }

    public function clearData()
    {
        DB::beginTransaction();
        $user_requests = UserRequests::where('paid', '1')->get();
        foreach ($user_requests as $u) {
            $u->paid = '0';
            $u->invoice = null;
            $u->save();
        }
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_invoices')->delete();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::commit();
        return "success";
    }
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

                        $requests = UserRequests::whereHas('riderLog',function($query) use($request){
                            $query->where('completed_date', 'LIKE', $request->from_date . ' %');
                        })->where('status', $request->status);
                        if ($request->status == "TOBERETURNED" || $request->status == "RETURNED") {

                            $requests = UserRequests::whereHas('riderLog',function($query) use($request) {
                                $query->where('completed_date', 'LIKE', $request->from_date . ' %');
                            })
                                ->whereIn('status', ["CANCELLED", "REJECTED"])
                                ->where("returned", $request->status == "RETURNED");
                        }
                        $current['status'] = $request->status;
                    } else {
                        $requests = UserRequests::whereHas('riderLog',function($query) use($request) {
                            $query->where('completed_date', 'LIKE', $request->from_date . ' %');
                        });
                        $current['status'] = null;
                    }
                } else {
                    if ($request->status != "All") {

                        if( $request->status == 'REJECTED') {
                            $requests = UserRequests::whereHas('user',function($query){
                                            $query->where('settle',0);
                                    })->where(function($query) use ($request){
                                        $query->where('rejected_at','>=',$request->from_date);
                                    })->where(function($query) use ($request){
                                        $query->where('rejected_at','<=',$request->to_date);
                                    })->where('status',$request->status);

                        } else{
                            $requests = UserRequests::whereHas('riderLog',function($query) use($request) {
                                $query->where('completed_date', 'LIKE', $request->from_date . ' %');
                            })->where('status', $request->status);
                        }

                        if ($request->status == "TOBERETURNED" || $request->status == "RETURNED") {
                            $requests = UserRequests::whereHas('riderLog',function($query) use($request) {
                                $query->where('completed_date', 'LIKE', $request->from_date . ' %');
                            })
                                ->whereIn('status', ["CANCELLED", "REJECTED"])
                                ->where("returned", $request->status == "RETURNED");
                        }
                        $current['status'] = $request->status;
                    } else {
                        $requests = whereHas('riderLog',function($query) use($request) {
                            $query->where('completed_date', 'LIKE', $request->from_date . ' %');
                        });

                        $current['status'] = null;
                    }
                }

                if ($request->searchField!="") {
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
                    'status' => $request->status,
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
                $totalRiders = Provider::select("id", "first_name")->where("status", "approved")->orderBy('first_name')->get();
                $totalrequest = UserRequests::count();
                $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
                $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
                $allDates = UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
                    ->orWhere('updated_at', '>=', Carbon::now()->subMonth())
                    ->groupBy('date')
                    ->orderBy('date', 'DESC')
                    ->get(array(
                        DB::raw('Date(created_at) as date'),
                    ));
                $dates = [];
                $i = 0;
                foreach ($allDates as $d) {
                    $dates[$i] = $d->date;
                    $i++;
                }
                $current['date'] = $request->date;
                return view('account.orders.orderByDate', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'dates', 'current']));
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
                        DB::raw('Date(created_at) as date'),
                    ));
                $dates = [];
                $i = 0;
                foreach ($allDates as $d) {
                    $dates[$i] = $d->date;
                    $i++;
                }
                return view('account.orders.orderByDate', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'dates']));
            }
        } catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
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
            return view('account.orders.orderDetails', compact('request', 'promocode', 'comments','logs'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function commentAccount(Request $request, $req_id){
        try{

            $dept = Department::where('dept', '=', 'Accounts')->pluck('id')->first();
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = 'Accounts';
            $comment->comments = $request->input('comment');
            $comment->is_read_admin = '0';
            $comment->save();
            $solve_comment = UserRequests::findOrFail($req_id);
            $solve_comment->comment_status = 1;
            $solve_comment->update();
            //notify
            return back()->with('flash_success', 'Your message has send!!!');
        } catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
    public function riderSettleStatement($id){
        try{
            $Providers=Provider::findOrFail($id);
            $total_order=UserRequests::where('provider_id',$id)->count();
            $processing=UserRequests::where('provider_id',$id)->whereIn('status',['PENDING','ACCEPTED','ASSIGNED','SORTCENTER','DISPATCHED','NOTPICKEDUP','PICKEDUP'])->count();
            $Delivering=UserRequests::where('provider_id',$id)->where('status','DELIVERING')->count();
            $completed=UserRequests::where('provider_id',$id)->where('status','COMPLETED')->count();
            $cancelled=UserRequests::where('provider_id',$id)->whereIn('status',['REJECTED','CANCELLED'])->count();
            $Scheduled=UserRequests::where('provider_id',$id)->where('status','SCHEDULED')->count();
            $return_remaing=UserRequests::where('provider_id',$id)->whereIn('status',['REJECTED','CANCELLED'])->WHERE('returned_to_hub',0)->count();
            $returned=UserRequests::where('provider_id',$id)->whereIn('status',['REJECTED','CANCELLED'])->where('returned_to_hub',1)->count();
            $totalPayable = Provider::find($id, ['payable']);
                $totalOrder = UserRequests::where('provider_id', $id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('provider_id', $id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'earning')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'payable')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $Providers->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
                $Providers->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
            return view('account.providers.settlement',compact(['Providers','total_order','id','totalPayable','processing','Delivering','completed','cancelled','Scheduled','return_remaing','returned'
            ]));
        }
        catch(exception $e){
            return $e->getMessage();
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function settleRiderStatement(Request $request,$id){
        $this->validate($request, [
            'amount' => 'required',
            'remarks' => 'required',
        ]);
        try{
            $provider = Provider::findOrFail($id);
            $provider->settle = 1;
            $provider->status="banned";    
            $settlement =new settlementLog;
            $settlement->amount = $request->input('amount');
            $settlement->remarks = $request->input('remarks');
            $settlement->provider_id = $provider->id;
            $settlement->type = 'Rider';
            $settlement->save();
            $provider->save();
            return redirect()->route('account.ride.statement.provider')->with('flash_success', 'Settlement Done Successfully');

        }
        catch(exception $e){
            return $e->getMessage();
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function unsettleRider($id){
        try{
            $Provider=Provider::findorFail($id);
            $Provider->settle= 0;
            $Provider->save();
            return back()->with('flash_success', "Driver has been unsettled");
        }
        catch(exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function user()
    {
        try
        {
            if($users=Cache::get('user')) {
                $users = $users['Alluser'];
            }else{
                $users = [];
            }
            // dd($users);
            return view('account.users.user', compact('users'))->with('page','User Statement');
            

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    
    }
    public function provider()
    {
        try {
            $commision = UserRequestPayment::sum('commision');
            $revenues = UserRequestPayment::sum('total');

            
            $Providers = Provider::paginate(1000);

            foreach ($Providers as $index => $Provider) {

                $Rides = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $Providers[$index]->rides_count = $Rides->count();

                $Providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(\DB::raw(
                        'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                    ))->get();
                $totalOrder = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $Provider->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'earning')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $Provider->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'payable')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $Providers[$index]->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
                $Providers[$index]->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
            }
            return view('account.providers.providerwallet', compact('Providers', 'commision'))->with('page', 'Rider Statement');

        } catch (Exception $e) {

            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    function Order31()
    {   
        try{
            $request=UserRequests::where('created_at','<=','2021-07-15')->paginate(10000);
        }
        catch (Exception $e) {
            
            return back()->with('flash_error', 'Something Went Wrong!');
        }
        return view('account.order',compact(['request']));
    }
}
