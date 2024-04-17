<?php

namespace App\Http\Controllers\Resource;
use URL;

use Setting;
use App\User;
use Exception;
use App\Provider;
use App\RiderLog;
use Carbon\Carbon;
use App\UserRequests;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Rules\email_validator;
use App\Rules\phone_validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('Settlement')->orderBy('created_at' , 'desc')->paginate(20);
        foreach($users as $user)
        {
            $user->total=UserRequests::where('user_id',$user->id)->count();
            $user->status=UserRequests::where('user_id',$user->id)->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) <= 7')->count();

        }
    
        // $count=UserRequests::wherehas('user')->select(array(DB::raw('count(*) as count')))->groupby('user_id')->get();
        // return $count;
        $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
        $revenue = User::sum('wallet_balance');
        return view('admin.users.index', compact('users','rides','revenue',));
    }

    public function search(Request $request)
    {
        if(isset($request->search)){
            $users = User::orderBy('created_at' , 'desc')
                        ->where('first_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('last_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('company_name','LIKE','%'.$request->searchField.'%')
                        ->orWhere('email','LIKE','%'.$request->searchField.'%')
                        ->orWhere('mobile','LIKE','%'.$request->searchField.'%')
                        ->orWhere('Agreement','LIKE','%'.$request->searchField.'%')
                        ->paginate(50);
            foreach($users as $user)
                        {
                           $user->status=UserRequests::where('user_id',$user->id)->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) <= 7')->count();
                           $user->total=UserRequests::where('user_id',$user->id)->count();
                        }
            $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
            $revenue = User::sum('wallet_balance');
            return view('admin.users.index', compact('users','rides','revenue',));
            
            // if($request->has('from_date') && $request->has('to_date')){
            //     $users = User::orderBy('created_at', 'desc')
            //             ->where('created_at','>=',$request->from_date)
            //             ->where('created_at','<=',$request->to_date)
            //             ->get();
            //     $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
            //     $revenue = User::sum('wallet_balance');
            //     return view('admin.users.index', compact('users','rides','revenue'));
            // }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'first_name' => 'required|max:255',
           // 'last_name' => 'required|max:255',
           'mobile' =>  ['required', new phone_validator],
            'email' => ['required', 'email', new email_validator],
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
        ]);

        try{

            $user = $request->all();

            $user['payment_mode'] = 'CASH';
            $user['password'] = bcrypt($request->password);
            if($request->hasFile('picture')) {
                
             $user['picture'] = URL::to('').'/'.Helper::upload_picture_user($request->file('picture'));
             
            }

            $user = User::create($user);

            return back()->with('flash_success','User Details Saved Successfully');

        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.user-details', compact('user'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $url = url('/');
            $user = User::findOrFail($id);
            return view('admin.users.edit',compact('user','url'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
        //    'company_name' => 'required|max:255',
            'email' => 'required',
            'mobile' => 'required',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);
        if($request->Agreement=='YES' && $request->remarks=='')
        {
            return back()->with('flash_error','Please Enter Remarks');
        }

        try {

            $user = User::findOrFail($id);

            if($request->hasFile('picture')) {
                //Storage::delete($user->picture);
                $user->picture = $request->picture->store('user/profile');
              
            }

            $user->first_name = $request->first_name;
            $user->company_name = $request->company_name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->Agreement=$request->Agreement;
            if($user->Agreement=='YES'){
                $user->agreement_date=date('Y-m-d');
                $user->remarks=$request->remarks;
            }
            $user->Business_Person=$request->Business_Person;
            $user->discount_percentage=$request->discount;
            $user->save();

            return redirect()->route('admin.user.index')->with('flash_success', 'User Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }
        
        try {

            User::find($id)->delete();
            return back()->with('message', 'User deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function request($id){

        try{

            $requests = UserRequests::where('user_requests.user_id',$id)
                    ->RequestHistory()
                    ->get();
            foreach($requests as $request){
                $request->log=RiderLog::where('request_id',$request->id)->first();
            }
            $totalRiders=Provider::select("id","first_name")->get();
            $type="user";

            return view('admin.request.index-noedit', compact('requests', 'totalRiders', 'id', 'type'));
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }

    }

    public function searchDetail(Request $request, $id)
    {
        try{
            // $requests = UserRequests::where(function($query) use ($request){
            //             $query->where('created_at', '>=', $request->from_date)
            //             ->where('created_at', '<=', $request->to_date);
            //         })
            // $requests = UserRequests::where('user_requests.user_id',$id)
            //         ->where('created_at', '>=', $request->from_date)
            //         // ->where('created_at', '<=', $request->to_date->addDays(1))
            //         ->where('created_at', '<=', $request->to_date)
            //         ->RequestHistory()
            //         ->get();
            $requests = UserRequests::where('user_requests.user_id',$id)
                    ->where('created_at', '>=', $request->from_date)
                    ->where('created_at', '<=', $request->to_date)
                    // ->filter(function($item) {
                    //     if (Carbon::now->between($item->from, $item->to) {
                    //       return $item;
                    //     }
                        
                    ->RequestHistory()
                    ->get();
            foreach($requests as $request){
                $request->log=RiderLog::where('request_id',$request->id)->first();
            }
            $totalRiders=Provider::select("id","first_name")->get();
            $type="user";

            return view('admin.request.index-noedit', compact('requests', 'totalRiders', 'id','type'));
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function userChart($id){
        try{
        $user=User::findorFail($id);
        // dd($user);
         $stats = UserRequests::where('user_id', $id)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ])->tojson();
        return view('admin.users.chart', compact('stats','user'));
        }
        catch(Exception $e){
            return $e->getMessage();
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

}
