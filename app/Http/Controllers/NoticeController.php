<?php

namespace App\Http\Controllers;

use App\User;
use App\Notice;
use Illuminate\Http\Request;
use App\Notifications\NoticeNotification;
use App\NextUserDashboard;
use Illuminate\Support\Facades\Notification;


class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::latest()->paginate(100);
    
        return view('admin.notices.index',compact('notices'))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users=NextUserDashboard::all();
        return view('admin.notices.create',compact('users'));
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
            'Heading' => 'required',
            'Description' => 'required',
            'domain_name' => 'required',
        ]);
        if($request->domain_name=='all')
        {
           $users = User::all();
        }
        else{
            $users = User::where('user_type',$request->domain_name)->get();
        }
        Notice::create($request->all());
        $notice = [
            'title'=>$request->Heading,
            'body'=>$request->Description
        ];
        
       
        Notification::send( $users,new NoticeNotification($notice));
     
        return redirect()->route('admin.notices.index')
                        ->with('success','Notice created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return view('admin.notices.show',compact('notice')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        return view('admin.notices.edit',compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $this->validate($request, [
            'Heading' => 'required',
            'Description' => 'required',
        ]);
        
        $notice->update($request->all());
    
        return redirect()->route('admin.notices.index')
                        ->with('success','Notice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
    
        return redirect()->route('admin.notices.index')
                        ->with('success','Notice deleted successfully');
    }
}
