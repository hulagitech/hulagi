<?php

namespace App\Http\Controllers\Resource;

use App\AssignedRidersHistory;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RiderLogController;
use App\UserRequests;
use App\Provider;
use App\PaymentHistory;
use App\RiderLog;
use App\User;
use Auth;
use DateTime;
use Setting;
use DB;
use App\Comment;
use App\Fare;
use App\ZoneDispatchList;
use App\Zones;

use App\DispatcherToZone;
use App\Department;

class TripResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //$requests = UserRequests::whereNotIn('status',['CANCELLED','SCHEDULED','PENDING','COMPLETED'])->RequestHistory()->get();
            $requests = UserRequests::whereNotIn('status',['CANCELLED','SCHEDULED','PENDING','COMPLETED'])->RequestHistory()->paginate(100);
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
            foreach($requests as $request){
                $request->log=RiderLog::where('request_id',$request->id)->first();
            }
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function pending()
    {
        try {
            //$requests = UserRequests::where('status','PENDING')->RequestHistory()->get();
            $requests = UserRequests::where('status','PENDING')->RequestHistory()->paginate(100);
            foreach($requests as $request){
                $request->log=RiderLog::where('request_id',$request->id)->first();
            }
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount','totalRiders']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function bulkAssignUI()
    {
        try {
            $requests = UserRequests::groupBy('user_id')
                        ->select('user_id','status','provider_id','s_address',
                                DB::raw('count(*) as count'))
                        ->where('status','PENDING')
                        ->get();
            foreach($requests as $request){
                $r=UserRequests::where('user_id',$request->user_id)
                                        ->select(DB::raw("sum(if(user_requests.returned='0',1,0)) as r"))
                                        ->whereIn('status',["CANCELLED","REJECTED"])
                                        ->first();
                $request->r=$r->r;
            }
            // dd($requests);
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
            return view('admin.request.bulk', compact(['requests','totalRiders']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function bulkAssign(Request $request, $id)
    {
        try {
            $user=User::findOrFail($id);
            UserRequests::where('user_id',$id)
                        ->where('status','PENDING')
                        ->update(array('provider_id'=>$request->provider, 'status'=>"ACCEPTED"));
            return response()->json([
                'request' => $request,
                'error' => true
            ]);
        }   catch (Exception $e) {
            return response()->json([
                'showError' => true,
                'error' => "Error! Please try again."
            ]);
        }
    }

    public function accepted()
    {
        try {
            //$requests = UserRequests::where('status','ACCEPTED')->RequestHistory()->get();
            $requests = UserRequests::where('status','ACCEPTED')->RequestHistory()->paginate(100);
            foreach($requests as $request){
                $request->log=RiderLog::where('request_id',$request->id)->first();
            }
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount','totalRiders']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function allRequests()
    {
        try {
            //$requests = UserRequests::where('status','!=','CANCELLED')->RequestHistory()->get();
            $requests = UserRequests::where('status','!=','CANCELLED')->RequestHistory()->paginate(100);
            foreach($requests as $request){
                $request->log=RiderLog::where('request_id',$request->id)->first();
            }
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount','totalRiders']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    // public function dateSearch(Request $request)
    // {
    //     try {
    //         if(isset($request->search)){
    //             if($request->date=="All"){
    //                 $request->date='';
    //             }
    //             $current=[];
    //             if($request->status!="All"){
    //                 $requests = UserRequests::where(function($query) use ($request){
    //                                 $query->where('created_at','LIKE',$request->date.'%')
    //                                 ->orWhere('updated_at','LIKE',$request->date.'%');
    //                             })
    //                             ->where('status',$request->status);
    //                 if($request->status=="TOBERETURNED" || $request->status=="RETURNED"){
    //                     $requests = UserRequests::where(function($query) use ($request){
    //                                     $query->where('created_at','LIKE',$request->date.'%')
    //                                     ->orWhere('updated_at','LIKE',$request->date.'%');
    //                                 })
    //                                 ->whereIn('status',["CANCELLED","REJECTED"])
    //                                 ->where("returned",$request->status=="RETURNED");
    //                 }
    //                 $current['status']=$request->status;
    //             }
    //             else{
    //                 $requests = UserRequests::where(function($query) use ($request){
    //                                 $query->where('created_at','LIKE',$request->date.'%')
    //                                 ->orWhere('updated_at','LIKE',$request->date.'%');
    //                             });
    //                 $current['status']=null;
    //             }

    //             if($request->has('searchField')){
    //                 $requests=$requests->where(function($q) use ($request){
    //                     $q->whereHas('user',function($query) use ($request){
    //                         $query->where('first_name', 'LIKE' ,'%'.$request->searchField.'%')
    //                         ->orWhere('first_name', 'LIKE' ,'%'.$request->searchField.'%')
    //                         ->orWhere('mobile', 'LIKE' ,'%'.$request->searchField.'%');
    //                     })->orWhereHas('item',function($query) use ($request){
    //                         $query->where('rec_name', 'LIKE' ,'%'.$request->searchField.'%')	
    //                         ->orWhere('rec_mobile', 'LIKE' ,'%'.$request->searchField.'%');
    //                     })->orWhereHas('provider',function($query) use ($request){
    //                         $query->whereRaw("concat(first_name, ' ', last_name) like '%" .$request->searchField ."%' ")
    //                         ->orWhere('mobile', 'LIKE' ,'%'.$request->searchField.'%');
    //                     });
    //                 })
    //                 ->orWhere('booking_id','LIKE','%'.$request->searchField.'%');
    //             }
    //             $requests=$requests->get();
    //             foreach($requests as $request){
    //                 $request->log=RiderLog::where('request_id',$request->id)->first();
    //             }
    //             $totalRiders=Provider::select("id","first_name")->get();
    //             $totalrequest = UserRequests::count();
    //             $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
    //             $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
    //             $allDates= UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
    //                 ->orWhere('updated_at', '>=', Carbon::now()->subMonth())
    //                 ->groupBy('date')
    //                 ->orderBy('date', 'DESC')
    //                 ->get(array(
    //                     DB::raw('Date(created_at) as date')
    //                 ));
    //             $dates=[];
    //             $i=0;
    //             foreach($allDates as $d){
    //                 $dates[$i]=$d->date;
    //                 $i++;
    //             }
    //             $current['date']=$request->date;
    //             return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates', 'current']));
    //         }
    //         else{
    //             $requests = [];
    //             $totalRiders=[];
    //             $totalrequest = [];
    //             $totalcanceltrip = [];
    //             $totalpaidamount = [];
    //             $allDates= UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
    //                 ->groupBy('date')
    //                 ->orderBy('date', 'DESC')
    //                 ->get(array(
    //                     DB::raw('Date(created_at) as date')
    //                 ));
    //             $dates=[];
    //             $i=0;
    //             foreach($allDates as $d){
    //                 $dates[$i]=$d->date;
    //                 $i++;
    //             }
    //             return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates']));
    //         }
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
                return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates', 'current']));
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
                return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders', 'dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
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
                                })->select(['user_requests.*','fares.delay_period'])
                                ->selectRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) as duration')
                                ->whereRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) > fares.delay_period');
                }
                else{//Extremely Delayed
                    $requests=UserRequests::whereColumn('zone1','!=','zone2')
                                ->join('fares',function($join){
                                    $join->on('user_requests.zone1','=','fares.zone1_id')
                                        ->on('user_requests.zone2','=','fares.zone2_id')
                                        ->whereNotNull('fares.extremely_delay_period');
                                })->select(['user_requests.*','fares.extremely_delay_period'])
                                ->selectRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) as duration')
                                ->whereRaw('TIMESTAMPDIFF(day, user_requests.created_at, CURRENT_TIMESTAMP) > fares.extremely_delay_period');
                }
                if($request->zone!="All"){
                    // get delayed of specific zone
                    $requests->where('user_requests.zone2',$request->zone);
                }
                $requests=$requests->orderBy('user_requests.created_at','DESC')->paginate(100);
                $requests->appends([
					'zone'=>$request->search,
					'status'=>$request->status
				]); // End of multilevel Pagination.

                $zones=Zones::all();
                return view('admin.request.delay', compact(['requests','zones']));
            }
            else{
                $requests = [];
                $zones=Zones::all();
                return view('admin.request.delay', compact(['requests','zones']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetindex()
    {
        try {
            // $requests = UserRequests::RequestHistory()
            //             ->whereHas('provider', function($query) {
            //                 $query->where('fleet', Auth::user()->id );
            //             })->get();
            $requests = UserRequests::RequestHistory()
                        ->whereHas('provider', function($query) {
                            $query->where('fleet', Auth::user()->id );
                        })->paginate(100);

            return view('fleet.request.index', compact('requests'));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scheduled()
    {
        try{
            $requests = UserRequests::where('status' , 'SCHEDULED')
                        ->RequestHistory()
                        ->get();

            return view('admin.request.scheduled', compact('requests'));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }


    public function cancelTrip()
    {
        try {
            //$requests = UserRequests::whereIn('status',['CANCELLED'])->RequestHistory()->get();
            $requests = UserRequests::whereIn('status',['CANCELLED'])->RequestHistory()->paginate(100);
            foreach($requests as $request){
                $request->log=RiderLog::where('request_id',$request->id)->first();
            }
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders']));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function completedTrip()
    {
        try {
            //$requests = UserRequests::whereIn('status',['COMPLETED'])->RequestHistory()->get();
            $requests = UserRequests::whereIn('status',['COMPLETED'])->RequestHistory()->paginate(100);

            $totalRiders=Provider::select("id","first_name")->where("status","approved")->orderBy('first_name')->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('admin.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount', 'totalRiders']));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Fleetscheduled()
    {
        try{
            $requests = UserRequests::where('status' , 'SCHEDULED')
                         ->whereHas('provider', function($query) {
                            $query->where('fleet', Auth::user()->id );
                        })
                        ->get();

            return view('fleet.request.scheduled', compact('requests'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                's_latitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                'promo_code' => 'exists:promocodes,promo_code',
                'distance' => 'required|numeric',
                'use_wallet' => 'numeric',
                'payment_mode' => 'required|in:CASH,CARD,PAYPAL',
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

            // if(Auth::guard('dispatcher')->user()){
            //     return view('dispatcher.request.show', compact('request','promocode', 'comments'));    
            // }
            return view('admin.request.show', compact('request','promocode', 'comments'));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetshow($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('fleet.request.show', compact('request'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Accountshow($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('account.request.show', compact('request'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            $provider= Provider::select('id','first_name')   
                    ->get();
            $promocode = $request->payment()->with('promocode')->first();
            return view('admin.request.edit',compact('request','provider','promocode'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                $a=$UserRequest->save();
                return response()->json([
                        'request' => $request,
                        'error' => $a
                    ]);
            }else{
                $promocode = $UserRequest->payment()->with('promocode')->first();
                // $UserRequest->user->first_name = $request->first_name;
                
                if($request->provider_id!="Select Rider"){
                    $UserRequest->provider_id=$request->provider_id;
                    $UserRequest->provider->first_name = Provider::where('id',$request->provider_id)->pluck('first_name')[0];
                    // $UserRequest->provider->save();
                }
                // dd($request->provider_name);
                $UserRequest->status = $request->status;
                // $UserRequest->schedule_at = Carbon::parse($request->schedule_at);
                // $UserRequest->user->save();
                $UserRequest->save();


                return redirect()->route('admin.requests.pending')->with('flash_success', 'Order Updated Successfully');    
            }
        } 

        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }
        
        try {
            $Request = UserRequests::findOrFail($id);
            $Request->delete();
            return back()->with('flash_success','Request Deleted!');
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetdestroy($id)
    {
        try {
            $Request = UserRequests::findOrFail($id);
            $Request->delete();
            return back()->with('flash_success','Request Deleted!');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    //Admin can comment
    public function adminComment(Request $request, $req_id){
        try{
            // $comment = new Comment();

            // $comment->request_id = $req_id;
            // //$comment->booking_id = $booking_id;
            // $comment->authorised_type = "admin";
            // $comment->authorised_id = Auth::user()->id;
            // $comment->comments = $request->input('admin_comment');
            // $comment->is_read_admin = '0';

            $dept = Department::where('dept', '=', 'Admin')->pluck('id')->first();

            $comment = new Comment();
            $comment->request_id = $req_id;
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->comments = $request->input('comment');
            $comment->is_read_admin = '0';

            $comment->save();
            return back()->with('flash_success', 'Your message has send!!!');
        } catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Multiple Information to be Inbound. 
    public function all_inbound()
    {
        try {
            $inbound_orders = UserRequests::where('status','=','PENDING')->orWhere('status','=','ACCEPTED')->orWhere('status','=','PICKEDUP')->get();
            
            //dd($inbound_orders);
            return view('admin.request.inbound', compact('inbound_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    // This help to inbound the each information.
    public function inboundOrder(Request $request, $req_id){
        try {

            $inbound_order = UserRequests::findOrFail($req_id);
            
            if($request->ajax()){
                if ($inbound_order->status=="PENDING" || $inbound_order->status=="ACCEPTED" || $inbound_order->status=="PICKEDUP"){
                    $inbound_order->provider_id = null;
                    $inbound_order->status = "SORTCENTER";
                    $inbound_order->save();

                    //return ['success' => true, 'message' => 'New user created hihih !!'];
                    return response()->json([
                        'success' => true, 'message' => 'New user created hihih !!'
                    ]);
                }
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function tobe_return(){
        try {
            // $currentZone=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->first();
            $return_orders = UserRequests::where(function($query){
                $query->where('returned', '=', '0')
                        ->where('returned_to_hub', '=', '0');
            })->where(function($query){
                $query->where('status', '=', 'CANCELLED')
                        ->orWhere('status', '=', 'REJECTED');
            })->get();

            //dd($inbound_orders);
            return view('admin.request.return', compact('return_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function orderIn_hub(Request $request, $req_id){
        try {

            $order_checkin = UserRequests::findOrFail($req_id);
            
            if($request->ajax()){
                if ($order_checkin->status=="CANCELLED" || $order_checkin->status=="REJECTED"){
                    $order_checkin->returned_to_hub = '1';
                }
                $order_checkin->save();
            }

            //$a=$inbound_order->save();
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

    public function allorder_inhub(){
        try {
            // $currentZone=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->first();
            $all_inHub = UserRequests::where(function($query){
                $query->where('returned', '=', '0')
                        ->where('returned_to_hub', '=', '1');
            })->where(function($query){
                $query->where('status', '=', 'CANCELLED')
                        ->orWhere('status', '=', 'REJECTED');
            })->get();

            
            $totalRiders=Provider::select("id","first_name")->where("status","approved")->where('zone_id', '=', '1')->orderBy('first_name')->get();

            //dd($inbound_orders);
            return view('admin.request.inHub', compact('all_inHub', 'totalRiders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function return_Rider(Request $request, $req_id){
        try {
            $returnRider = UserRequests::findOrFail($req_id);

            // dd($request->provider);
            
            if($request->ajax()){
                if ($returnRider->status=="CANCELLED" || $returnRider->status=="REJECTED"){
                    $returnRider->return_rider = $request->return_rider;
                }
                $returnRider->save();
            }

            //$a=$inbound_order->save();
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
    
    public function return_completed(Request $request, $req_id){
        try {

            $rc_orders = UserRequests::findOrFail($req_id);
            
            if($request->ajax()){
                if ($rc_orders->status=="CANCELLED" || $rc_orders->status=="REJECTED"){
                    if ($rc_orders->return_rider){
                        $rc_orders->returned = '1';
                    }
                    else{
                        //$rc_orders->returned = '0';
                        confirm("No Rider Assign");
                    }
                }
                $rc_orders->save();
            }

            //$a=$inbound_order->save();
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

    public function change_cargo(Request $request, $req_id){
        try {
            $UserRequest = UserRequests::findOrFail($req_id);
            if($request->ajax()) {
                if(isset($request->cargo)){
                    $UserRequest->cargo = $request->cargo;
                    $UserRequest->fare = 85;
                    $UserRequest->amount_customer = $UserRequest->weight * 85;
                }
            }
            $a=$UserRequest->save();
            return response()->json([
                'request' => $request,
                'error' => $a
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    
    public function returned_order(){
        try {
            $return_orders = UserRequests::where(function($query){
                $query->where('returned', '=', '1')
                        ->where('returned_to_hub', '=', '1');
            })->where(function($query){
                $query->where('status', '=', 'CANCELLED')
                        ->orWhere('status', '=', 'REJECTED');
            })->get();

            //dd($inbound_orders);
            return view('admin.request.returnedOrder', compact('return_orders'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
}
