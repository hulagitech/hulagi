<?php

namespace App\Http\Controllers;
use DB;

use Auth;
use Setting;
use App\Page;

use App\User;
use DateTime;
use App\Fleet;

use App\Zones;
use Exception;
use App\Ticket;
use App\Comment;
use App\Package;
use App\LostItem;
use App\OrderLog;
use App\Provider;
use App\RiderLog;
use App\ContactUs;
use \Carbon\Carbon;
use App\Department;
use App\FareSetting;
use App\ServiceType;
use App\UserPayment;
use App\PeakAndNight;
use App\UserRequests;

use App\BranchManager;
use App\Helpers\Helper;
use App\ProviderService;
use App\RiderPaymentLog;
use App\DispatchBulkList;
use App\DispatcherToZone;
use App\ZoneDispatchList;
use App\UserRequestRating;
use App\UserRequestPayment;
use App\ManagerToDispatcher;
use Illuminate\Http\Request;
use App\AssignedRidersHistory;

class BmController extends Controller
{

    public function dashboard()
    {
        try{
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            $incoming_order_id=DispatchBulkList::whereIn('zone2_id',$dispatcherid)
                    ->pluck('id')->toArray();
			$outgoing_order_id=DispatchBulkList::whereIn('zone1_id',$dispatcherid)
                    ->pluck('id')->toArray();
            // dd($outgoing_order_id);	
            
            //TodaY Order
            $incoming_order=ZoneDispatchList::whereIn('dispatch_id',$incoming_order_id)->where('created_at','LIKE',date("Y-m-d").'%')->count();
            $outgoing_order=ZoneDispatchList::whereIn('dispatch_id',$outgoing_order_id)->where('created_at','LIKE',date("Y-m-d").'%')->count();
            $Received_order=ZoneDispatchList::whereIn('dispatch_id',$incoming_order_id)->where('received',1)->where('created_at','LIKE',date("Y-m-d").'%')->count();
            $outgoing_receive=ZoneDispatchList::whereIn('dispatch_id',$outgoing_order_id)->where('received',1)->where('created_at','LIKE',date("Y-m-d").'%')->count();
            
            
            //Total Order

            $total_incoming_order=ZoneDispatchList::whereIn('dispatch_id',$incoming_order_id)->count();
            $total_outgoing_order=ZoneDispatchList::whereIn('dispatch_id',$outgoing_order_id)->count();
            $total_Received_order=ZoneDispatchList::whereIn('dispatch_id',$incoming_order_id)->where('received',1)->count();
            $total_outgoing_receive=ZoneDispatchList::whereIn('dispatch_id',$outgoing_order_id)->where('received',1)->count();
            
            return view('bm.dashboard',compact([
                'incoming_order',
                'outgoing_order',
                'Received_order',
                'outgoing_receive',
                'total_incoming_order',
                'total_outgoing_order',
                'total_Received_order',
                'total_outgoing_receive',
            ]));
        }
        catch(Exception $e){
            //dd($e->getMessage());
            return redirect()->route('bm.user.index')->with('flash_error','Something Went Wrong with Dashboard!');
        }
    }

    // Branch Manager Profile
    public function profile()
    {
        return view('bm.account.profile');
    }


    // Branch Manager Profile Update
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

