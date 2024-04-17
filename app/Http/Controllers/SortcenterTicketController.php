<?php

namespace App\Http\Controllers;

use App\Fare;
use App\User;
use App\Ticket;
use App\Comment;
use App\Department;
use App\UserRequests;
use App\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Setting;

class SortcenterTicketController extends Controller
{
    public function add_newTicket(){
        try{
            return view('sortcenter.ticket.newTicket');
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
    public function search_user(Request $request){
        if(isset($request->search)){
            $users = User::orderBy('created_at' , 'desc')
                        ->where('first_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('last_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('company_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('email','LIKE','%'.$request->searchField.'%')
                        ->orWhere('mobile','LIKE','%'.$request->searchField.'%')
                        ->get();
            // $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
            // $revenue = User::sum('wallet_balance');
            return view('sortcenter.ticket.newTicket', compact('users'));
        }
    }
    public function ticket_add($id){
        $user = User::where('id', $id)->first();
        $depts = Department::orderBy('dept')->get();

        return view('sortcenter.ticket.addNewTicket', compact('user', 'depts'));
    }
    public function save_user_ticket(Request $request){
        try{
            $dep =Department::where('dept',"=",'Sortcenter')->pluck('id')->first();
            $ticket = new Ticket();
            
            $ticket->user_id = $request->input('user_id');
            $ticket->department = $dep;
            $ticket->dept_id = $request->input('dept_id');
            $ticket->title = $request->input('title');
            $ticket->description = $request->input('description');
            $ticket->priority = $request->input('priority');
            $ticket->authorised_id = Auth::user()->id;
            $ticket->createdby_cs = '1';

            $ticket->save();
            return back()->with('flash_success', 'Ticket save successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function openTickets(){
        try{
            $dep =Department::where('dept',"=",'Sortcenter')->pluck('id')->first();
            $tickets = Ticket::where('status','=',"open")->where('dept_id',$dep)->orderBy('created_at', 'ASC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
                $ticket->from_Dep = Department::where('id',$ticket->department)->first();
            }
            return view('sortcenter.ticket.allTickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
    public function commentTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->orderBy('created_at','desc')->get();
            $depts = Department::orderBy('dept')->get();
            $from_Dep = Department::where('id',$ticket->department)->first();

            return view('sortcenter.ticket.ticketComment', compact('ticket', 'comments', 'depts','from_Dep'));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
    public function close_Tickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/sortcenter/opentickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function replyTickets(Request $request, $ticket_id){
        try{
            $dep =Department::where('dept',"=",'Sortcenter')->pluck('id')->first();
            
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
    public function sortcenterUnsolve()
    {
        try{
            $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->get();
                                
            $dep =Department::where('dept',"=",'Sortcenter')->pluck('id')->first();
            foreach($allOrderComments as $allOrderComment){

                $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status','=','0')->first();
                $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
                $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->count();
            }
            // return $allOrderComments;
            return view('sortcenter.comment.sortcenterComment', compact('allOrderComments','dep'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function change_cargo(Request $request, $req_id){
        try {
            // return $request->all();
           $UserRequest = UserRequests::findOrFail($req_id);
        //    return $UserRequest->zone1;
            if($request->cargo==0){
                $UserRequest->cargo = $request->cargo;
                $UserRequest->amount_customer = $UserRequest->fare;
                $UserRequest->save();
                    return response()->json([
                        'request' => $request,
                        'message' => 'cargo reverse back',
                        'error' => $UserRequest
                    ]);
            }
            else{           
                // return "hello";
                $cargo=Fare::where('zone1_id',$UserRequest->zone1)->where('zone2_id',$UserRequest->zone2)->where('cargo','1')->first();
              
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
