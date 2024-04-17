<?php

namespace App\Http\Controllers\resource;

use App\User;
use App\Provider;
use App\RiderLog;
use App\UserRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserApiController;

class bmUserResource extends Controller
{
    protected $UserAPI;

    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = [];
        $count = 0;
        $status = 'all';
        $rides=0;
        $revenue=0;
        
  
            return view('bm.user.index', compact('users','count','status','rides','revenue'));
    }
    public function search(Request $request)
    {
        if(isset($request->search)){
            $users = User::orderBy('created_at' , 'desc')
                        ->Where('email',$request->searchField)
                        ->orWhere('mobile',$request->searchField)
                        ->paginate(10);
            $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
            $revenue = User::sum('wallet_balance');
            $count=[];
            $status=[];
            $index=0;
            foreach($users as $user)
            {
                $count[$index]=UserRequests::where('user_id',$user->id)->count();
                $status[$index]=UserRequests::where('user_id',$user->id)->whereRaw('TIMESTAMPDIFF(day, created_at, CURRENT_TIMESTAMP) <= 7')->count();
                if($status[$index]==0)
                {
                    $status[$index]="In Active";
                }
                else{
                    $status[$index]="Active";
                }

                $index++;
            }
            if(Auth::guard('bm')->check()){
                return view('bm.user.index', compact('users','rides','revenue','count','status'));
            }
           
            
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
        if(Auth::guard('bm')->check()){
            return view('bm.user.create');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            $this->validate($request, [
                'first_name' => 'required|max:255',
                'company_name' => 'required|max:255',
                'email' => 'required|unique:users,email|email|max:255',
                'mobile' => 'required',
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
        try {
            $url = url('/');
            $user = User::findOrFail($id);
            return view('bm.user.edit',compact('user','url'));
         

            
           
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }
    public function order($id)
    {
        try {
            
            Session::forget('s_address');
            Session::forget('d_address');
            Session::forget('service_type');
            Session::forget('s_latitude');
            Session::forget('d_latitude');
            Session::forget('d_longitude');
            Session::forget('s_longitude');

            $services = $this->UserAPI->services();
            // $trips = $this->UserAPI->trips();

            $ip = \Request::getClientIp(true);
            $ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
            $user = User::findOrFail($id);

                return view('bm.user.order',compact('user','services','ip','ip_details'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
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
        $this->validate($request, [
            'first_name' => 'required|max:255',
           'company_name' => 'required|max:255',
            'email' => 'required|unique:users,email,'.$id,
            'mobile' => 'required',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try {

            $user = User::findOrFail($id);

            if($request->hasFile('picture')) {
                //Storage::delete($user->picture);
                $user->picture = URL::to('').'/'.Helper::upload_picture_user($request->file('picture'));
              
            }

            $user->first_name = $request->first_name;
            $user->company_name = $request->company_name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->Agreement=$request->Agreement;
            $user->Business_Person=$request->Business_Person;
            $user->save();
          

            return redirect()->route('bm.user.index')->with('flash_success', 'User Updated Successfully');    
        }

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'User Not Found');
        }
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

            return view('bm.user.index-noedit', compact('requests', 'totalRiders', 'id', 'type'));
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }

    }
    
}