            $bm = Auth::guard('bm')->user();
            $bm->name = $request->name;
            $bm->mobile = $request->mobile;
            //$account->save(); 
            return redirect()->back()->with('flash_success','Profile Updated');
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }  
    }



    // ___________________________________________________________________________________
    //             Order Comments
    // -----------------------------------------------------------------------------------
    public function unsolve_Comments()
    {
        // user_requests.comment_status = 0  ----> {Unsolve}
        try{
            $dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();
            $orderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->where('user_requests.dept_id', $dept)
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->get();

            foreach($orderComments as $orderComment){
                $orderComment->ur = UserRequests::where('id','=',$orderComment->request_id)->where('comment_status','=','0')->first();
                $orderComment->user = User::where('id','=',$orderComment->ur->user_id)->first();
                $orderComment->noComment = Comment::where('request_id', $orderComment->request_id)->where('is_read_bm','=',"1")->count();
            }
            
            return view('bm.ordercomment.unsolveComment', compact('orderComments'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function solved_Comments()
    {
        try{
            $dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();
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
                $orderComment->noComment = Comment::where('request_id', $orderComment->request_id)->where('is_read_bm','=',"1")->count();
            }

            //dd($orderComments);

            
            return view('bm.ordercomment.solvedComment', compact('orderComments'));
            
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
            
            return view('bm.ordercomment.comment_page', compact('comments', 'user_req', 'depts'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function orderCommentReply(Request $request, $req_id){
        try{
            $dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();

            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->authorised_type = "Branch Manager";
            $comment->comments = $request->input('comment');
            $comment->is_read_bm = '0';

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
            return redirect('/bm/unsolve_comments')->with('flash_success', 'Order problem solved successfully!');

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
            return redirect('/bm/solved_comments')->with('flash_success', 'Order problem reopen Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function Provider()
    {
        try{
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            // dd($currentZones);
            $Providers = Provider::with('service','accepted','cancelled', 'documents')
            ->whereIn('zone_id', $currentZones)
            ->orderBy('id', 'DESC')->paginate(20);
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

            $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
            $cancel_ride = UserRequests::where('status','CANCELLED');
            $cancel_rides = $cancel_ride->where('cancelled_by','PROVIDER')->count();
            // return view('admin.providers.index', compact('providers', 'documents', 'cancel_rides','rides'));
            $collection=$Providers->getCollection();
            $filtered=$collection->filter(function($rider) use($currentZones){
                return in_array($rider->zone_id,$currentZones);
            });
            $Providers->setCollection($filtered);
            
            $id=DB::table('providers')->select('id')->get();
        //return $id;
            // $todaycomleted=DB::table('rider_logs')
            //                 ->join('providers','complete_id',"=",'providers.id')
            //                 ->whereDate('completed_date', Carbon::today())->where('complete_id',"=",$id[0])->count();
            $rides=UserRequests::where(function($query) use($currentZones){
                $query->whereIn('zone1',$currentZones)->orWhereIn('zone2',$currentZones);
            })->count();
            $Zone=Zones::whereIn('id',$currentZones)->get();
            return view('bm.providers.index', compact('Providers','Zone','cancel_rides','rides'));

        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
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
    public function zoneProvider(Request $request)
    {
        try{
            //to get the dispatcher Id Assigned to Branch manager
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            // dd($currentZones);
            if($request->zones=="selectzone"){
                $Providers = Provider::with('service','accepted','cancelled', 'documents')
                    ->whereIn('zone_id', $currentZones)
                    ->orderBy('id', 'DESC')->paginate(20);
            }
            else{
                $Providers=Provider::whereIn('zone_id',$currentZones)->whereHas('zone',function($query) use($request){
                    $query->where('zone_name',$request->zones);
                })->get();
            }
           
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
            $Zone=Zones::whereIn('id',$currentZones)->get();
            return view('bm.providers.index', compact('Providers','Zone'));

        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function RecentTrips(Request $request){
		try {
           $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
           
            if(isset($request->search)){
                if($request->date=="All"){
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
                // dd($request->request);
                $current=[];
                if($request->from_date==""){
                    $request->date=$request->from_date;
                    if($request->status!="All"){
                        $requests = UserRequests::whereHas('user',function($query){
                                                $query->where('settle',0);})
                                    ->where(function($query) use ($request){
                                        $query->where('created_at','LIKE',$request->date.'%')
                                        ->orWhere('updated_at','LIKE',$request->date.'%');
                                    })
                                    ->where('status',$request->status);
                        if($request->status=="TOBERETURNED" || $request->status=="RETURNED" || $request->status=="R.WAREHOUSE"){
                            if($request->status=="TOBERETURNED"){
                                 $requests = UserRequests::whereHas('user',function($query){
                                                $query->where('settle',0);})->where(function($query) use ($request){
                                            $query->where('created_at','LIKE',$request->date.'%')
                                            ->orWhere('updated_at','LIKE',$request->date.'%');
                                        })
                                        ->whereIn('status',["CANCELLED","REJECTED"])
                                        ->where('returned_to_hub',0)
                                        ->where("returned",$request->status=="RETURNED");
                            }
                            else{
                            $requests = UserRequests::whereHas('user',function($query){
                                                $query->where('settle',0);})->where(function($query) use ($request){
                                            $query->where('created_at','LIKE',$request->date.'%')
                                            ->orWhere('updated_at','LIKE',$request->date.'%');
                                        })
                                        ->whereIn('status',["CANCELLED","REJECTED"])
                                        ->where('returned_to_hub',1)
                                        ->where("returned",$request->status=="RETURNED");
                            }
                        }
                        $current['status']=$request->status;
                    }
                    else{
                        $requests = UserRequests::whereHas('user',function($query){
                                                $query->where('settle',0);})->where(function($query) use ($request){
                                        $query->where('created_at','LIKE',$request->date.'%')
                                        ->orWhere('updated_at','LIKE',$request->date.'%');
                                    });
                        $current['status']=null;
                    }
                }
                else{
                    if($request->status!="All"){
                        $requests = UserRequests::whereHas('user',function($query){
                                                $query->where('settle',0);})->where(function($query) use ($request){
                                        $query->where('created_at','>=',$request->from_date)
                                        ->orWhere('updated_at','>=',$request->from_date);
                                    })
                                    ->where(function($query) use ($request){
                                        $query->where('created_at','<=',$request->to_date)
                                        ->orWhere('updated_at','<=',$request->to_date);
                                    })
                                    ->where('status',$request->status);
                        if($request->status=="TOBERETURNED" || $request->status=="RETURNED"){
                            $requests = UserRequests::whereHas('user',function($query){
                                                $query->where('settle',0);})->where(function($query) use ($request){
                                            $query->where('created_at','>=',$request->from_date)
                                            ->orWhere('updated_at','>=',$request->from_date);
                                        })
                                        ->where(function($query) use ($request){
                                            $query->where('created_at','<=',$request->to_date)
                                            ->orWhere('updated_at','<=',$request->to_date);
                                        })
                                        ->whereIn('status',["CANCELLED","REJECTED"])
                                        ->where('returned_to_hub',0)
                                        ->where("returned",$request->status=="RETURNED");
                        }
                        $current['status']=$request->status;
                    }
                    else{
                        $requests = UserRequests::whereHas('user',function($query){
                                                $query->where('settle',0);})->where(function($query) use ($request){
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

                if($request->has('searchField')){
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
                	//we have to filter out the requests based on the zone in which dispatcher works

				//get the zones of current dispatcher
                 $zones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
				//create new collection and filter only those which are in the zone
				$dispatcherRequests=$requests->get();
				$dispatcherRequests=$dispatcherRequests->filter(function($req) use($zones){
					return (in_array($req->zone1,$zones) || in_array($req->zone2,$zones));
				});
				//note that we could get the requests directly using this method in dispatcherRequests but in order
				//to paginate, we are using whereIn
				$requests=$requests->whereIn('id',$dispatcherRequests->pluck('id')->toArray())->paginate(100);
                // Multilevel Pagination
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
                return view('bm.request.index', compact(['requests','totalRiders', 'dates']));
            }
            else{
                $requests = [];
                $totalRiders=[];
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

				//To Count Comment in each Order
				foreach($requests as $request){
					$request->noComment = Comment::where('request_id', $request->id)->where('is_read_dispatcher','=',"1")->count();
				}
                return view('bm.request.index', compact(['requests','totalRiders', 'dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	
    }
    public function bm_sortcenter(){
        try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            
            $totalRiders = Provider::select("id","first_name")->where("status","approved")->whereIn('zone_id', $currentZones)->orderBy('first_name')->get();
            
            $dispatch_lists = ZoneDispatchList::where('dispatch_id', '>', '0')->where('received', '=', '1')->pluck('request_id')->toArray();
            $requests = UserRequests::where(function($query) use($currentZones){
                                    $query->whereIn('zone1', $currentZones)
                                            ->where('status', '=', 'SORTCENTER');
                            })
                            ->OrWhere(function($query) use($currentZones, $dispatch_lists){
                                    $query->whereIn('zone2', $currentZones)
                                            ->whereIn('id', $dispatch_lists)
                                            ->where('status', '=', 'SORTCENTER');
                            })
                            ->orderBy('created_at', 'ASC')->paginate(100);
                            //->where('status', '=', 'SORTCENTER');

            foreach($requests as $request){
                $request->noComment = Comment::where('request_id', $request->id)->where('is_read_dispatcher','=',"1")->count();
            }
            // dd($requests);

            
            return view('bm.request.sortcenter', compact(['requests', 'totalRiders']));
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        } 
    }

    public function dispatcher_returnRemaining(){
         try {
           $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            
            $totalRiders = Provider::select("id","first_name")->where("status","approved")->whereIn('zone_id', $currentZones)->orderBy('first_name')->get();

            $dispatch_lists = ZoneDispatchList::where('dispatch_id', '>', '0')->where('received', '=', '1')->pluck('request_id')->toArray();
            $requests = UserRequests::where(function($query) use($currentZones, $dispatch_lists){
                                            $query->whereIn('zone2', $currentZones)
                                                ->whereIn('id', $dispatch_lists)
                                                ->where('status', '=', 'REJECTED');
                                    })
                                    ->where('returned_to_hub', '=', '0')
                                    ->orderBy('created_at', 'ASC')->paginate(100);

                            // ->orWhere(function($query) use($currentZones){
                            //         $query->whereIn('zone1', $currentZones);
                            // })
            
            foreach($requests as $request){
                $request->noComment = Comment::where('request_id', $request->id)->where('is_read_dispatcher','=',"1")->count();
            }

            
            return view('bm.request.return', compact(['requests', 'totalRiders']));
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function dispatcher_delivering(){
        try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            
            $totalRiders = Provider::select("id","first_name")->where("status","approved")->whereIn('zone_id', $currentZones)->orderBy('first_name')->get();

            $dispatch_lists = ZoneDispatchList::where('dispatch_id', '>', '0')->where('received', '=', '1')->pluck('request_id')->toArray();
            $requests = UserRequests::where(function($query) use($currentZones, $dispatch_lists){
                                            $query->whereIn('zone2', $currentZones)
                                                // ->whereIn('id', $dispatch_lists)
                                                ->where('status', '=', 'DELIVERING');
                                    })
                                    ->orderBy('created_at', 'ASC')->paginate(100);

                            // ->orWhere(function($query) use($currentZones){
                            //         $query->whereIn('zone1', $currentZones);
                            // })
            
            foreach($requests as $request){
                $request->noComment = Comment::where('request_id', $request->id)->where('is_read_dispatcher','=',"1")->count();
            }

            
            return view('bm.request.delivering', compact(['requests', 'totalRiders']));
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    public function dispatcher_scheduled(){
        try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            // dd($currentZones);
            $totalRiders = Provider::select("id","first_name")->where("status","approved")->whereIn('zone_id', $currentZones)->orderBy('first_name')->get();

            $dispatch_lists = ZoneDispatchList::where('dispatch_id', '>', '0')->where('received', '=', '1')->pluck('request_id')->toArray();
            // dd($dispatch_lists);
            $requests = UserRequests::where(function($query) use($currentZones, $dispatch_lists){
                                            $query->whereIn('zone2', $currentZones)
                                                // ->whereIn('id', $dispatch_lists)
                                                ->where('status', '=', 'SCHEDULED');
                                    })
                                    // ->where('status', '=', 'DELIVERING')
                                    ->orderBy('created_at', 'ASC')->paginate(100);

                            // ->orWhere(function($query) use($currentZones){
                            //         $query->whereIn('zone1', $currentZones);
                            // })
            
            foreach($requests as $request){
                $request->noComment = Comment::where('request_id', $request->id)->where('is_read_dispatcher','=',"1")->count();
            }

            
            return view('bm.request.scheduled', compact(['requests', 'totalRiders']));
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function riderAssign(Request $request, $id)
    {
        try {
            $UserRequest = UserRequests::findOrFail($id);

            if($request->ajax()){
                if(isset($request->provider)){
                    $log=new OrderLog();
                    $provider=Provider::find($request->provider);
                    $log->create([
                        'request_id'=>$UserRequest->id,
                        'type' => "rider",
                        'description' => 'Rider changed from '.($UserRequest->provider?$UserRequest->provider->first_name:"None")." to ".($provider?$provider->first_name:"None").". Status:".$UserRequest->status ." by ".Auth::user()->name
                    ]);
                    if ($UserRequest->status=="SORTCENTER"){
                        $UserRequest->provider_id = $request->provider;
                        $UserRequest->status = "DELIVERING";
                    }
                    AssignedRidersHistory::create([
                        'request_id'=>$UserRequest->id,
                        'rider_id'=>$UserRequest->provider_id,
                        'status'=>$UserRequest->status
                    ]);
                    $a=$UserRequest->save();
                }
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

    public function CustomerQuery()
    {
        try{
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            $request=UserRequests::whereIn('status',['SORTCENTER','DELIVERING','SCHEDULED'])->whereIn('zone2',$currentZones)
            ->whereHas('comment', function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 1');
                })->get();

            return view('bm.request.CustomerQuery',compact(['request']));
        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function InactiveOrder()
    {
        try{
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            $request=UserRequests::whereIn('status',['SORTCENTER','SCHEDULED','DISPATCHED','DELIVERING'])
                                        ->where(function($query) use ($currentZones){
                                            $query->whereIn('zone2',$currentZones)
                                            ->orwhereIn('zone1',$currentZones);
                                        })
            ->whereRaw('TIMESTAMPDIFF(day, updated_at, CURRENT_TIMESTAMP) > 1')
            ->get();

            return view('bm.request.inactive',compact(['request']));
        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function delaySearch(Request $request){
        try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            if(isset($request->search)){ 
                if($request->status=="Delayed"){
                    $requests=UserRequests::whereColumn('zone1','!=','zone2')
                                ->join('fares',function($join){
                                    $join->on('user_requests.zone1','=','fares.zone1_id')
                                        ->on('user_requests.zone2','=','fares.zone2_id')
                                        ->whereNotNull('fares.delay_period');
                                        // ->whereNotNull('fares.extremely_delay_period');
                                })->select(['user_requests.*','fares.delay_period','fares.extremely_delay_period'])
                                ->selectRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) as duration')
                                ->whereRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) >= fares.delay_period')
                                ->whereRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) < fares.extremely_delay_period');
                }
                else{//Extremely Delayed
                    $requests=UserRequests::whereColumn('zone1','!=','zone2')
                                ->join('fares',function($join){
                                    $join->on('user_requests.zone1','=','fares.zone1_id')
                                        ->on('user_requests.zone2','=','fares.zone2_id')
                                        ->whereNotNull('fares.extremely_delay_period');
                                })->select(['user_requests.*','fares.extremely_delay_period'])
                                ->selectRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) as duration')
                                ->whereRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) >= fares.extremely_delay_period');
                }
                if($request->zone!="All"){
                    // get delayed of specific zone
                    $requests->where('user_requests.zone2',$request->zone);
                }
                $requests=$requests->whereNotIn('status',['COMPLETED','REJECTED','CANCELLED'])->orderBy('user_requests.created_at','DESC')->paginate(100);
                $requests->appends([
					'zone'=>$request->search,
					'status'=>$request->status
				]); // End of multilevel Pagination.

                $zones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->get();
                return view('bm.request.delay', compact(['requests','zones']));
            }
            else{
                $requests = [];
                $zones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->get();
                // $zones=Zones::all();
                return view('bm.request.delay', compact(['requests','zones']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
   
    public function branchSloveComments(){
         try{
            //$dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();
           $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();

            $orderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '1')
                                ->where(function($query) use($currentZones){
                                    $query->whereIn('user_requests.zone1', $currentZones)
                                            ->orWhereIn('user_requests.zone2', $currentZones);
                                })
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->get();
                                //->paginate(100);
                                // ->where('user_requests.dept_id', $dept)
                                // ->whereIn('user_requests.zone1', $currentZones)
                                // ->orWhereIn('user_requests.zone2', $currentZones)

            foreach($orderComments as $orderComment){
                $orderComment->ur = UserRequests::where('id','=',$orderComment->request_id)->where('comment_status', '=', '1')->first();
                $orderComment->user = User::where('id','=',$orderComment->ur->user_id)->first();
                $orderComment->noComment = Comment::where('request_id', $orderComment->request_id)->where('is_read_dispatcher','=',"1")->count();
            }

            //dd($orderComments);

            
            return view('bm.ordercomment.branchSolveComment', compact('orderComments'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function branchUnsolveComments(){
         try{
            //$dept = Department::where('dept', '=', 'dispatcher')->pluck('id')->first();
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            $orderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->where(function($query) use($currentZones){
                                    $query->whereIn('user_requests.zone1', $currentZones)
                                            ->orWhereIn('user_requests.zone2', $currentZones);
                                })
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->get();
                                //->paginate(100);
                                //->orWhereIn('user_requests.zone2', $currentZones)
                                //->where('user_requests.dept_id', $dept)
            
            //$orderComments = $orderComments->paginate(100);
            foreach($orderComments as $orderComment){
                $orderComment->ur = UserRequests::where('id','=',$orderComment->request_id)->where('comment_status','=','0')->first();
                $orderComment->user = User::where('id','=',$orderComment->ur->user_id)->first();
                $orderComment->noComment = Comment::where('request_id', $orderComment->request_id)->where('is_read_dispatcher','=',"1")->count();
            }
            
            return view('bm.ordercomment.branchUnsolveComment', compact('orderComments'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
     public function orders_Detail($id){
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
            
            return view('bm.ordercomment.orderDetail', compact('comments', 'user_req', 'depts'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }    
     public function getOrderDetails($id)
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
            return view('bm.layout.Order', compact('request','promocode', 'comments','logs'));
        }   catch (Exception $e) {
            return response()->json(['error' => trans('something_went_wrong')]);
        }
    }
   

}
