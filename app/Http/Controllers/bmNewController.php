<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Provider;
use App\Department;
use App\UserRequests;
use App\TicketComment;
use App\DispatchBulkList;
use App\DispatcherToZone;
use App\ZoneDispatchList;
use App\ManagerToDispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class bmNewController extends Controller
{
     public function viewDispatch(){
		try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            // $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
			$requests=DispatchBulkList::where('received',false)->where('incomplete_received',false)->where('draft','=','0')->whereIn('zone1_id',$dispatcherid)->withCount('lists')->get();
            return view('bm.dispatchList.dispatchList', compact(['requests']));
            // return view('dispatcher.dispatchList.dispatchList', compact(['requests','services','all_zones','companies','ip_details']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

     public function view_completeReached(){
		try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			$requests = DispatchBulkList::where('received',true)->where('received_all',true)->where('incomplete_received',false)->where('draft','=','0')->whereIn('zone1_id',$dispatcherid)->withCount('lists')->get();

            return view('bm.dispatchList.completeReached', compact(['requests']));
        }   catch (Exception $e) {
			// dd($e->getMessage());
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

    public function view_incompleteReached(){
		try {
			$dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			$requests=DispatchBulkList::where('incomplete_received', true)->whereIn('zone1_id',$dispatcherid)->withCount('lists')->get();

            return view('bm.dispatchList.incompleteReached', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

      public function viewDraft(){
		try {
			$dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			$requests=DispatchBulkList::where('received',false)->where('draft','=','1')->whereIn('zone1_id',$dispatcherid)->withCount('lists')->get();
            return view('bm.dispatchList.draft', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

    public function showDetailDispatch($id)
    {
        try {

			//check if user has access
			$bulk=DispatchBulkList::findOrFail($id);
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			if(in_array($bulk->zone1_id, $dispatcherid) || in_array($bulk->zone2_id, $dispatcherid) ){
				$requests=ZoneDispatchList::where('dispatch_id',$id)->get();
            	return view('bm.dispatchList.detailDispatch', compact(['requests','id']));
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
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			if(in_array($bulk->zone1_id, $dispatcherid) || in_array($bulk->zone2_id, $dispatcherid) ){
				$requests=ZoneDispatchList::where('dispatch_id',$id)->where('received', '=', '1')->get();
            	return view('bm.dispatchList.detailCompleteReceived', compact(['requests']));
			}
			else{
				return back()->with('flash_error','You cant access this data!');
			}
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

     public function showNewDetailDispatch($id)
    {
        try {
			
			$dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			$bulk=DispatchBulkList::findOrFail($id);
			
			if(in_array($bulk->zone1_id, $dispatcherid) || in_array($bulk->zone2_id, $dispatcherid) ){
				$requests=ZoneDispatchList::where('dispatch_id',$id)->get();

            	return view('bm.dispatchList.detailReceived', compact(['requests']));
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
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			$requests=DispatchBulkList::where('received_all','=', '0')
					->where('incomplete_received', '=', '0')
					->where('draft', '=', '0')
					->where('Returned','0')
					->where('zone2_id',$dispatcherid)
					->withCount(['lists','lists as received'=> function($query){
						$query->where('received', '=', '1');
					}])
					->get();

            return view('bm.dispatchList.pending', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

    public function track(Request $request)
    {	
		try {
			$dispatcher=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
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
				$zones=DispatcherToZone::whereIn('dispatcher_id',$dispatcher)->pluck('zone_id')->toArray();
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
                return view('bm.dispatchList.track', compact(['requests','dates']));
            }
            else{
				$requests = [];
				$dates=true;
                return view('bm.dispatchList.track', compact(['requests','dates']));
            }
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

     public function viewReturnDispatch(){
		try {
			$dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			$requests=DispatchBulkList::where('received',false)->where('incomplete_received',false)->where('draft','=','0')->where('Returned','1')->whereIn('zone1_id',$dispatcherid)->withCount('lists')->get();
            return view('bm.dispatchList.returndispatch', compact(['requests']));
            // return view('dispatcher.dispatchList.dispatchList', compact(['requests','services','all_zones','companies','ip_details']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

     public function complete_received()
    {
        try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            $requests=DispatchBulkList::where('received',true)
                    ->where('received_all',true)
                    ->where('incomplete_received', false)
                    ->where('draft', false)
                    ->where('zone2_id',$dispatcherid)
                    ->withCount('lists')
                    ->get();
            
            return view('bm.dispatchList.completeReceived', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

     public function incomplete_received()
    {
        try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            $requests=DispatchBulkList::where('incomplete_received', true)
                    ->where('received_all',false)
                    ->where('draft', false)
                    ->where('zone2_id',$dispatcherid)
                    ->withCount(['lists',
                    'lists as received'=>function($query){
                        $query->where('received', '=', '1');
                    }])
                    ->get();

            return view('bm.dispatchList.incompleteReceived', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

     public function openTicket(){
		$dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();
		$tickets = Ticket::where('status','=',"open")->where('dept_id',$dept)->orderBy('created_at', 'ASC')->get();

		foreach($tickets as $ticket){
			$ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
			$ticket->from_Dep = Department::where('id',$ticket->department)->first();
		}
		// return $tickets;
        return view('bm.ticket.open_ticket', compact('tickets'));
    }

     public function bulkAssign()
    {
        try {
             $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            $requests = UserRequests::whereIn('zone1',$currentZones)->groupBy('user_id')
                ->select(
                    'user_id',
                    'status',
                    'provider_id',
                    's_address',
                    DB::raw('count(*) as count')
                )
                ->where('status', 'PENDING')
                ->get();
            foreach ($requests as $request) {
                $r = UserRequests::where('user_id', $request->user_id)
                    ->select(DB::raw("sum(if(user_requests.returned='0',1,0)) as r"))
                    ->whereIn('status', ["CANCELLED", "REJECTED"])
                    ->where('returned_to_hub', '1')
                    ->first();
                $request->r = $r->r;
            }
            return view('bm.request.bulkassign', compact(['requests']));
        } catch (Exception $e) {
            return $e->getMessage();
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

       public function vendorAssign($id)
    {
        try {
             $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
            // dd($dispatcherid);
            $currentZones=DispatcherToZone::whereIn('dispatcher_id',$dispatcherid)->pluck('zone_id')->toArray();
            $requests = UserRequests::where('user_id',$id)->whereIn('zone1',$currentZones)
            ->where(function($query){
                $query->where('status','=','PENDING')->orWhere('status','=','ACCEPTED')->orWhere('status','=','NOTPICKEDUP');
                })
            ->get();
            $totalRiders = Provider::select("id", "first_name")->where("status", "approved")->where('type', 'pickup')->orderBy('first_name')->get();
            return view('bm.request.vendorWise', compact(['totalRiders','requests'] ));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function returnDispatch()
    {
        try {
            $dispatcherid=ManagerToDispatcher::where('branch_manager_id',Auth::user()->id)->pluck('dispatcher_id')->toArray();
			$requests=DispatchBulkList::where('received_all','=', '0')
					->where('incomplete_received', '=', '0')
					->where('draft', '=', '0')
					->where('Returned','1')
					->where('zone2_id',$dispatcherid)
					->withCount(['lists','lists as received'=> function($query){
						$query->where('received', '=', '1');
					}])
					->get();

            return view('bm.dispatchList.rejectedpending', compact(['requests']));
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}
    
}
