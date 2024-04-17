<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Setting;
use \Carbon\Carbon;

use App\User;
use App\Fleet;
use App\Provider;
use App\UserPayment;
use App\ServiceType;
use App\UserRequests;
use App\ProviderService;
use App\UserRequestRating;
use App\UserRequestPayment;
use App\Complaint;
use App\PaymentRequest;
use App\PaymentHistory;
use App\RiderPaymentLog;
use App\Dispatcher;

class FulfillmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->
                            where('created_at','LIKE',date("Y-m-d").'%')->get();
            $pending_rides = UserRequests::where('status','PENDING')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
            $completed_rides = UserRequests::where('status','COMPLETED')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
            $rejected_rides = UserRequests::where('status','REJECTED')->
                            where('created_at','LIKE',date("Y-m-d").'%')->count();
            $picked_rides = UserRequests::where('status','PICKEDUP')->
                                where('created_at','LIKE',date("Y-m-d").'%')->count();
            $accepted_rides = UserRequests::where('status','ACCEPTED')->
                                where('created_at','LIKE',date("Y-m-d").'%')->count();

            return view('fulfillment.dashboard',compact('rides','pending_rides','completed_rides', 'rejected_rides','picked_rides','accepted_rides'));
        }
        catch(\Exception $e){
            return redirect()->route('fulfillment.index')->with('flash_error','Something Went Wrong with Dashboard!');
        }
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
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('fulfillment.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {
        try{

            $this->validate($request,[
                'name' => 'required|max:255',
                'mobile' => 'required|digits_between:6,13',
            ]);

            $user = \Auth::guard('fulfillment')->user();
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->save();

            return redirect()->back()->with('flash_success','Profile Updated');
        }

        catch (\Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('fulfillment.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request)
    {
        try {

            $this->validate($request,[
                'old_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);

            $user = \Auth::guard('fulfillment')->user();

            if(password_verify($request->old_password, $user->password))
            {
                $user->password = bcrypt($request->password);
                $user->save();
                return redirect()->back()->with('flash_success','Password Updated');
            }
        } catch (\Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}
