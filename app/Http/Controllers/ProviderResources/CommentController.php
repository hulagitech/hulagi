<?php

namespace App\Http\Controllers\ProviderResources;

use Exception;
use App\Comment;
use App\UserRequests;
use App\Model\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('provider.api');
    }

    public function index()
    {
        //
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
        // return "hi";
        try{
            $this->validate($request,[
                'request_id' => 'required|exists:user_requests,id',
                'comment' => 'required'
            ]);
    
            $comment = Comment::create([
                'request_id' => $request->request_id,
                'comments' => $request->comment. ' (' .Auth::user()->first_name. ')',
                'authorised_type' => 'rider',
                'authorised_id' => Auth::user()->id,
                'is_read_rider' => 1
            ]);
            $comment = UserRequests::findOrFail($request->request_id);
            $comment->comment_status = 1;
            $comment->update();
            // notify

            $noti = new Notification;
            $token= $comment->user->device_key;
            // return $token;
            $title = 'Comment Received';
            $body = 'New comment received for your order of '.$comment->item->rec_name.', '.$comment->d_address;
            $noti->toSingleDevice($token,$title,$body,null,null,$comment->user->id,$comment->id);
            return response()->json([
                'success' => true,
                'comment' => $comment
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
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
        $comments = Comment::where('request_id','=',$id)->orderBy('created_at', 'ASC')->get();
        return response()->json([
            'comments' => $comments
        ]);
    }

    public function unread()
    {
        $id=Auth::user()->id;
        $comments = Comment::where('authorised_type','=','rider')
                        ->where('authorised_id',$id)
                        ->where('is_read_rider','0')
                        ->groupBy('request_id')
                        ->pluck('request_id');
        return response()->json([
            'request_id' => $comments
        ]);
    }

    public function allRead($id)
    {
        $setRead = Comment::where('request_id','=',$id)->where('is_read_rider',0)->update([
            'is_read_rider' => 1
        ]);
        return response()->json([
            'success' => $setRead
        ]);
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
}
