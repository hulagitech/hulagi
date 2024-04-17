<?php

namespace App\Http\Controllers\Resource;

use App\Ticket;
use App\Department;
use App\TicketComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiTicketResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $tickets = Ticket::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->with('recentTicketComment')->get();

            // foreach($tickets as $ticket){
            //     $ticket->noComment = TicketComment::where('ticket_id', $ticket->id)->where('is_read_user','=',"1")->count();
            //     $ticket->comment=TicketComment::where('ticket_id', $ticket->id)->where('is_read_user','=',"1")->orderby('id','asce')->first();
            // }

            $Response = [
                'tickets' => $tickets,
                ];
            return $Response;
        }catch(Exception $e){
            return response()->json([
                'showError' => true,
                'error' => "Error! Please try again."
            ]);
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
        $Response=[
            'depts'=>$depts,
        ];
        return $Response;
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
            $tickets->dept_id =$request->dept_id;
            $tickets->title = $request->title;
            $tickets->description = $request->description;
            $tickets->priority = $request->priority;
        
            $tickets->save();
            return response()->json([
                'success'=> "true",
                'message' => "Ticked Raised Successfully"
            ]);
        }catch (Exception $e){
            return response()->json([
                'showError' => true,
                'error' => "Error! Please try again."
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function ticket_comment($id){
        try{
            $ticket = Ticket::where('id','=',$id)->where('user_id', Auth::user()->id)->first();
            $comments = TicketComment::where('ticket_id', $id)->get();
            $Response=[
                'tickets'=>$ticket,
                'comments'=>$comments,
            ];
            return $Response;
            // return view('user.ticket.detail_comment', compact('ticket', 'comments'));

        } catch (Exception $e){
            return response()->json([
                'showError' => true,
                'error' => "Error! Please try again."
            ]);
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
            return response()->json([
                'success'=> "true",
                'message' => "Comment Post Successfully",
                ]);

            return back()->with('flash_success', 'Comment Post Successfully!');
        }catch (Exception $e){
            return response()->json([
                'showError' => true,
                'error' => "Error! Please try again."
            ]);
        }
    }
}
