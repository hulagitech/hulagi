<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserRequests;
use App\User;
use Auth;
use App\Ticket;
use App\TicketComment;
use App\Department;

class TicketResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $tickets = Ticket::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

            foreach($tickets as $ticket){
                $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_user','=',"1")->count();
            }

            return view('user.ticket.tickets', compact('tickets'));
        }catch(Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depts = Department::orderBy('dept')->get();
        return view('user.ticket.create' ,compact('depts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            // return $request->input('dept_id');
            //$dept = Department::where('dept', '=', 'Customer Service')->first();
            $dept = Department::where('dept', '=', 'Customer Service')->pluck('id')->first();
            
            $tickets = new Ticket();
            $tickets->user_id = Auth::user()->id;
            // $tickets->department = "cs";
            $tickets->dept_id =$request->input('dept_id');
            $tickets->title = $request->input('title');
            $tickets->description = $request->input('description');
            $tickets->priority = $request->input('priority');
        
            $tickets->save();

            return redirect('/ticket')->with('flash_success', 'Ticket Raised Successfully!');
        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
        
    }

    public function ticket_comment($id){
        try{
            $ticket = Ticket::where('id','=',$id)->where('user_id', Auth::user()->id)->first();
            

            $comments = TicketComment::where('ticket_id', $id)->get();
//  dd($comments);
            return view('user.ticket.detail_comment', compact('ticket', 'comments'));

        } catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!!!');
        }
    }



    public function saveTicketComment(Request $request, $ticket_id)
    {
        try{
            $ticketComment = new TicketComment();
            
            $ticketComment->ticket_id = $ticket_id;
            $ticketComment->comment = $request->input('user_comment');
            $ticketComment->authorised_type = "user";
            $ticketComment->is_read_user = '1';

            $ticketComment->save();

            return back()->with('flash_success', 'Comment Post Successfully!');
        }catch (Exception $e){
            return back()->with('flash_error', 'Something went wrong!');
        }
    }
    
    

    
}
