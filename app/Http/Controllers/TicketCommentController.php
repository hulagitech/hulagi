<?php

namespace App\Http\Controllers;

use DB;

use Auth;
use App\User;
use Exception;

use App\Ticket;
use App\Department;
use App\TicketComment;
use Illuminate\Http\Request;

class TicketCommentController extends Controller
{
    public function add_newTicket(){
        try{
            return view('return.ticket.newTicket');
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
            return view('return.ticket.newTicket', compact('users'));
        }
    }
    public function ticket_add($id){
        $user = User::where('id', $id)->first();
        $depts = Department::orderBy('dept')->get();

        return view('return.ticket.addNewTicket', compact('user', 'depts'));
    }
    public function save_user_ticket(Request $request){
        try{
            $dep =Department::where('dept',"=",'Returns')->pluck('id')->first();
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
    public function return_allTickets(){
        try{
            $dep =Department::where('dept',"=",'Returns')->pluck('id')->first();
            $tickets = Ticket::where('status','=',"open")->where('dept_id',$dep)->orderBy('created_at', 'ASC')->paginate(100);
// return $tickets;
            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
                $ticket->from_Dep = Department::where('id',$ticket->department)->first();
            }

            return view('return.ticket.allTickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    //___________________________________________
    //      "Account User" Section Ticket
    //-------------------------------------------
    // Display a listing of the Today's Ticket.
   
    public function todayTickets(){
        try{
            $dept = Department::where('dept', '=', 'Account')->pluck('id')->first();

            $tickets = Ticket::where('dept_id', $dept)->where('status','=',"open")->whereDate('created_at', DB::raw('CURDATE()'))->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_account','=',"1")->count();
            }

            return view('account.ticketcomment.today_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Today's ticket comment
    public function today_detailTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();

            return view('account.ticketcomment.today_ticket_detail', compact(['ticket', 'comments']));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // This will help to change Status, to make Close of today
    public function today_close_Tickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/account/todaytickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // Ticket comment reply
    public function account_replyTickets(Request $request, $ticket_id){
        try{
            $dep =Department::where('dept',"=",'Accounts')->pluck('id')->first();
            
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

    // This help to get all open tickets which is related to account only.
    public function openTickets(){
        try{
            $dept = Department::where('dept', '=', 'Accounts')->pluck('id')->first();

            $tickets = Ticket::where('dept_id', $dept)->where('status','=',"open")->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_cs','=',"1")->count();
            }

            return view('account.ticketcomment.open_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Open ticket details
    public function detailTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();

            return view('account.ticketcomment.open_ticket_detail', compact(['ticket', 'comments']));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    //This will help to change Status --> to make Close
    public function close_Tickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/account/opentickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    




    //___________________________________________
    //      "Return User" Ticket Section
    //-------------------------------------------

    // Display a listing of the Today's Ticket.
    public function return_todayTickets(){
        try{
            $dept = Department::where('dept', '=', 'Return')->pluck('id')->first();

            $tickets = Ticket::where('dept_id', $dept)->where('status','=',"open")->whereDate('created_at', DB::raw('CURDATE()'))->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_return','=',"1")->count();
            }

            return view('return.ticket.today_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Today's ticket comment
    public function return_tdetailTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();

            return view('return.ticket.today_ticket_detail', compact(['ticket', 'comments']));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // This will help to change Status, to make Close of today
    public function return_tcloseTickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/return/todaytickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // Ticket comment reply
    public function return_replyTickets(Request $request, $ticket_id){
     
            try{
                $dep =Department::where('dept',"=",'Returns')->pluck('id')->first();
                
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

    // This help to get all open tickets which is related to return only.
    

    // Open ticket details
    public function return_detailTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();
            $depts = Department::orderBy('dept')->get();
            $from_Dep = Department::where('id',$ticket->department)->first();
            return view('return.ticket.open_ticket_detail', compact(['ticket', 'comments', 'depts','from_Dep']));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    //This will help to change Status --> to make Close
    public function return_closeTickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/return/opentickets')->with('flash_success', 'Ticket Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }





    //___________________________________________
    //      "Branch Manager - BM" Ticket Section
    //-------------------------------------------

    // Display a listing of the Today's Ticket.
    public function bm_todayTickets(){
        try{
            $dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();

            $tickets = Ticket::where('dept_id', $dept)->where('status','=',"open")->whereDate('created_at', DB::raw('CURDATE()'))->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_bm','=',"1")->count();
            }

            return view('bm.ticketcomment.today_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Today's ticket comment
    public function bm_tdetailTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();
            //$depts = Department::orderBy('dept')->get();

            return view('bm.ticketcomment.today_ticket_detail', compact(['ticket', 'comments']));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    public function bm_replyTickets(Request $request, $ticket_id){
        try{
            $dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();
            
            $ticketComment = new TicketComment();
            $ticketComment->ticket_id = $ticket_id;
            $ticketComment->comment = $request->input('comment');
            //$ticketComment->authorised_type = "bm";
            $ticketComment->dept_id = $dept;
            $ticketComment->is_read_bm = '0';
            $ticketComment->authorised_id = Auth::user()->id;

            $ticketComment->save();
            return back()->with('flash_success', 'Your reply has send successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // This will help to change Status, to make Close of today
    public function bm_tcloseTickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/bm/todaytickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // This help to get all open tickets which is related to BM only.
    public function bm_allTickets(){
        try{
            $dept = Department::where('dept', '=', 'Branch Manager')->pluck('id')->first();

            $tickets = Ticket::where('dept_id', $dept)->where('status','=',"open")->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_bm','=',"1")->count();
            }

            return view('bm.ticketcomment.open_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Open ticket details
    public function bm_detailTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();

            return view('bm.ticketcomment.open_ticket_detail', compact(['ticket', 'comments']));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    //This will help to change Status --> to make Close
    public function bm_closeTickets(Request $request, $ticket_id){
        try{
            $close_ticket = Ticket::findOrFail($ticket_id);
            $close_ticket->status = $request->input('status');

            $close_ticket->update();
            return redirect('/bm/opentickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    public function returnRemaining($id,$status){
        dd('ok');

        try{
             $request=UserRequests::where('provider_id',$id)->where('status',$status)->where('returned_to_hub',0)->where('returned',0)->get();
             $rider=Provider::where('id',$id)->first();
            //  dd($request);
            return view('return.orders.remaining',compact('request','rider'));

        }catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
