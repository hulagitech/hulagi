<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Session;
use Setting;
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
use App\Dispatcher;
use App\ServiceType;
use App\UserRequests;
use App\RequestFilter;
use App\Helpers\Helper;
use App\ProviderService;
use App\RiderPaymentLog;

use App\CorporateAccount;
use App\DispatchBulkList;
use App\DispatcherToZone;
use App\ZoneDispatchList;
use App\Model\Notification;
use App\UserRequestPayment;
use Illuminate\Http\Request;
use App\AssignedRidersHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RiderLogController;


class DispatcherNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pending=DispatchBulkList::where('received_all','=', '0')
                    ->where('incomplete_received', '=', '0')
                    ->where('draft', '=', '0')
                    ->where('Returned','!=','1')
                    ->where('zone2_id',Auth::user()->id)
                    ->withCount(['lists'])
                    ->get();

            $complete_received=DispatchBulkList::where('received',true)
                    ->where('received_all',true)
                    ->where('incomplete_received',false)
                    ->where('draft', false)
                    ->where('zone2_id',Auth::user()->id)
                    ->get();
            $incomplete_received=DispatchBulkList::where('received',true)
                    ->where('received_all',false)
                    ->where('incomplete_received', true)
                    ->where('draft', false)
                    ->where('zone2_id',Auth::user()->id)
                    ->get();

            $dispatch=DispatchBulkList::where('draft','=','0')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();

            $complete_reached=DispatchBulkList::where('received',true)
                    ->where('received_all',true)
                    ->where('incomplete_received',false)
                    ->where('draft','=','0')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();
            $incomplete_reached=DispatchBulkList::where('received_all',false)
                    ->where('incomplete_received', true)
                    ->where('draft','=','0')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();

            $draft=DispatchBulkList::where('received',false)
                    ->where('draft','=','1')
                    ->where('zone1_id',Auth::user()->id)
                    ->get();
            
            $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
            $rider = Provider::whereIn('zone_id', $currentZones)->count();

            
            return view('dispatcher.dashboard', compact(['pending', 'complete_received', 'incomplete_received', 'dispatch', 'complete_reached', 'incomplete_reached', 'draft', 'rider']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }

        // return view('dispatcher.dashboard', compact('promocodes'));
    }

    public function complete_received()
    {
        try {
            $requests=DispatchBulkList::where('received',true)
                    ->where('received_all',true)
                    ->where('incomplete_received', false)
                    ->where('draft', false)
                    ->where('zone2_id',Auth::user()->id)
                    ->withCount('lists')
                    ->get();
            
            return view('dispatcher.dispatchList.completeReceived', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}


    public function incomplete_received()
    {
        try {
            $requests=DispatchBulkList::where('incomplete_received', true)
                    ->where('received_all',false)
                    ->where('draft', false)
                    ->where('zone2_id',Auth::user()->id)
                    ->withCount(['lists',
                    'lists as received'=>function($query){
                        $query->where('received', '=', '1');
                    }])
                    ->get();

            return view('dispatcher.dispatchList.incompleteReceived', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
    public function dispatcherProvider()
    {
        try{
            $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
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
           

            return view('dispatcher.providers.index', compact('Providers','cancel_rides','rides','Zone'));

        } catch (Exception $e) {
            dd($e->getMessage());
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    public function dispatcher_sortcenter()
    {
        try {
            $currentZones = DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
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

            
            return view('dispatcher.request.sortcenter', compact(['requests', 'totalRiders']));
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        } 
    }

    public function dispatcher_delivering(){
        try {
            $currentZones = DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
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

            
            return view('dispatcher.request.delivering', compact(['requests', 'totalRiders']));
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function dispatcher_scheduled(){
        try {
            $currentZones = DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
            $totalRiders = Provider::select("id","first_name")->where("status","approved")->whereIn('zone_id', $currentZones)->orderBy('first_name')->get();

            $dispatch_lists = ZoneDispatchList::where('dispatch_id', '>', '0')->where('received', '=', '1')->pluck('request_id')->toArray();
            $requests = UserRequests::where(function($query) use($currentZones, $dispatch_lists){
                                            $query->whereIn('zone2', $currentZones)
                                                ->whereIn('id', $dispatch_lists)
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

            
            return view('dispatcher.request.scheduled', compact(['requests', 'totalRiders']));
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    public function dispatcher_returnRemaining(){
        try {
            $currentZones = DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
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

            
            return view('dispatcher.request.return', compact(['requests', 'totalRiders']));
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



    // ___________________________________________________________________________________
    //             SORTCENTER and Delivering --> "Order Comments"
    // -----------------------------------------------------------------------------------
    // public function orderComment($id){
    //     try{
    //         $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
    //         $comments = Comment::where('request_id','=',$id)->orderBy('created_at', 'ASC')->get();

    //         foreach($comments as $comment){
    //             if ($comment->dept_id == $dept){
    //                 $dispatcherZone = DispatcherToZone::where('dispatcher_id', $comment->authorised_id)->pluck('zone_id')->first();
    //                 $comment->zone = Zones::where('id', $dispatcherZone)->pluck('zone_name')->first();
    //             }
    //         }

    //         //$comments = Comment::where('request_id','=',$id)->orderBy('created_at', 'ASC')->get();
    //         $user_req = UserRequests::where('id', $id)->first();
    //         $depts = Department::orderBy('dept')->get();
    //         // dd($user_req->item());

    //         return view('dispatcher.ordercomment.index', compact(['comments', 'user_req', 'depts']));
            
    //     } catch (Exception $e){
    //         return back()->with('flash_error', 'Something went wrong!');
    //     }
    // }

    // public function orderReply(Request $request, $req_id){
    //     try{
    //         $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();

    //         $comment = new Comment();
    //         $comment->request_id = $req_id;
    //         $comment->dept_id = $dept;
    //         $comment->authorised_id = Auth::user()->id;
    //         $comment->authorised_type="Dispatcher";
    //         $comment->comments = $request->input('comment');
    //         $comment->is_read_dispatcher = '0';

    //         $comment->save();
    //         return back()->with('flash_success', 'Your comment has send!!!');
    //     } catch (Exception $e){
    //         return back()->with('flash_error', 'Something went wrong!');
    //     }
    // }




    // ___________________________________________________________________________________
    //             Order Comments
    // -----------------------------------------------------------------------------------
    public function unsolve_Comments()
    {
        try{
            //$dept = Department::where('dept', '=', 'dispatcher')->pluck('id')->first();
            $currentZones = DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();

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
            
            return view('dispatcher.ordercomment.unsolveComment', compact('orderComments'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function solved_Comments()
    {
        try{
            //$dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();
            $currentZones = DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();

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

            
            return view('dispatcher.ordercomment.solvedComment', compact('orderComments'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // Order and Comment View Page.
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
             $logs=OrderLog::where('request_id',$id)->orderBy('created_at','DESC')->get();

            $user_req = UserRequests::where('id', $id)->first();
            $depts = Department::orderBy('dept')->get();
            
            return view('dispatcher.ordercomment.comment_page', compact('comments', 'user_req','logs', 'depts'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function orderCommentReply(Request $request, $req_id){
        try{
            // dd('hi');
            $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
            // dd($dept);
            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_type="Dispatcher";
            $comment->authorised_id = Auth::user()->id;
            $comment->comments = $request->input('comment');
            $comment->is_read_dispatcher = '0';

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
            return back()->with('flash_success', 'Your comment has send!!!');
            
        } catch (Exception $e){
            return $e->getMessage();
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function Dispatchcomment(Request $request ,$id){
		try{
            $this->validate($request,[
                'comment' => 'required'
            ]);
            $dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();

            
			// dd($request->comment);
			$bulk=DispatchBulkList::findOrFail($id);
			// dd($bulk->id);
			$requests=ZoneDispatchList::where('dispatch_id',$id)->pluck('request_id')->toArray();
			$dept = Department::where('dept', '=', 'Dispatcher')->pluck('id')->first();
			foreach($requests as $req){
                $comment = new Comment();
                $comment->request_id = $req;
                $comment->dept_id = $dept;
                $comment->authorised_type="Dispatcher";
                $comment->authorised_id = Auth::user()->id;
                $comment->comments = $request->input('comment');
                $comment->is_read_dispatcher = '0';
                $comment->save();
			}

			return back()->with('flash_success','Comment has been posted');
		}catch(Exception $e){
            return back()->with('flash_error','Comment is required ');
		}
	}

    // To make Solved Order
    public function solvedOrder(Request $request, $req_id){
        try{
            $solve_order = UserRequests::findOrFail($req_id);
            $solve_order->comment_status = $request->input('status');

            $solve_order->update();
            if($request->filter == 0){
                return redirect('/dispatcher/unsolve_comments')->with('flash_success', 'Order problem solved successfully!');
            }else{
                //return redirect('/dispatcher')->with('flash_success', 'Order problem solved successfully!');
                return back()->with('flash_success', 'Order problem solved successfully!');
            }

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
            //return redirect('/dispatcher/solved_comments')->with('flash_success', 'Order problem reopen Successfully!');
            if($request->filter == 0){
                return redirect('/dispatcher/solved_comments')->with('flash_success', 'Order problem reopen Successfully!');
            }else{
                //return redirect('/dispatcher')->with('flash_success', 'Order problem reopen Successfully!');
                return back()->with('flash_success', 'Order problem reopen Successfully!');
            }

        }catch (Exception $e){
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
            
            return view('dispatcher.ordercomment.orderDetail', compact('comments', 'user_req', 'depts'));
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function delaySearch(Request $request)
    {
        try {
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

                $zones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->get();
                return view('dispatcher.request.delay', compact(['requests','zones']));
            }
            else{
                $requests = [];
                $zones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->get();
                // $zones=Zones::all();
                return view('dispatcher.request.delay', compact(['requests','zones']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function CustomerQuery()
    {
        try{
            $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
            $request=UserRequests::whereIn('status',['SORTCENTER','DELIVERING','SCHEDULED'])->where('zone2',$currentZones)
            ->whereHas('comment', function ($query) {
                    $query->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) >= 1');
                })->get();

            return view('dispatcher.request.CustomerQuery',compact(['request']));
        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function InactiveOrder()
    {
        try{
            $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
            $request=UserRequests::whereIn('status',['SORTCENTER','SCHEDULED','DISPATCHED','DELIVERING'])
                                        ->where(function($query) use ($currentZones){
                                            $query->whereIn('zone2',$currentZones)
                                            ->orwhereIn('zone1',$currentZones);
                                        })
            ->whereRaw('TIMESTAMPDIFF(day, updated_at, CURRENT_TIMESTAMP) > 1')
            ->get();

            return view('dispatcher.request.inactive',compact(['request']));
        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function zoneProvider(Request $request)
    {
        try{
            $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
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
            return view('dispatcher.providers.index', compact('Providers','Zone'));

        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
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
            return view('Dispatcher.layout.Order', compact('request','promocode', 'comments','logs'));
        }   catch (Exception $e) {
            return response()->json(['error' => trans('something_went_wrong')]);
        }
    }


}
