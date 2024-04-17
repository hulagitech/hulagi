<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Session;
use Setting;
use App\User;
//use DB;
use DateTime;
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
use App\Dispatcher;
use App\ServiceType;
use App\UserRequests;
use App\RequestFilter;
use App\TicketComment;
use App\Helpers\Helper;
use App\ProviderService;
use App\CorporateAccount;

use App\DispatchBulkList;
use App\DispatcherToZone;
use App\ZoneDispatchList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DispatcherController extends Controller
{

    /**
     * Dispatcher Panel.
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
		
		/*
		$ip 	=   \Request::getClientIp(true);
		$url	=	"http://www.geoplugin.net/json.gp?ip={$ip}";
		$this->ip_details =  $this->getDataByCurl($url);
		*/
	}


    /**
     * Create a new controller instance.
     *
     * @return void
     */

	public function index(Request $request)
    {	
		try {
			$dispatcher=Auth::user()->id;
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

				//we have to filter out the requests based on the zone in which dispatcher works

				//get the zones of current dispatcher
				$zones=DispatcherToZone::where('dispatcher_id',$dispatcher)->pluck('zone_id')->toArray();
				//create new collection and filter only those which are in the zone
				$dispatcherRequests=$requests->get();
				$dispatcherRequests=$dispatcherRequests->filter(function($req) use($zones){
					return (in_array($req->zone1,$zones) || in_array($req->zone2,$zones));
				});
				//note that we could get the requests directly using this method in dispatcherRequests but in order
				//to paginate, we are using whereIn
				$requests=$requests->whereIn('id',$dispatcherRequests->pluck('id')->toArray())->paginate(100);
				$requests->appends([
					'search'=>$request->search,
					'to_date'=>$request->to_date,
					'from_date'=>$request->from_date,
					'searchField'=>$request->searchField,
					'status'=>$request->status
					]);
				//add logs for rider remarks to be seen in UI
                foreach($requests as $request){
                    $request->log=RiderLog::where('request_id',$request->id)->first();
                }
				$allRiders=Provider::select("id","first_name",'zone_id')->where("status","approved")->orderBy('first_name')->get();
				$totalRiders=$allRiders->filter(function($rider) use($zones){
					return in_array($rider->zone_id,$zones);
				});
                $dates=true;
                $current['date']=$request->date;

				//To Count Comment in each Order
				foreach($requests as $request){
					// $orderComment->ur = UserRequests::where('id','=',$orderComment->request_id)->where('comment_status','=','0')->first();
					// $orderComment->user = User::where('id','=',$orderComment->ur->user_id)->first();
					$request->noComment = Comment::where('request_id', $request->id)->where('is_read_dispatcher','=',"1")->count();
				}
                return view('dispatcher.request.index', compact(['requests','totalRiders', 'dates']));
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
                return view('dispatcher.request.index', compact(['requests','totalRiders', 'dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}


	public function dispatchListIndex(Request $request){
		$services  	= 	ServiceType::all();
		$all_zones	=	$this->getZonesWithProvider();
		$companies  =	DB::table('fleets')->get();
		$ip_details =	$this->ip_details;

		$currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
		if(isset($request->dispatcher)){
			$selectedZones=DispatcherToZone::where('dispatcher_id',$request->dispatcher)->pluck('zone_id')->toArray();
			$requests=UserRequests::where('status','SORTCENTER')
								->whereIn('zone1',$currentZones)
								->whereIn('zone2',$selectedZones)
								->get();
			$searched_dispatcher=Dispatcher::findOrFail($request->dispatcher);
		}
		else{
			$requests='';
			$searched_dispatcher=null;
		}
		// $zones= Zones::whereNotIn('id',$currentZones)->get();
		$dispatchers= Dispatcher::where('id',"!=",Auth::user()->id)->get();
        return view('dispatcher.dispatchList.index', compact('requests','services','all_zones','companies','ip_details','dispatchers','searched_dispatcher'));
	}
	public function dispatchReturnIndex(Request $request){
		
		$services  	= 	ServiceType::all();
		$all_zones	=	$this->getZonesWithProvider();
		$companies  =	DB::table('fleets')->get();
		$ip_details =	$this->ip_details;
		$currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
		$requests=UserRequests::where('status','REJECTED')->where('returned_to_hub',0)
								->where('returned',0)
								->whereIn('zone2',$currentZones)
								->get();
	
		// $zones= Zones::whereNotIn('id',$currentZones)->get();
		$dispatchers= Dispatcher::where('id',"!=",Auth::user()->id)->get();
        return view('dispatcher.dispatchList.return', compact('requests','services','all_zones','companies','ip_details','dispatchers',));
	}
	public function DispatchReturned(Request $request){
		try{
			$request->flash();
			DB::beginTransaction();
			if(isset($request->btn1) && $request->btn1==1)
			{
				$this->validate($request,[
					'data' => 'required'
				]);
	
				// dd("Hello! Dispatcher ---> ".$request->data);
				$data=explode(",",$request->data);
	
				//first create a bulk dispatch
				$bulk=new DispatchBulkList;
				$bulk->Returned=1;
				$bulk->save();
	
				//set all to delivering and save to a batch
				foreach($data as $d){
					$req=UserRequests::where('booking_id',$d)->where('status','REJECTED')->where('returned_to_hub',0)
					->where('returned',0)->select('id')->first();
					if($req){
						$i=$req->id;
						$zones=ZoneDispatchList::where('request_id',$i)->first();
						if($zones){
							$zones->dispatch_id=$bulk->id;
							$zones->save();
						}
						else{
							$dispatch=new ZoneDispatchList;
							$dispatch->request_id=$i;
							$dispatch->dispatch_id=$bulk->id;
							$dispatch->save();
						}   
						$userRequest=UserRequests::findOrFail($i);
						$userRequest->status="DISPATCHED";
						$userRequest->save();
					}	
					else{
						throw new Exception("One or more orders not found in Return");
					}
				}
				//bulk zone1 is the dispatcher's id
				$bulk->zone1_id=Auth::user()->id;
				//bulk zone2 is the dispatched zone's dispatcher's id
				$bulk->zone2_id=$request->dispatcher;	
				$bulk->save();
				DB::commit();
				return back()->with('message','Return Created with name: '.$bulk->zone2->name."#".$bulk->id);
			}
			elseif(isset($request->btn2) && $request->btn2==1)
			{
				$this->validate($request,[
					'data' => 'required'
				]);
	
				//dd("Hello Sooraz, Draft --> ".$request->data);
				$data=explode(",",$request->data);
	
				//first create a bulk dispatch
				$bulk=new DispatchBulkList;
				$bulk->draft = "1";
				$bulk->save();
	
				//set all to delivering and save to a batch
				foreach($data as $d){
					$req=UserRequests::where('booking_id',$d)->where('status','SORTCENTER')->select('id')->first();
					if($req){
						$i=$req->id;
						$zones=ZoneDispatchList::where('request_id',$i)->first();
						if($zones){
							$zones->dispatch_id=$bulk->id;
							$zones->save();
						}
						else{
							$dispatch=new ZoneDispatchList;
							$dispatch->request_id=$i;
							$dispatch->dispatch_id=$bulk->id;
							$dispatch->save();
						}
					}
					else{
						throw new Exception("One or more orders not found in sortcenter");
					}	
				}	
				//bulk zone1 is the dispatcher's id
				$bulk->zone1_id=Auth::user()->id;
				//bulk zone2 is the dispatched zone's dispatcher's id
				$bulk->zone2_id=$request->dispatcher;	
				$bulk->save();
				DB::commit();
				$request->flush();
				return back()->with('message','Save to Draft with name: '.$bulk->zone2->name."#".$bulk->id);
			}else{
				return back()->with('flash_error', 'Something went wrong!!');
			}
			
        }
        catch(Exception $e){
			DB::rollBack();
            return back()->withErrors([$e->getMessage()]);
        }
	}
	public function newDispatch(Request $request){
		try{
			$request->flash();
			DB::beginTransaction();
			if(isset($request->btn1) && $request->btn1==1)
			{
				$this->validate($request,[
					'data' => 'required'
				]);
	
				// dd("Hello! Dispatcher ---> ".$request->data);
				$data=explode(",",$request->data);
	
				//first create a bulk dispatch
				$bulk=new DispatchBulkList;
				$bulk->save();
	
				//set all to delivering and save to a batch
				foreach($data as $d){
					$req=UserRequests::where('booking_id',$d)->first();
					if($req->status=="SORTCENTER"){
						$i=$req->id;
						$zones=ZoneDispatchList::where('request_id',$i)->first();
						if($zones){
							$zones->dispatch_id=$bulk->id;
							$zones->save();
						}
						else{
							$dispatch=new ZoneDispatchList;
							$dispatch->request_id=$i;
							$dispatch->dispatch_id=$bulk->id;
							$dispatch->save();
						}   
						$userRequest=UserRequests::findOrFail($i);
						$userRequest->status="DISPATCHED";
						$userRequest->save();
					}	
					else{
						throw new Exception($req->booking_id." orders not found in sortcenter");
					}
				}
				//bulk zone1 is the dispatcher's id
				$bulk->zone1_id=Auth::user()->id;
				//bulk zone2 is the dispatched zone's dispatcher's id
				$bulk->zone2_id=$request->dispatcher;	
				$bulk->save();
				DB::commit();
				$request->flush();
				return back()->with('message','Dispatch Created with name: '.$bulk->zone2->name."#".$bulk->id);
			}
			elseif(isset($request->btn2) && $request->btn2==1)
			{
				$this->validate($request,[
					'data' => 'required'
				]);
	
				//dd("Hello Sooraz, Draft --> ".$request->data);
				$data=explode(",",$request->data);
	
				//first create a bulk dispatch
				$bulk=new DispatchBulkList;
				$bulk->draft = "1";
				$bulk->save();
	
				//set all to delivering and save to a batch
				foreach($data as $d){
					$req=UserRequests::where('booking_id',$d)->first();
					if($req->status=="SORTCENTER"){
						$i=$req->id;
						$zones=ZoneDispatchList::where('request_id',$i)->first();
						if($zones){
							$zones->dispatch_id=$bulk->id;
							$zones->save();
						}
						else{
							$dispatch=new ZoneDispatchList;
							$dispatch->request_id=$i;
							$dispatch->dispatch_id=$bulk->id;
							$dispatch->save();
						}
					}
					else{
						throw new Exception($req->booking_id." orders not found in sortcenter");
					}	
				}	
				//bulk zone1 is the dispatcher's id
				$bulk->zone1_id=Auth::user()->id;
				//bulk zone2 is the dispatched zone's dispatcher's id
				$bulk->zone2_id=$request->dispatcher;	
				$bulk->save();
				DB::commit();
				$request->flush();
				return back()->with('message','Save to Draft with name: '.$bulk->zone2->name."#".$bulk->id);
			}else{
				return back()->with('flash_error', 'Something went wrong!!');
			}
			
        }
        catch(Exception $e){
			DB::rollBack();
            return back()->withInput()->withErrors([$e->getMessage()]);
        }
	}

	public function viewDispatch(){
		try {
			
			$requests=DispatchBulkList::where('received',false)->where('incomplete_received',false)->where('draft','=','0')->where('zone1_id',Auth::user()->id)->withCount('lists')->get();
            return view('dispatcher.dispatchList.dispatchList', compact(['requests']));
            // return view('dispatcher.dispatchList.dispatchList', compact(['requests','services','all_zones','companies','ip_details']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
	public function viewReturnDispatch(){
		try {
			
			$requests=DispatchBulkList::where('received',false)->where('incomplete_received',false)->where('draft','=','0')->where('Returned','1')->where('zone1_id',Auth::user()->id)->withCount('lists')->get();
            return view('dispatcher.dispatchList.returndispatch', compact(['requests']));
            // return view('dispatcher.dispatchList.dispatchList', compact(['requests','services','all_zones','companies','ip_details']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function view_completeReached(){
		try {

			$requests = DispatchBulkList::where('received',true)->where('received_all',true)->where('incomplete_received',false)->where('draft','=','0')->where('zone1_id',Auth::user()->id)->withCount('lists')->get();

            return view('dispatcher.dispatchList.completeReached', compact(['requests']));
        }   catch (Exception $e) {
			dd($e->getMessage());
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function view_incompleteReached(){
		try {
			
			$requests=DispatchBulkList::where('incomplete_received', true)->where('zone1_id',Auth::user()->id)->withCount('lists')->get();

            return view('dispatcher.dispatchList.incompleteReached', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function viewDraft(){
		try {
			
			$requests=DispatchBulkList::where('received',false)->where('draft','=','1')->where('zone1_id',Auth::user()->id)->withCount('lists')->get();
            return view('dispatcher.dispatchList.draft', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function edit_Draft($id){
		try {

			//check if user has access
			$bulk=DispatchBulkList::findOrFail($id);

			$currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
			if(isset($bulk->zone2_id)){
				$selectedZones=DispatcherToZone::where('dispatcher_id',$bulk->zone2_id)->pluck('zone_id')->toArray();
				$requests=UserRequests::where('status','SORTCENTER')
									->whereIn('zone1',$currentZones)
									->whereIn('zone2',$selectedZones)
									->get();
				$searched_dispatcher=Dispatcher::findOrFail($bulk->zone2_id);
			}
			else{
				$requests='';
				$searched_dispatcher=null;
			}
			$dispatchers= Dispatcher::where('id',"!=",Auth::user()->id)->get();


			if(Auth::user()->id==$bulk->zone1_id || Auth::user()->id==$bulk->zone2_id){
				$zone_d_lists=ZoneDispatchList::where('dispatch_id',$id)->get();

            	return view('dispatcher.dispatchList.editDraft', compact(['zone_d_lists','requests', 'dispatchers','searched_dispatcher']));
            	// return view('dispatcher.dispatchList.editDraft', compact(['zone_d_lists','requests','services','all_zones','companies','ip_details','zones','searched_zone']));
			}
			else{
				return back()->with('flash_error','You cant access this data!');
			}
        }catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function my_Draft(Request $request, $id){
		try{
			DB::beginTransaction();
			if(isset($request->btn1) && $request->btn1==1)
			{
				$this->validate($request,[
					'data' => 'required'
				]);
	
				//dd("Hello! Dispatcher ---> ".$request->data);
				$data=explode(",",$request->data);
	
				//first create a bulk dispatch
				$bulk = DispatchBulkList::findOrFail($id);
				$bulk->draft = "0";
				$bulk->save();
	
				//set all to delivering and save to a batch
				foreach($data as $d){
					$req=UserRequests::where('booking_id',$d)->where('status','SORTCENTER')->select('id')->first();
					if($req){
						$i=$req->id;
						$zones=ZoneDispatchList::where('request_id',$i)->first();
						if($zones){
							$zones->dispatch_id=$bulk->id;
							$zones->save();
						}
						else{
							$dispatch=new ZoneDispatchList;
							$dispatch->request_id=$i;
							$dispatch->dispatch_id=$bulk->id;
							$dispatch->save();
						}   
						$userRequest=UserRequests::findOrFail($i);
						$userRequest->status="DISPATCHED";
						$userRequest->save();
					}	
					else{
						throw new Exception("One or more orders not found in sortcenter");
					}
				}
				
				$req=UserRequests::whereIn('booking_id',$data)->pluck('id')->toArray();
				ZoneDispatchList::whereNotIn('request_id',$req)->where('dispatch_id',$bulk->id)->delete();
				//bulk zone1 is the dispatcher's id
				$bulk->zone1_id=Auth::user()->id;
				//bulk zone2 is the dispatched id
				$bulk->zone2_id=$request->dispatcher;
				$bulk->save();
				DB::commit();
				return redirect()->route('dispatcher.dispatchList.myDispatch')->with('message','Dispatch Created with name: '.$bulk->zone2->zone_name."#".$bulk->id);
			}
			elseif(isset($request->btn2) && $request->btn2==1)
			{
				$this->validate($request,[
					'data' => 'required'
				]);
	
				//dd("Hello Sooraz, Draft --> ".$request->data);
				$data=explode(",",$request->data);
	
				//first create a bulk dispatch
				$bulk = DispatchBulkList::findOrFail($id);
				$bulk->draft = "1";
				$bulk->save();
	
				//set all to delivering and save to a batch
				foreach($data as $d){
					$req=UserRequests::where('booking_id',$d)->where('status','SORTCENTER')->select('id')->first();
					if($req){
						$i=$req->id;

						$draftOrder = ZoneDispatchList::where('request_id',$i)->first();
						if(!isset($draftOrder)){
							$zones=ZoneDispatchList::where('request_id',$i)->first();
							if($zones){
								$zones->dispatch_id=$bulk->id;
								$zones->save();
							}
							else{
								$dispatch=new ZoneDispatchList;
								$dispatch->request_id=$i;
								$dispatch->dispatch_id=$bulk->id;
								$dispatch->save();
							}
						}
					}	
					else{
						throw new Exception("One or more orders not found in sortcenter");
					}
				}	
				$req=UserRequests::whereIn('booking_id',$data)->pluck('id')->toArray();
				ZoneDispatchList::whereNotIn('request_id',$req)->where('dispatch_id',$bulk->id)->delete();
				//bulk zone1 is the dispatcher's id
				$bulk->zone1_id=Auth::user()->id;
				//bulk zone2 is the dispatched id
				$bulk->zone2_id=$request->dispatcher;
				$bulk->save();
				DB::commit();
				return back()->with('message','Save to Draft with name: '.$bulk->zone2->name."#".$bulk->id);
			}else{
				return back()->with('flash_error', 'Something went wrong!!');
			}
			
        }
        catch(Exception $e){
			DB::rollBack();
            return back()->withErrors([$e->getMessage()]);
        }
	}


	public function updateDispatch(Request $request)
    {
        try{
            $this->validate($request,[
                'id' => 'required'
            ]);
            $id=$request->id;
            $bulk=DispatchBulkList::findOrFail($id);
            $bulk->remarks=$request->remarks;

            if ($request->hasFile('file')) {
                $this->validate($request,[
                    'file' => 'mimes:jpeg,bmp,png,pdf' // Only allow .jpg, .bmp and .png file types.
                ]);
    
                // Save the file locally in the storage/public/ folder under a new folder named /product
                $request->file->store('dispatch', 'public');
    
                // Store the record, using the new file hashname which will be it's new filename identity.
                $bulk->file_path=$request->file->hashName();
            }
            $bulk->save();
            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
	}
	
	public function showDetailDispatch($id)
    {
        try {

			//check if user has access
			$bulk=DispatchBulkList::findOrFail($id);

			if(Auth::user()->id==$bulk->zone1_id || Auth::user()->id==$bulk->zone2_id){
				$requests=ZoneDispatchList::where('dispatch_id',$id)->get();
            	return view('dispatcher.dispatchList.detailDispatch', compact(['requests','id']));
			}
			else{
				return back()->with('flash_error','You cant access this data!');
			}
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
	
	public function pendingDispatch()
    {
        try {
			$requests=DispatchBulkList::where('received_all','=', '0')
					->where('incomplete_received', '=', '0')
					->where('draft', '=', '0')
					->where('Returned','0')
					->where('zone2_id',Auth::user()->id)
					->withCount(['lists','lists as received'=> function($query){
						$query->where('received', '=', '1');
					}])
					->get();

            return view('dispatcher.dispatchList.pending', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
	public function returnDispatch()
    {
        try {
			$requests=DispatchBulkList::where('received_all','=', '0')
					->where('incomplete_received', '=', '0')
					->where('draft', '=', '0')
					->where('Returned','1')
					->where('zone2_id',Auth::user()->id)
					->withCount(['lists','lists as received'=> function($query){
						$query->where('received', '=', '1');
					}])
					->get();

            return view('dispatcher.dispatchList.rejectedpending', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function receivePending_Dispatch(Request $request, $id)
    {
        try{
            $this->validate($request,[
                'received' => 'required'
            ]);
            $bulk=DispatchBulkList::findOrFail($id);
			$bulk->received=1;
			$bulk->received_all=1;
			$bulk->save();

			$rows = ZoneDispatchList::where("dispatch_id",$bulk->id)->get();
			foreach($rows as $row){
				$row->received = 1;
				$row->save();

				$request = UserRequests::where('id', $row->request_id)->first();
				$request->status = "SORTCENTER";
				$request->save();
			}

            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
	}
	public function receivePending_ReturnDispatch(Request $request, $id)
    {
        try{
            $this->validate($request,[
                'received' => 'required'
            ]);
            $bulk=DispatchBulkList::findOrFail($id);
			$bulk->received=1;
			$bulk->received_all=1;
			$bulk->save();

			$rows = ZoneDispatchList::where("dispatch_id",$bulk->id)->get();
			foreach($rows as $row){
				$row->received = 1;
				$row->save();

				$request = UserRequests::where('id', $row->request_id)->first();
				$request->status = "REJECTED";
				$request->save();
			}

            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
	}

	public function incompleteCheckReceive(Request $request, $id)
    {
        try{
            $this->validate($request,[
                'incomplete' => 'required'
            ]);
            $bulk=DispatchBulkList::findOrFail($id);
			//$bulk->received=$request->received?"1":"0";
			$bulk->incomplete_received = 1;
			$bulk->save();


            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
	}

	public function showNewDetailDispatch($id)
    {
        try {
			
			//check if user has access
			$bulk=DispatchBulkList::findOrFail($id);
			
			if($bulk->zone1_id==Auth::user()->id || $bulk->zone2_id==Auth::user()->id){
				$requests=ZoneDispatchList::where('dispatch_id',$id)->get();

            	return view('dispatcher.dispatchList.detailReceived', compact(['requests']));
			}
			else{
				return back()->with('flash_error','You cant access this data!');
			}
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
	public function showReturnDispatch($id)
    {
        try {
			
			//check if user has access
			$bulk=DispatchBulkList::findOrFail($id);
			
			if($bulk->zone1_id==Auth::user()->id || $bulk->zone2_id==Auth::user()->id){
				$requests=ZoneDispatchList::where('dispatch_id',$id)->get();

            	return view('dispatcher.dispatchList.ReturndetailReceived', compact(['requests']));
			}
			else{
				return back()->with('flash_error','You cant access this data!');
			}
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function show_eachCompleteReceived($id)
    {
        try {

			$bulk=DispatchBulkList::findOrFail($id);

			if(Auth::user()->id==$bulk->zone1_id || Auth::user()->id==$bulk->zone2_id){
				$requests=ZoneDispatchList::where('dispatch_id',$id)->where('received', '=', '1')->get();
            	return view('dispatcher.dispatchList.detailCompleteReceived', compact(['requests']));
			}
			else{
				return back()->with('flash_error','You cant access this data!');
			}
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function eachPendingReceive(Request $request, $id)
    {
		// return $id;
        try{
            $this->validate($request,[
                'received' => 'required'
			]);
			
			$row = ZoneDispatchList::findOrFail($id);
			// $row->received = $request->received?"0":"1";
			$row->received = 1;
			if($row->request_id){
				$request = UserRequests::where('id', $row->request_id)->first();
				$request->status = "SORTCENTER";
				$log=new OrderLog();
				$log->create([
					'request_id'=>$request->id,
					'type' => "status",
					'description' => 'Your order has been received from dispatcher'
				]);
				$request->save();
			}

			$row->save();
			
			
			if($row->dispatch_id){
				$bulk=DispatchBulkList::where('id', $row->dispatch_id)->first();
				$bulk->received = 1;
				// $bulk->save();

				//count of all requests in the bulk
				$allDispatchList = ZoneDispatchList::where('dispatch_id', '=', $bulk->id)->count();
				//count of all received request in the bulk
				$receivedDispatchList = ZoneDispatchList::where('dispatch_id', '=', $bulk->id)->where('received','1')->count();
				if($allDispatchList==$receivedDispatchList){
					$bulk->received_all = 1;
					$bulk->incomplete_received=0;
				}
				else{
					$bulk->received_all = 0;
					$bulk->incomplete_received=1;
				}
				$bulk->save();
			}

            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
	}

	public function eachPendingReturnedReceive(Request $request, $id)
    {
		// return $id;
        try{
            $this->validate($request,[
                'received' => 'required'
			]);
			
			$row = ZoneDispatchList::findOrFail($id);
			// $row->received = $request->received?"0":"1";
			$row->received = 1;
			if($row->request_id){
				$request = UserRequests::where('id', $row->request_id)->first();
				$request->status = "REJECTED";
				$log=new OrderLog();
				$log->create([
					'request_id'=>$request->id,
					'type' => "status",
					'description' => 'Your rejected order has been received from dispatcher'
				]);
				$request->save();
			}

			$row->save();
			
			
			if($row->dispatch_id){
				$bulk=DispatchBulkList::where('id', $row->dispatch_id)->first();
				$bulk->received = 1;
				// $bulk->save();

				//count of all requests in the bulk
				$allDispatchList = ZoneDispatchList::where('dispatch_id', '=', $bulk->id)->count();
				//count of all received request in the bulk
				$receivedDispatchList = ZoneDispatchList::where('dispatch_id', '=', $bulk->id)->where('received','1')->count();
				if($allDispatchList==$receivedDispatchList){
					$bulk->received_all = 1;
					$bulk->incomplete_received=0;
				}
				else{
					$bulk->received_all = 0;
					$bulk->incomplete_received=1;
				}
				$bulk->save();
			}

            return response()->json(['success'=>true,'showError'=>true]);
        }
        catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
	}
  
    public function new_booking( ){		
        $services  = ServiceType::all();    
		$ip_details =	$this->ip_details;
		$user_id = Auth::user()->id;
		$corporates = CorporateAccount::all();
		$all_zones		=	$this->getZonesWithProvider();
		$payment_methods = DB::table('payment_methods')->get();
	
		/*
        if(Auth::guard('admin')->user()){
            $data= "";
            return view('admin.dispatcher',compact('data'));
			
        }elseif(Auth::guard('dispatcher')->user()){
            return view('dispatcher.new_booking', compact('services', 'ip_details','user_id','corporates' , 'all_zones', 'payment_methods' ));
		}
		*/
		return view('dispatcher.new_booking', compact('services', 'ip_details','user_id','corporates' , 'all_zones', 'payment_methods' ));
    }
	

    public function indexcreate($dispatch="")
    {
        if(Auth::guard('admin')->user()){
            $data= "dispatch-map";
            return view('admin.dispatcher_create',compact('data'));
        }elseif(Auth::guard('dispatcher')->user()){
            return view('dispatcher.dispatcher');
        }
    }

    /**
     * Display a listing of the active trips in the application.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancel_ride(Request $request){
        $request->type='dispatcher';
		$request->dispatcher_id = Auth::user()->id; 
		
		$input = [
			'dispatcher_id' => Auth::user()->id,
			'type'			=> 'dispatcher'
		];
		
		array_merge( $request->all(), $input );
		
		
		if( $request->cancel_status == 'cancel' ||  $request->cancel_status == 'dead' ) {
			return $this->UserAPI->cancel_request($request);
		}
		
		if( $request->cancel_status == 'reassign' ||  $request->cancel_status == 'assign' ) {
			
			return $this->assign( $request );
		}
		
    
	}
	
	public function assignCompany(Request $request) {
		  $this->validate($request, [
			'trip_id'		=> 'required|numeric',
			'cab_company_id'	=> 'required|numeric',
		]);
	
		try {
			
			$json = array();
			$Request 	= UserRequests::where('id', $request->trip_id)->first();
			
			if( !$Request ) {
				throw new Exception('No trip Found!');
			}
			
			$company  	= DB::table('fleets')->where('id', $request->cab_company_id)->first();
			if( ! $company ) {
				throw new Exception('choosen company not found!');
			}
			
			$Request->status = 'COMPLETED';
			$Request->cab_company_id	=	$company->id;
			$Request->paid				=	1;
			
			if( $request->input('special_note') ) {
				$Request->company_note	=	trim ($request->special_note );
				
				(new SendPushNotification)->sendDriverDetailToUser($Request->user_id , $Request->company_note ); 
			}
			
			$Request->save();
			
			
			Log::useFiles(storage_path().'/logs/dispatcher.log');
			Log::info( $Request->booking_id.' id is assigned to co-partner by dispatcher panel!');
			
			$json['trip'] = $Request;
			return response()->json($json);
		
		} catch (Exception $e) {
			
			return response()->json(['error' => $e->getMessage()]);
		} 
    
	}

	
	
	public function update_trip(Request $request ) {
		
		$this->validate($request, [
			'first_name'	=>	'required',
			'special_note'	=>	'required',
			's_address'		=>	'required',
			'd_address'		=>	'required',
			'email'			=>	'required',
			'mobile'		=>	'required',
			'request_id'	=>	'required|numeric',
			's_latitude'	=>	'required|numeric',
			's_longitude'	=>	'required|numeric',
			'd_latitude'	=>	'required|numeric',
			'd_longitude'	=>	'required|numeric',
		]);
		
		$json = array('status' => false );
		
		try {
			
			$UserRequest = UserRequests::find($request->request_id);
			
			if( ! $UserRequest ) {
				throw new Exception('Unauthorized Request!');
			}
			
			if( $UserRequest->status == 'ACCEPTED' ||  $UserRequest->status == 'STARTED' ||  $UserRequest->status == 'ARRIVED'  || $UserRequest->status == 'PICKEDUP' || $UserRequest->status == 'PENDING' ) {
				
				$User = User::find( $UserRequest->user_id );
				
				if( ! $User ) {
					throw new Exception('User not found!');
				}
				
				if( $User->email != $request->email  ) {
					if ( User::where('email', $request->email)->first() ) {
						throw new Exception('User email already registered!');
					}
				}
				
				if( $User->mobile != $request->mobile  ) {
					if ( User::where('mobile', $request->mobile)->first() ) {
						throw new Exception('User Mobile already registered!');
					}
				}
				
				
				//Update User			
				$User->first_name 	= $request->first_name;
				//$User->last_name 	= $request->last_name;
				$User->email 		= $request->email;
				$User->mobile 		= $request->mobile;
				//$User->password 	= bcrypt($request->mobile);
				$User->save();
				
				
				$R_coordiantes =  [ $UserRequest->s_latitude,  $UserRequest->s_longitude, $UserRequest->d_latitude, $UserRequest->d_longitude ];
				$F_coordinates =  [ $request->s_latitude, $request->s_longitude, $request->d_latitude, $request->d_longitude ];
				//Udate Request Info
				
				$flag = false;
				
				if( $R_coordiantes &&  $F_coordinates ) {
					foreach( $F_coordinates as $coord ) {
						if( in_array( $coord, $R_coordiantes )  === FALSE ) {
							$flag = true;
						}
					}
				}
				
				if( $flag ) {
					
					$fare = Helper::getEstimatedFare( $request->all() );			
					if( isset($fare['error']) ) {
						throw new Exception( $fare['error'] );
					}
					
					if( $fare ) {
						$UserRequest->s_latitude	=	$request->s_latitude;
						$UserRequest->s_longitude 	=	$request->s_longitude;
						$UserRequest->d_latitude 	=	$request->d_latitude;
						$UserRequest->d_longitude 	=	$request->d_longitude;
						$UserRequest->d_address 	=	$request->d_address;
						$UserRequest->s_address 	=	$request->s_address;
						$UserRequest->estimated_fare =	$fare['estimated_fare'];
						$UserRequest->distance 		=	$fare['distance'];
					}
				
				}
				
				$UserRequest->special_note 	=	$request->special_note;
				$UserRequest->save();
				$json['status'] = true;
				
				Log::useFiles(storage_path().'/logs/dispatcher.log');
				Log::info( $UserRequest->booking_id.' id updated by dispatcher panel');
			
			    return response()->json( $json );
			}
	
		}   catch (Exception $e) {
			
			return response()->json(['error' => $e->getMessage()]);
		} 
		
		
	}
	

    public function trips(Request $request)
    {

		$post = $request->all(); 
        $user_id = Auth::user()->id;
		
        if(isset($post['filter']) && $post['filter']!='' ){

            $filter = $post['filter']; 
            
			switch ($filter) {

				case 'dispatch-new':
					$status = ['PENDING'];
					break;
				case 'dispatch-dispatching':
					$status = ['PICKEDUP', 'ACCEPTED' ,'STARTED', 'ARRIVED', 'DROPPED' ];
					break;
				 case 'dispatch-cancelled':
					$status = ['CANCELLED'];
					break;
				 case 'dispatch-completed':
					$status = ['COMPLETED'];
					break;
				case 'dispatch-scheduled':
					$status = ['SCHEDULED'];
					break;
				case 'dispatcher-dead':
					$status = ['DEAD'];
					break;
				default:
					$status = ['PENDING']; 
					break;
        }          
		    $Trips = UserRequests::whereIn('status',$status)->with('user','provider','payment')->orderBy('id','desc')->get(); 
        } else {
            $Trips = UserRequests::with('user','provider','payment')->orderBy('id','desc')->get();
        }   
        return $Trips;
    }

    /**
     * Display a listing of the users in the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $Users = new User;

        if($request->has('mobile')) {
            $Users->where('mobile', 'like', $request->mobile."%");
        }

        if($request->has('first_name')) {
            $Users->where('first_name', 'like', $request->first_name."%");
        }

        if($request->has('last_name')) {
            $Users->where('last_name', 'like', $request->last_name."%");
        }

        if($request->has('email')) {
            $Users->where('email', 'like', $request->email."%");
        }

        return $Users->paginate(10);
    }



     public function zones(Request $request)
    {
        $Zones = new Zones;

        if($request->has('name')) {
            $Zones->where('name', 'like', $request->name."%");
        }

        if($request->has('county')) {
            $Zones->where('county', 'like', $request->county."%");
        }

        if($request->has('province')) {
            $Zones->where('province', 'like', $request->province."%");
        }

        if($request->has('postcode_area')) {
            $Zones->where('postcode_area', 'like', $request->postcode_area."%");
        }

        return $Zones->paginate(10);
    }

    /**
     * Display a listing of the active trips in the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function providers(Request $request)
    {
        $Providers = new Provider;
		
		if( $request->has('latitude') && $request->has('longitude') && $request->has('service_type_id') ) {
		
			$Providers = Helper::availableProviders($request->service_type_id , $request->latitude , $request->longitude );
			
		}

        return $Providers;
    }

	
	public function providerList(Request $request) {
        $Providers = new Provider;

        if($request->has('s_latitude') && $request->has('s_longitude')) {
			$point[0]		=	$request->input('s_latitude'); 
			$point[1]		=	$request->input('s_longitude'); 
			$service_type	=	$request->service_type;
			$zone_id 		=	Helper::getLatlngZone_id( $point );
			if ( $zone_id ) {				
				$Providers = $this->getAvailableProviders( (int)$service_type, (int)$zone_id );
			}
	
        } else { 
		
			$Providers = $this->getAvailableProviders();
			
		}

        return $Providers;
    }
    /**
     * Create manual request.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request )
    {
		
		$this->validate($request, [
                'provider_id' => 'required|numeric',
                'request_id' => 'required|numeric',
            ]);
		
        try {
			
			$Request 	= UserRequests::findOrFail( $request->request_id );
            $Provider 	= Provider::findOrFail( $request->provider_id );
			
			$Providers	=	Helper::availableProviders($Request->service_type_id, $Request->s_latitude , $Request->s_longitude );
			
			$old_request = $Request;
			
			if( $request->cancel_status == 'assign' ) {
				
				if( $Request->status != 'SCHEDULED' ) {
					$Request->status = 'PENDING';
				}
				
				$Request->provider_id 			=	0;
				$Request->assigned_at 			=	Carbon::now();
				$Request->cancel_reason			=	$request->cancel_reason;
				$Request->current_provider_id 	=	$Provider->id;
				$Request->save();	
				
				
				Log::useFiles(storage_path().'/logs/dispatcher.log');
				Log::info( $Request->booking_id.' manually assigned to driver!' );
				
				
			} else if( $request->cancel_status == 'reassign' ) {
			
				$UserRequest 					= new UserRequests;
				$UserRequest->booking_id 		= Helper::generate_booking_id();
				$UserRequest->user_id 			= $Request->user_id;
				$UserRequest->dispatcher_id 	= ( isset($request->dispatcher_id) && !empty($request->dispatcher_id) ) ? $request->dispatcher_id : 0; 
				$UserRequest->req_type 			= $Request->req_type;
				$UserRequest->current_provider_id = $Provider->id; 			
				$UserRequest->service_type_id 	=	$Request->service_type_id;
				$UserRequest->payment_mode		=	$Request->payment_mode;
				$UserRequest->status 			=	( $Request->status  != 'SCHEDULED' ) ? 'PENDING' : 'SCHEDULED'; 
				$UserRequest->s_address 		=	$Request->s_address;
				$UserRequest->corporate_id		=	$Request->corporate_id;
				$UserRequest->amount_customer 	=	$Request->amount_customer;				
				$UserRequest->estimated_fare 	=	$Request->estimated_fare;
				$UserRequest->cancel_reason 	=	$request->cancel_reason;
				$UserRequest->special_note 		=	$request->special_note;
				$UserRequest->s_latitude 		=	$Request->s_latitude;
				$UserRequest->s_longitude 		=	$Request->s_longitude;

				$UserRequest->d_address 		=	$Request->d_address;
				$UserRequest->d_latitude 		=	$Request->d_latitude;
				$UserRequest->d_longitude 		=	$Request->d_longitude;
				$UserRequest->route_key 		=	$Request->route_key;
				$UserRequest->distance 			=	$Request->distance;
				$UserRequest->assigned_at 		=	Carbon::now();
				$UserRequest->use_wallet 		=	$Request->use_wallet;
				$UserRequest->req_zone_id		=	$Request->req_zone_id;
				$UserRequest->surge				=	$Request->surge;
				$UserRequest->payment_method_id =	$Request->payment_method_id;
				$UserRequest->schedule_at		=	$Request->schedule_at;
				
				$UserRequest->save();	
				$Request = $UserRequest;
				
				DB::table('user_requests')->where('id', $old_request->id )->delete();
				
				Log::useFiles(storage_path().'/logs/dispatcher.log');
				Log::info( $UserRequest->booking_id.' re-assign to  new driver!' );
		
			}
			
    
			$ids = DB::table('request_filters')->where('request_id', $old_request->id )->get()->pluck('id')->toArray();	
			DB::table('request_filters')->whereIn('id', $ids )->delete();
			ProviderService::where('provider_id',$old_request->provider_id)->update(['status' =>'active']);
		
			
			if( $Request->current_provider_id ) {
				if( $Request->status != 'SCHEDULED' ) {
					if( $Providers->count() ) {
						$inserted_data = [];
						foreach ($Providers as $Pr) {
							$inserted_data[] = [
								'request_id'	=> $Request->id,
								'provider_id'	=> $Pr->id
							];
						}
						
						if( $inserted_data ) {
							DB::table('request_filters')->insert( $inserted_data );
						}
						
					} else {
						
						$Filter = new RequestFilter;
						$Filter->request_id = $Request->id;
						$Filter->provider_id = $Provider->id; 
						$Filter->save();
						
					}
				
					(new SendPushNotification)->IncomingRequest($Request->current_provider_id);		
				}	
			}
			
			
			if($request->ajax()) {
				
				return response()->json(['message' => 'Request Assigned to Provider!'] );
			
			} else {
				
				if(Auth::guard('admin')->user()){
					return redirect()
							->route('admin.dispatcher.index')
							->with('flash_success', 'Request Assigned to Provider!');

				} elseif(Auth::guard('dispatcher')->user()){
					return redirect()
							->route('dispatcher.index')
							->with('flash_success', 'Request Assigned to Provider!');
				}
			}
			
        } catch (Exception $e) {
			
			if($request->ajax()) {
				
			    return response()->json(['message' => $e->getMessage()], 500);
			} else {
				
				if(Auth::guard('admin')->user()){
					return redirect()->route('admin.dispatcher.index')->with('flash_error', 'Something Went Wrong!');
				}elseif(Auth::guard('dispatcher')->user()){
					return redirect()->route('dispatcher.index')->with('flash_error', 'Something Went Wrong!');
				}
				
			}			
        }
    }


    /**
     * Create manual request.
     *
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request) {
        
        $this->validate($request, [
                's_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                'distance' => 'required|numeric',
            ]);
		
		
		if( $request->has('booking_type') && $request->booking_type == 2 ) {
			$this->validate($request, [
                'amount_customer' => 'required|numeric',
            ]);
		}
		 
		try {
			
            $User = User::where('mobile', $request->mobile)->first();
            $ActiveRequests = UserRequests::PendingRequest($User->id)->count();
      
        } catch (Exception $e) {


			
            try {

                $User = User::where('email', $request->email)->first();
                $ActiveRequests = UserRequests::PendingRequest($User->id)->count();

            } catch (Exception $e) {

                $User = new User;
                $User->first_name = $request->first_name;
                $User->last_name = $request->last_name;
                $User->email = $request->email;
                $User->mobile = $request->mobile;
                $User->password = bcrypt($request->mobile);
                $User->payment_mode = 'CASH';    
                $User->save();
                $ActiveRequests = UserRequests::PendingRequest($User->id)->count();

                
            }

        }
		
		//Modified
		
		
		
		if($ActiveRequests > 0) {
			if($request->ajax()) {
				return response()->json(['flash_error' => trans('api.ride.request_inprogress')] );
			} else {
				
				return redirect('dashboard')->with('flash_error', 'Already request is in progress of this user. Try again later');
			}
		}
		
		
        if($request->has('schedule_time')) {
            
			try {
				
				
				$current = time();
				$schedule_time = strtotime( Carbon::parse( $request->schedule_time ) );
				$req_start = ( Setting::get('schedule_req_time') * 60 );
				$time = $current + $req_start;
				
				if( $schedule_time  < $time ) {
					if($request->ajax()) {
						return response()->json(['flash_error' => 'Please enter a schedule time as per admin guidelines!'] );
					} else {
						return redirect('dashboard')->with('flash_error', 'Please enter a schedule time as per admin guidelines!');
					}
				}
				
				
                $CheckScheduling = UserRequests::where('status', 'SCHEDULED')
                        ->where('user_id', $User->id)
                        ->where('schedule_at', '>', strtotime($request->schedule_time." - 1 hour"))
                        ->where('schedule_at', '<', strtotime($request->schedule_time." + 1 hour"))
                        ->first();
                
				if( $CheckScheduling ) {
					
					if($request->ajax()) {
						return response()->json(['flash_error' => trans('api.ride.request_scheduled')] );
					} else {
						return redirect('dashboard')->with('flash_error', 'Already request is Scheduled on this time.');
					}
					
				}

            } catch (Exception $e) {
                // Do Nothing
				if($request->ajax()) {
						return response()->json(['flash_error' => $e->getMessage() ] );
					} else {
						return redirect('dashboard')->with('flash_error', $e->getMessage() );
					}
			}
        } 
        

        try{
			
            Session::set('DispatcherUserId', $User->id);
			$service_type = $request->service_type;
			
			if( $request->has('request_id') ) {
				$UserRequest = UserRequests::where('id' , $request->request_id )->where('status', 'PENDING')->first();
				$req_filters = DB::table('request_filters')->where('request_id', $UserRequest->id )->get()->pluck('id')->toArray();
				if( $req_filters ) {
					DB::table('request_filters')->whereIn('id', $req_filters)->delete();
				}
				
				$UserRequest->delete();	
			}
			
			
			$point[0]	=	$request->s_latitude; 
			$point[1]	=	$request->s_longitude;
			$zone_id	=	Helper::getLatlngZone_id( $point );
			
			$Providers	=	Helper::availableProviders($service_type, $point[0], $point[1]);
			
			//$Providers 		=	Helper::getAvailableProvidersByRadius((int)$service_type , (int)$point[0], (int) $point[1] );
			
			
			if( ! $request->has('provider_auto_assign') ) {
				$availables_drivers = $Providers->pluck('id')->toArray();
				if( ! in_array($request->provider_id , $availables_drivers) ) {
					if($request->ajax()) {
						return response()->json(['flash_error' => 'Assigned provider not found in Zone! Please try again.' ]);
					} else {
						return back()->with('flash_error', 'Assigned provider not found in Zone! Please try again.');
					}
				}
			}
	

			
			$req_url = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".env('GOOGLE_MAP_KEY');
			$details =  (array) Helper::getDataByCurl( $req_url );
			$route_key = ( $details['status'] == 'OK' ) ?  $details['routes'][0]['overview_polyline']['points'] : '';
	

			
			$UserRequest = new UserRequests;
			$UserRequest->booking_id = Helper::generate_booking_id();
			$UserRequest->user_id = $User->id;
			$UserRequest->dispatcher_id =(isset($request->dispatcher_id) && !empty($request->dispatcher_id)) ?$request->dispatcher_id : 0;   ; 
			
			
			if($request->has('provider_auto_assign') ) {
				$UserRequest->current_provider_id = ( $Providers->count() ) ? $Providers[0]->id : 0; 
				$UserRequest->provider_id = ( $Providers->count() ) ? $Providers[0]->id : 0; 
			} else {
				$UserRequest->req_type = 'MANUAL';
				$UserRequest->current_provider_id = $request->provider_id;
			}
		    
			$UserRequest->service_type_id = $service_type;
			$UserRequest->payment_mode = 'CASH';
			
			
			$UserRequest->status =	( $Providers->count() ) ? 'PENDING' : 'PENDING';
			
			$UserRequest->s_address = $request->s_address ? : "";
			
			if( $request->has('booking_type') && $request->booking_type == 2 ) {
				
				$UserRequest->corporate_id = ( $request->corporate_id ) ? $request->corporate_id : 0; 
				$UserRequest->amount_customer = (int)$request->amount_customer;
				
			} else {
				$UserRequest->corporate_id = 0;
			}
			
			$UserRequest->estimated_fare 	=	$request->estimated_price;
			$UserRequest->item_id 	=	$request->item_id;
			$UserRequest->special_note 		=	$request->special_note;
			$UserRequest->s_latitude 		=	$request->s_latitude;
			$UserRequest->s_longitude 		=	$request->s_longitude;

			$UserRequest->d_address = $request->d_address ? : "";
			$UserRequest->d_latitude = $request->d_latitude;
			$UserRequest->d_longitude = $request->d_longitude;
			$UserRequest->route_key = $route_key;

			$UserRequest->distance = $request->distance;
			
			if( $UserRequest->current_provider_id ) {
				
				$UserRequest->assigned_at = Carbon::now();
			}

			
			$UserRequest->use_wallet = 0;
			$UserRequest->req_zone_id = ($zone_id) ? $zone_id : 0;
			$UserRequest->surge = 0;        // Surge is not necessary while adding a manual dispatch
			$UserRequest->payment_method_id =  ( $request->payment_method ) ? $request->payment_method : 0 ;
			
			if($request->has('schedule_time')) {
				$UserRequest->schedule_at = Carbon::parse($request->schedule_time);
				$UserRequest->status = 'SCHEDULED';
			}
			
			$UserRequest->save();
			
			Log::useFiles(storage_path().'/logs/dispatcher.log');
			Log::info('New Request Created by dispatcher : ' . $UserRequest->booking_id);
		
			
			if( $UserRequest->current_provider_id ) {
				if( $UserRequest->status != 'SCHEDULED' ) {
					if( $Providers->count() ) {
						$inserted_data = [];
						foreach ($Providers as $Provider) {
							$inserted_data[] = [
								'request_id'	=> $UserRequest->id,
								'provider_id'	=> $Provider->id
							];
						}
						
						if( $inserted_data ) {
							DB::table('request_filters')->insert( $inserted_data );
						}
						
					}
					
					if( ! $request->has('provider_auto_assign') ) {
						$Filter = new RequestFilter;
						$Filter->request_id = $UserRequest->id;
						$Filter->provider_id = $UserRequest->current_provider_id; 
						// $Filter->save();
					}
					
					(new SendPushNotification)->IncomingRequest($UserRequest->current_provider_id);
					
				}
				
			} else {
				
				(new SendPushNotification)->ProviderNotAvailable($UserRequest->user_id);
				
			}
			
			if( $UserRequest) {
				return ( $request->ajax() ) ? $UserRequest : redirect('dashboard');
			} else {
                return redirect('dashboard');
            }
			

        } catch (Exception $e) {
			
            if($request->ajax()) {
                return response()->json(['message' => $e->getMessage()], 500);
            }else{
                return back()->with('flash_error', $e->getMessage() );
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('dispatcher.account.profile');
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
            $dispatcher = Auth::guard('dispatcher')->user();
            $dispatcher->name = $request->name;
            $dispatcher->mobile = $request->mobile;
            $dispatcher->save();

            return redirect()->back()->with('flash_success','Profile Updated');
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
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
        return view('dispatcher.account.change-password');
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

           $Dispatcher = Dispatcher::find(Auth::guard('dispatcher')->user()->id);

            if(password_verify($request->old_password, $Dispatcher->password))
            {
                $Dispatcher->password = bcrypt($request->password);
                $Dispatcher->save();

                return redirect()->back()->with('flash_success','Password Updated');
            }
			else{
				return back()->with('flash_error','check your password');
			}
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }


     public function map_index()
    {
		$data 				=	array();
		$zones 				=	Zones::all()->toArray();
		$data['postcoes']	=   Zones::all()->pluck('postcode_area', 'id')->toArray();
		$data['zones']		=	$this->getZonesWithProvider();
	
        return view('dispatcher.map.index', ['data' => $data ]);
    }
	
	
    /**
     * Map of all Users and Drivers.
     *
     * @return \Illuminate\Http\Response liveMap_ajax
     */
    public function map_ajax(Request $request)
    {
    	 	
        try {
			return Provider::with('service')
						->whereHas('service', function( $query ) use ($request) {
							if($request->header('driver')=='true'){
								$query->where('provider_services.status', 'active');
							}elseif($request->header('ongoing')=='true'){
								$query->where('provider_services.status', 'riding');
							}else{
								$query->where('provider_services.status', 'active')
									->orWhere('provider_services.status', 'riding');
							}
						
						})->where('latitude', '!=', 0)->where('longitude', '!=', 0)
						->where('providers.status', 'approved')->get();
						
        }   catch (Exception $e) {
            return [];
        }
    }


    public function get_ride_fare(Request $request)
    {
        $this->validate($request,[
                's_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
            ]);

        try{
			
			$result = Helper::getEstimatedFare( $request->all() );
			
			if( isset($result['error']) ) {
				throw new Exception( serialize(['error'=> $result['error'] ] ) );
			}
			
			if($request->ajax()) {
                return response()->json( $result );
            }else{
                return $result;
            }
			
			
            
			
			/*
            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=".env('GOOGLE_MAP_KEY');

            $json = curl($details);

            $details = json_decode($json, TRUE);

            $meter = $details['rows'][0]['elements'][0]['distance']['value'];
            $time = $details['rows'][0]['elements'][0]['duration']['text'];
            $seconds = $details['rows'][0]['elements'][0]['duration']['value'];

            $kilometer = number_format( ( $meter / 1000 ), 3, '.', '');
            $minutes = round($seconds/60);

            $tax_percentage = Setting::get('tax_percentage');
            $commission_percentage = Setting::get('commission_percentage');
            $service_type = ServiceType::findOrFail($request->service_type);
            
            $price = $service_type->fixed;

            if($service_type->calculator == 'MIN') {
                $price += $service_type->minute * $minutes;
            } else if($service_type->calculator == 'HOUR') {
                $price += $service_type->minute * 60;
            } else if($service_type->calculator == 'DISTANCE') {
                $price += ($kilometer * $service_type->price);
            } else if($service_type->calculator == 'DISTANCEMIN') {
                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes);
            } else if($service_type->calculator == 'DISTANCEHOUR') {
                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
            } else {
                $price += ($kilometer * $service_type->price);
            }

            $tax_price = ( $tax_percentage/100 ) * $price;
            $total = $price + $tax_price;
            $surge_price = (Setting::get('surge_percentage')/100) * $total;
            $total += $surge_price;
            $surge = 1;
            
			$service = (new Resource\ServiceResource)->show($request->service_type);

			$result = [
                    'estimated_fare' => round($total,1), 
                    'distance' => $kilometer,
                    'service'=>$service,
                    'time' => $time,
                    'surge' => $surge,
                    'surge_value' => '1.4X',
                    'tax_price' => $tax_price,
                    'base_price' => $service_type->fixed
                    
                ];
			
			
			return $result;
			*/
			
        } catch(Exception $e) {
			
			$errors = unserialize($e->getMessage());
			
			if($request->ajax()) {
                return response()->json($errors , 500);
            }else{
                return back()->with('flash_error', $errors['error'] );
            }
			
            
        }
        
 
    }

     public function singleTrip(Request $request)
    {
        
		$user_id = Auth::user()->id;
		 $model =  new UserRequests();
		// echo $user_id;die;
		$Trips   = $model->where('dispatcher_id',$user_id)->orderBy('id','desc')->first();

		if(!empty($Trips)){
			return response()->json(['status'=>1,'msg'=>'get data','data'=>$Trips]);
		}else{
			return response()->json(['status'=>0,'msg'=>'no record found','data'=>'']);
		}
    }
	
	function trip_data(Request $request ) {
		
		$trip = array();
		if( $request->input('trip_id') ) {
			$trip = UserRequests::where('id', $request->input('trip_id') )->first()->toArray();
			return $trip;
		} else {
			return $trip;
		}
	}
	
	
	public function getZonesWithProvider() {
		
		$data_zones = array();
		$zones	=	Zones::all()->toArray();
		
		if( $zones ) {
			
			foreach( $zones  as  $zone ) {
				
				$drivers	= DB::table('providers')
										->join('provider_zone', 'provider_zone.driver_id', '=', 'providers.id')
										->join('provider_services', 'provider_services.provider_id', '=', 'providers.id')
										->select(DB::raw('providers.*, DATE_FORMAT(provider_zone.created_at , "%b %d %h:%i %p") as enter_time, provider_zone.id as driver_position, provider_services.service_number, provider_services.service_model, provider_services.status as provider_status') )
										->where('provider_zone.zone_id', $zone['id'])
										->orderBy('provider_zone.id', 'asc')->get()->toArray();
				
				$zone['drivers'] = $drivers;
				$zone['coordinate'] = unserialize( $zone['coordinate'] );
				$data_zones[] = $zone;
			}			
		}		
		return $data_zones;		
	}
	
	
	public function getAvailableProviders($service_type = 0, $zone_id = 0) {
		
		$Providers = new Provider;
		
		if($service_type && $zone_id) {
			
			$Providers = DB::table('providers')
			->join('provider_zone', 'provider_zone.driver_id', '=', 'providers.id')
			->join('provider_services', 'provider_services.provider_id', '=', 'providers.id')
			->select(DB::raw('providers.*, provider_zone.created_at as enter_time, provider_zone.id as driver_position, provider_services.service_number, provider_services.service_model, provider_services.service_type_id, provider_services.status AS provider_current_status') )
			->where('providers.status', 'approved')
			->where('provider_services.status', 'active')
			->where('provider_services.service_type_id', $service_type)	
			->where('provider_zone.zone_id', $zone_id )
			->orderBy('provider_zone.id')
			->get();
			
		} else {
			
			$Providers = DB::table('providers')
			->join('provider_zone', 'provider_zone.driver_id', '=', 'providers.id')
			->join('provider_services', 'provider_services.provider_id', '=', 'providers.id')
			->select(DB::raw('providers.*, provider_zone.created_at as enter_time, provider_zone.id as driver_position, provider_services.service_number, provider_services.service_model, provider_services.service_type_id, provider_services.status AS provider_current_status') )
			->where('providers.status', 'approved')
			->where('provider_services.status', 'active')
			->orderBy('provider_zone.id' )
			->get();
			
		}
		
		return $Providers;

	}
	
	
	public function getLatlngZone_id( $point ) {
		$id = 0;
		$zones = Zones::all(); 
		if( count( $zones ) ) {
			foreach( $zones as $zone ) {
				if( $zone->coordinate ) {
					$coordinate = unserialize( $zone->coordinate );
					$polygon = [];
					foreach( $coordinate as $coord ) {
						$new_coord = explode(",", $coord );
						$polygon[] = $new_coord;
					}
					
					if ( Helper::pointInPolygon($point, $polygon) ) {
						return $zone->id;
					}
				}
			}
		}		
		return $id;		
	}

	
	function getUserDetail(Request $request ) {
		$user = [];
		
		if( $request->has('id') ) {
			if( $u = User::find( $request->id ) ) {
				$user = [
					'id'			=>	$u->id,
					'first_name'	=>	$u->first_name,
					'last_name'		=>	$u->last_name,
					'email'			=>	$u->email,
					'mobile'		=>	$u->mobile
				];
			}
		}		
		return $user;		
	}
	
	
	function getlogs() {
		return file( storage_path('logs/dispatcher.log') );
	}
	
	
	public function  test( ) {
		
		$data['service_type'] = 1;
		$data['s_latitude'] = 28.5355161;
		$data['s_longitude'] = 77.39102649999995;
		$data['d_latitude'] = 28.471425;
		$data['d_longitude'] = 77.07239000000004;
		
		$result =	Helper::getEstimatedFare( $data );
	}

	public function openTicket(){
		$dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();
		$tickets = Ticket::where('status','=',"open")->where('dept_id',$dept)->orderBy('created_at', 'ASC')->get();

		foreach($tickets as $ticket){
			$ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
			$ticket->from_Dep = Department::where('id',$ticket->department)->first();
		}
		// return $tickets;
        return view('dispatcher.ticket.open_ticket', compact('tickets'));
    }
    public function closeTicket(){

        $data = Complaint::where('transfer',2)->where('status',0)->get();

        return view('dispatcher.close_ticket', compact('data'));
    }
	public function ticketDetails($id){
		
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->orderBy('created_at','DSC')->get();
            $depts = Department::orderBy('dept')->get();
            $from_Dep = Department::where('id',$ticket->department)->first();

            return view('dispatcher.ticket.ticket_details', compact('ticket', 'comments', 'depts','from_Dep'));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
	public function replyTickets(Request $request, $ticket_id){
        try{
            $dep =Department::where('dept',"=",'Branch')->pluck('id')->first();
            
            $ticketComment = new TicketComment();
            $ticketComment->ticket_id = $ticket_id;
            $ticketComment->comment = $request->input('cs_comment');
            //$ticketComment->authorised_type = "cs";
            $ticketComment->dept_id = $dep;
            $ticketComment->is_read_cs = '0';
            $ticketComment->authorised_id = Auth::user()->id;

            $ticketComment->save();
            return back()->with('flash_success', 'Your reply has send successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
	public function close_Tickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
			// return "hello";
            return redirect('/dispatcher/openTicket')->with('flash_success', 'Ticket Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function transfer($id,Request $request){

        $data = Complaint::where('id',$id)->first();
        $data->status = $request->status;
        $data->transfer = $request->transfer;
        $data->reply = $request->reply;
        $data->save();
        return redirect()->back()->with('flash_success','Ticket Updated');
       
	}
	
	public function track(Request $request)
    {	
		try {
			$dispatcher=Auth::user()->id;
            if(isset($request->search)){
                if($request->has('searchField')){
                    $requests=UserRequests::where(function($q) use ($request){
						$q->where(function($q) use ($request){
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
						})->whereHas('dispatchList');
                    })
					->orWhere('booking_id','LIKE','%'.$request->searchField.'%');
				}

				//we have to filter out the requests based on the zone in which dispatcher works

				//get the zones of current dispatcher
				$zones=DispatcherToZone::where('dispatcher_id',$dispatcher)->pluck('zone_id')->toArray();
				//create new collection and filter only those which are in the zone
				$dispatcherRequests=$requests->get();
				$dispatcherRequests=$dispatcherRequests->filter(function($req) use($zones){
					return (in_array($req->zone1,$zones) || in_array($req->zone2,$zones));
				});
				//note that we could get the requests directly using this method in dispatcherRequests but in order
				//to paginate, we are using whereIn
				$requests=$requests->whereIn('id',$dispatcherRequests->pluck('id')->toArray())->get();
				$allRiders=Provider::select("id","first_name",'zone_id')->where("status","approved")->orderBy('first_name')->get();
				$totalRiders=$allRiders->filter(function($rider) use($zones){
					return in_array($rider->zone_id,$zones);
				});
                $dates=true;
                return view('dispatcher.dispatchList.track', compact(['requests','dates']));
            }
            else{
				$requests = [];
				$dates=true;
                return view('dispatcher.dispatchList.track', compact(['requests','dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
	public function clearDraft($id)
	{
		// return "hi";
		try{
			// return $id;
			$bulk=DispatchBulkList::findOrFail($id);
			$bulk->received=1;
			$bulk->received_all=1;
			$bulk->save();
			return back()->with('sucess','Draft clear');
			}
		catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
	
}
