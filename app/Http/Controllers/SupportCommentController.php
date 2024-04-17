<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Items;
use App\Zones;
use App\Ticket;
use App\Comment;
use App\Provider;
use App\Department;
use App\UserRequests;

use App\TicketComment;
use App\DispatcherToZone;
use App\Model\Notification;
use Illuminate\Http\Request;

class SupportCommentController extends Controller
{
    // Multiple view of Order for comment...
    public function allOrderComment()
    {
        try{
            $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->paginate(100);

            foreach($allOrderComments as $allOrderComment){
                $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status','=','0')->first();
                $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
                $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->count();
            }
            return view('support.comment.all_order_comments', compact('allOrderComments'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function supportComment()
    {
        try{
            $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '0')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->paginate(100);
                                
            $dep =Department::where('dept',"=",'Customer Service')->pluck('id')->first();
            foreach($allOrderComments as $allOrderComment){

                $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status','=','0')->first();
                $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
                $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->count();
            }
            // return $allOrderComments;
            return view('support.comment.supportComment', compact('allOrderComments','dep'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function solved_Comments()
    {
        try{
            $allOrderComments = DB::table('comments')
                                ->join('user_requests', 'comments.request_id', '=', 'user_requests.id')
                                ->where('user_requests.comment_status', '=', '1')
                                ->select('comments.request_id', 'comments.created_at', DB::raw('COUNT(*) as `count`'))
                                ->groupBy('comments.request_id')
                                ->orderBy('comments.created_at', 'ASC')
                                ->having('count', '>=', 1)
                                ->paginate(100);

            foreach($allOrderComments as $allOrderComment){
                $allOrderComment->ur = UserRequests::where('id','=',$allOrderComment->request_id)->where('comment_status', '=', '1')->first();
                $allOrderComment->user = User::where('id','=',$allOrderComment->ur->user_id)->first();
                $allOrderComment->noComment = Comment::where('request_id', $allOrderComment->request_id)->where('is_read_cs','=',"1")->count();
            }
            
            return view('support.comment.all_solved_comments', compact('allOrderComments'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // Single view of each Order with Comment...
    public function all_comment($id){
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
            
            return view('support.comment.all_comments_page', compact('comments', 'user_req', 'depts'));

            // $comments = Comment::where('request_id','=',$id)->orderBy('created_at', 'ASC')->get();
            // $user_req = UserRequests::where('id', $id)->first();
            // $depts = Department::orderBy('dept')->get();

            // return view('support.comment.all_comments_page', compact('comments', 'user_req', 'depts'));
            
        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // Save comment from "Single view of each Order with Comment..."
    public function cs_orderReply(Request $request, $req_id){
        try{
            $dept = Department::where('dept', '=', 'Customer Service')->pluck('id')->first();
            
            $comment = new Comment();
            $comment->request_id = $req_id;
            //$comment->authorised_type = "cs";
            $comment->dept_id = $dept;
            $comment->authorised_id = Auth::user()->id;
            $comment->comments = $request->input('comment');
            $comment->is_read_cs = '0';
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
            return back()->with('flash_error', 'Something went wrong!');
        }
    }


    //This will help to change Status --> to make Solved Comment
    public function solve_Comment(Request $request, $req_id){
        try{
            $solve_comment = UserRequests::findOrFail($req_id);
            $solve_comment->comment_status = $request->input('status');

            $solve_comment->update();
            return redirect('/support/allorder/comment')->with('flash_success', 'Order problem solved successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    //This will help to change Status --> to make Unsolved Comment
    public function unsolve_Comment(Request $request, $req_id){
        try{
            $unsolve_comment = UserRequests::findOrFail($req_id);
            $unsolve_comment->comment_status = $request->input('status');

            $unsolve_comment->update();
            return redirect('/support/solved_comment')->with('flash_success', 'Order problem reopen Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }



    // --------------------------------------------
    //              Ticket
    //---------------------------------------------
    public function add_newTicket(){
        try{
            return view('support.comment.user_ticket');
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
            return view('support.comment.user_ticket', compact('users'));
        }
    }

    public function user_AllTickets($id){
        try{
            $tickets = Ticket::where('user_id','=', $id)->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_user','=',"1")->count();
            }

            return view('support.comment.user_all_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    public function user_commentTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();
            $depts = Department::orderBy('dept')->get();

            return view('support.comment.user_ticket_comment', compact('ticket', 'comments', 'depts'));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    public function user_close_open(Request $request, $ticket_id){
        try{
            $open_close = Ticket::findOrFail($ticket_id);
            $open_close->status = $request->input('status');

            $open_close->update();
            return redirect('/support/add_newticket')->with('flash_success', 'Status update successfully!');
            //return back()->with('flash_success', 'Comment Open Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function todayTickets(){
        try{
            $tickets = Ticket::where('status','=',"open")->whereDate('created_at', DB::raw('CURDATE()'))->orderBy('created_at', 'ASC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
            }

            return view('support.comment.today_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    public function ticket_add($id){
        $user = User::where('id', $id)->first();
        $depts = Department::orderBy('dept')->get();

        return view('support.comment.add_ticket', compact('user', 'depts'));
    }

    public function save_user_ticket(Request $request){
        try{
            $ticket = new Ticket();
            
            $ticket->user_id = $request->input('user_id');
            //$ticket->department = $request->input('department');
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

    // Multiple view of Open Ticket for comment...
    public function openTickets(){
        try{
            $tickets = Ticket::where('status','=',"open")->orderBy('created_at', 'ASC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
            }

            return view('support.comment.open_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }
    
    public function today_commentTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();
            $depts = Department::orderBy('dept')->get();

            return view('support.comment.today_ticket_comment', compact('ticket', 'comments', 'depts'));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }



    public function commentTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();
            $depts = Department::orderBy('dept')->get();

            return view('support.comment.ticket_comment', compact('ticket', 'comments', 'depts'));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Multiple view of Close Ticket for comment...
    public function closeTickets(){
        try{
            $tickets = Ticket::where('status','=',"close")->orderBy('created_at', 'ASC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
            }

            return view('support.comment.close_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }


    public function replyTickets(Request $request, $ticket_id){
        try{
            $dept = Department::where('dept', '=', 'Customer Service')->first();
            
            $ticketComment = new TicketComment();
            $ticketComment->ticket_id = $ticket_id;
            $ticketComment->comment = $request->input('cs_comment');
            //$ticketComment->authorised_type = "cs";
            $ticketComment->dept_id = $dept->id;
            $ticketComment->is_read_cs = '0';
            $ticketComment->authorised_id = Auth::user()->id;

            $ticketComment->save();
            return back()->with('flash_success', 'Your reply has send successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // This will help to change Status, to make Close of today
    public function today_close_Tickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/support/todaytickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    //This will help to change Status --> to make Close
    public function close_Tickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/support/opentickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    //This will help to change Status --> to make Open
    public function open_Tickets(Request $request, $ticket_id){
        try{
            $open_ticket = Ticket::findOrFail($ticket_id);
            $open_ticket->status = $request->input('status');

            $open_ticket->update();
            return redirect('/support/closetickets')->with('flash_success', 'Comment Open Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function ticketDepartment(Request $request, $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            if($request->ajax()) {
                //if(isset($request->department)){
                    //dd($request->department);
                    $ticket->dept_id= $request->department;
                //}
            }
            $a=$ticket->save();
            return response()->json([
                'request' => $request,
                'error' => $a
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    
    public function orderDepartment(Request $request, $id)
    {
        try {
            $ur = UserRequests::findOrFail($id);
            if($request->ajax()) {
                //if(isset($request->department)){
                    //dd($request->department);
                    $ur->dept_id= $request->department;
                    $ur->save();
                    //$a=$ticket->save();
                //}
            }
            $a = $ur;
            return response()->json([
                'request' => $request,
                'error' => $a
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


}
