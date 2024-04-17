<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
use Exception;

use App\Ticket;
use App\TicketComment;
use App\Department;

class AdminTicketController extends Controller
{
    // Display a listing of the Today's Ticket.
    public function todayTickets(){
        try{
            //$tickets = Ticket::where('department','=','admin')->where('status','=',"open")->whereDate('created_at', DB::raw('CURDATE()'))->orderBy('created_at', 'DESC')->get();

            $tickets = Ticket:: where('status','=',"open")->whereDate('created_at', DB::raw('CURDATE()'))->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_admin','=',"1")->count();
            }

            return view('admin.ticket.today_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Today's ticket comment
    public function today_commentTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();

            return view('admin.ticket.today_ticket_detail', compact('ticket', 'comments'));

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
            return redirect('/admin/todaytickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    public function replyTickets(Request $request, $ticket_id){
        try{
            $ticketComment = new TicketComment();
            
            $ticketComment->ticket_id = $ticket_id;
            $ticketComment->comment = $request->input('comment');
            $ticketComment->authorised_type = "admin";
            $ticketComment->is_read_admin = '0';

            $ticketComment->save();
            return back()->with('flash_success', 'Your reply has send successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }

    // This help to get all open tickets which is related to admin only.
    public function openTickets(){
        
        try{

            $tickets = Ticket::where('status','=',"open")->orderBy('created_at', 'DESC')->paginate(100);

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_admin','=',"1")->count();
            }

            return view('admin.ticket.open_tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    // Open ticket details
    public function detailTickets($id){
        try{
            $ticket = Ticket::where('id','=',$id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();

            return view('admin.ticket.open_ticket_detail', compact('ticket', 'comments'));

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
            return redirect('/admin/opentickets')->with('flash_success', 'Comment Closed Successfully!');

        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
}
