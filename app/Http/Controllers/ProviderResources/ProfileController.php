<?php

namespace App\Http\Controllers\ProviderResources;

use Auth;
use Setting;

use Storage;

use App\Fleet;
use App\Items;
use Exception;
use App\Provider;
use App\RiderLog;
use Carbon\Carbon;
use App\billUpdate;
use App\UserRequests;
use App\ProviderProfile;
use App\ProviderService;
use App\RiderPaymentLog;
use App\ProviderDocument;
use App\UserRequestPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfileController extends Controller
{
    /**
     * Create a new user instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('provider.api', ['except' => ['show', 'store', 'available', 'location_edit', 'location_update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            Auth::user()->service = ProviderService::where('provider_id',Auth::user()->id)
                                            ->with('service_type')
                                            ->first();
            Auth::user()->fleet = Fleet::find(Auth::user()->fleet);
            Auth::user()->currency = Setting::get('currency', '$');
            Auth::user()->sos = Setting::get('sos_number', '911');
            Auth::user()->chat = Setting::get('chat');
            Auth::user()->social_login_driver = Setting::get('social_login_driver');
            Auth::user()->unit = Setting::get('unit');
            $explodedName=explode(' ',Auth::user()->first_name);
            $shortName='';
            foreach($explodedName as $e){
            	if(strlen($e)>0){
            		$shortName=$shortName.$e[0];
            	}
            }
                $Rides = UserRequests::where('provider_id', Auth::user()->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                Auth::user()->rides_count = $Rides->count();

                Auth::user()->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(\DB::raw(
                        'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                    ))->get();
                $totalOrder = UserRequests::where('provider_id', Auth::user()->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('provider_id', Auth::user()->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', Auth::user()->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'earning')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', Auth::user()->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'payable')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
            Auth::user()->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
            Auth::user()->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
            Auth::user()->payable=Auth::user()->newPayable;
            Auth::user()->profile_name=$shortName;
            $documents = ProviderDocument::where('provider_id', Auth::user()->id)->count();
            Auth::user()->documentStatus=$documents>0?true:false;

            return Auth::user();

        }   catch (Exception $e) {
            return $e->getMessage();
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

        $this->validate($request, [
                'first_name' => 'required|max:255',
                // 'last_name' => 'required|max:255',
                'mobile' => 'required',
                'avatar' => 'mimes:jpeg,bmp,png',
                'language' => 'max:255',
                'address' => 'max:255',
                'address_secondary' => 'max:255',
                'city' => 'max:255',
                'country' => 'max:255',
                'postal_code' => 'max:255',
                'description'   => 'max:1000', 
            ]);

        try {

            $Provider = Auth::user();

            if($request->has('first_name')) 
                $Provider->first_name = $request->first_name;

            // if($request->has('last_name')) 
            //     $Provider->last_name = $request->last_name;

            if ($request->has('mobile'))
                $Provider->mobile = $request->mobile;

            if ($request->hasFile('avatar')) {
                Storage::delete($Provider->avatar);
                $Provider->avatar = $request->avatar->store('provider/profile');
            }

            if($request->has('service_type')) {
                if($Provider->service) {
                    if($Provider->service->service_type_id != $request->service_type) {
                        $Provider->status = 'banned';
                    }
                    //$ProviderService = ProviderService::find(Auth::user()->id);
                    $ProviderService = ProviderService::find($Provider->service->id);
                    $ProviderService->service_type_id = $request->service_type;
                    $ProviderService->service_number = $request->service_number;
                    $ProviderService->service_model = $request->service_model;
                    $ProviderService->save();

                } else {
                    ProviderService::create([
                        'provider_id' => $Provider->id,
                        'service_type_id' => $request->service_type,
                        'service_number' => $request->service_number,
                        'service_model' => $request->service_model,
                    ]);
                    $Provider->status = 'banned';
                }
            }

            if($Provider->profile) {
                $Provider->profile->update([
                        'language' => $request->language ? : $Provider->profile->language,
                        'address' => $request->address ? : $Provider->profile->address,
                        'address_secondary' => $request->address_secondary ? : $Provider->profile->address_secondary,
                        'city' => $request->city ? : $Provider->profile->city,
                        'country' => $request->country ? : $Provider->profile->country,
                        'postal_code' => $request->postal_code ? : $Provider->profile->postal_code,
                        'description' => trim($request->description) ? : $Provider->profile->description,
                    ]);
            } else {
                ProviderProfile::create([
                        'provider_id' => $Provider->id,
                        'language' => $request->language,
                        'address' => $request->address,
                        'address_secondary' => $request->address_secondary,
                        'city' => $request->city,
                        'country' => $request->country,
                        'postal_code' => $request->postal_code,
                        'description' => trim($request->description),
                    ]);
            }


            $Provider->save();

            return redirect(route('provider.profile.index'));
        }

        catch (ModelNotFoundException $e) {
            // (dd($e->getMessage()));
            return response()->json(['error' => 'Driver Not Found!'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $fully = UserRequests::where('provider_id',\Auth::guard('provider')->user()->id)
                    ->with('payment','service_type')
                    ->get();

        $status = ( Auth::guard('provider')->user()->status == 'approved' ) ? 1 : 0;

        return view('provider.profile.profile',compact('fully', 'status' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
                'first_name' => 'required|max:255',
                // 'last_name' => 'required|max:255',
                'mobile' => 'required',
                'avatar' => 'mimes:jpeg,bmp,png',
                'language' => 'max:255',
                'address' => 'max:255',
                'address_secondary' => 'max:255',
                'city' => 'max:255',
                'country' => 'max:255',
                'postal_code' => 'max:255',
                'description'   => 'max:1000', 
            ]);

        try {

            $Provider = Auth::user();

            if($request->has('first_name')) 
                $Provider->first_name = $request->first_name;

           

            if ($request->has('mobile'))
                $Provider->mobile = $request->mobile;

            if ($request->hasFile('avatar')) {
                Storage::delete($Provider->avatar);
                $Provider->avatar = $request->avatar->store('provider/profile');
            }

            if($Provider->profile) {
                $Provider->profile->update([
                        'language' => $request->language ? : $Provider->profile->language,
                        'address' => $request->address ? : $Provider->profile->address,
                        'address_secondary' => $request->address_secondary ? : $Provider->profile->address_secondary,
                        'city' => $request->city ? : $Provider->profile->city,
                        'country' => $request->country ? : $Provider->profile->country,
                        'postal_code' => $request->postal_code ? : $Provider->profile->postal_code,
                        'description' => $request->description ? : $Provider->profile->description,
                    ]);
            } else {
                ProviderProfile::create([
                        'provider_id' => $Provider->id,
                        'language' => $request->language,
                        'address' => $request->address,
                        'address_secondary' => $request->address_secondary,
                        'city' => $request->city,
                        'country' => $request->country,
                        'postal_code' => $request->postal_code,
                        'description' => $request->description,
                    ]);
            }


            // $Provider->save();

            return $Provider;
            
        }

        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Driver Not Found!'], 404);
        }
    }

    /**
     * Update latitude and longitude of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location(Request $request)
    {
        $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

        if($Provider = Auth::user()){

            $Provider->latitude = $request->latitude;
            $Provider->longitude = $request->longitude;
            $Provider->save();

            return response()->json(['message' => 'Location Updated successfully!']);

        } else {
            return response()->json(['error' => 'Driver Not Found!']);
        }
    }

    /**
     * Toggle service availability of the provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function available(Request $request)
    {
        $this->validate($request, [
                'service_status' => 'required|in:active,offline',
            ]);

        $Provider = Auth::user();
        if($Provider->status=='approved'):
            if($Provider->service) {
                $Provider->service->update(['status' => $request->service_status]);
                return response()->json(['msg' => 'You are online','service_status'=>$Provider->service->status,'account_status'=>$Provider->status]);
            } else {
                return response()->json(['msg' => 'You account has not been approved for driving','service_status'=>$Provider->service->status,'account_status'=>$Provider->status]);
            }
        else:
            return response()->json(['msg' => 'You account has not been approved for driving','service_status'=>$Provider->service->status,'account_status'=>$Provider->status]);
        endif;

        //return $Provider;
    }

    /**
     * Update password of the provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $this->validate($request, [
                'password' => 'required|confirmed',
                'password_old' => 'required',
            ]);

        $Provider = Auth::user();

        if(password_verify($request->password_old, $Provider->password))
        {
            $Provider->password = bcrypt($request->password);
            // $Provider->save();

            return response()->json(['message' => 'Password changed successfully!']);
        } else {
            return response()->json(['error' => 'Please enter correct password'], 422);
        }
    }

    /**
     * Show providers daily target.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    /*public function target(Request $request)
    {
       
        try{
 
            $Providers = Provider::all();

            foreach($Providers as $index => $Provider)
            {
                
                if($Provider->id==Auth::user()->id)
                {
                    $Rides = UserRequests::where('provider_id',$Provider->id)
                            ->where('status','<>','CANCELLED')
                            ->get()->pluck('id');

                    $Providers[1]->rides_count = $Rides->count();
    
                    $Providers[1]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                                    ->select(\DB::raw(
                                       'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission' 
                                    ))->get();
                }
                
            }
            
            return response()->json([
                    'rides' => $Rides,
                    'rides_count' => $Providers,
                    'target' => Setting::get('daily_target','0'),
					'user' => Auth::user()->id,
                ]);

            //return view('admin.providers.provider-statement', compact('Providers'))->with('page','Providers Statement');

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }*/
    public function target(Request $request)
    {
        try {
            $Ridesdata = RiderLog::where('rider_logs.complete_id',Auth::user()->id)
                    ->where('rider_logs.payment_received',false)
                    ->where("ur.status","COMPLETED")
                    ->join("user_requests as ur","rider_logs.request_id","ur.id")
                    ->select(["ur.*"])
                    ->get();
            // $Ridesdata = UserRequests::where('provider_id', Auth::user()->id)
            //         ->where('status', 'COMPLETED')
            //         //->where('created_at', '>=', Carbon::today())
            //         ->with('payment', 'service_type')
            //         ->get();
            foreach($Ridesdata as $ride){
                $ride->earning=$ride->amount_customer-30;
                $ride->rec_name=Items::where('request_id',$ride->id)->pluck('rec_name')->first();
            }
                    
            $Rides = UserRequests::where('provider_id',Auth::user()->id)
                            ->where('status','<>','CANCELLED')
                            ->get()->pluck('id');

            $Provider= Provider::findOrFail(Auth::user()->id);
            $totalOrder = UserRequests::where('provider_id', Auth::user()->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('provider_id', Auth::user()->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', Auth::user()->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'earning')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', Auth::user()->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'payable')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
            $Provider->payable=$totalOrder->sum_cod - $totalPayablePaid->paid;
            $todayPayable=UserRequests::where('provider_id',$Provider->id)
                            ->where('status',"COMPLETED")
                            ->where('updated_at','LIKE',date("Y-m-d").'%')
                            ->sum('cod');
            $fareEst=UserRequests::where('provider_id',$Provider->id)
                            ->whereIn('status',["COMPLETED","REJECTED"])
                            ->where('updated_at','LIKE',date("Y-m-d").'%');
            $todayEarning=$fareEst->sum('amount_customer')-30*$fareEst->count();
            return response()->json([
                    'rides' => $Ridesdata,
                    // 'rides_count' => ['overall'=>round($totalEarn,2),'commission'=>round($commision,2)],
                    'target' => Setting::get('daily_target','0'),
                    'user' => Auth::user()->id,
                    'payable'=> $Provider->payable,
                    'earning'=> $Provider->earning,
                    'todayPayable' => $todayPayable,
                    'todayEarning' => $todayEarning
                ]);

        } catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    public function addBill(Request $request){
        $this->validate($request, [
            'bill' 		=> 'required|mimes:jpg,jpeg,png,',
            'remark' => 'Required',
        ]);
        try{
    
            billUpdate::create([
                'url' => $request->bill->store('provider/bill'),
                'provider_id' => Auth::user()->id,
                'Remarks' => $request->remark,
        ]);
        return response()->json(['message' => 'Bill added successfully']);
        }
        catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
     }
}
