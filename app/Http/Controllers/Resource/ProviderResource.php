<?php

namespace App\Http\Controllers\Resource;

use Setting;
use Storage;
use App\Zones;
use Exception;
use App\Provider;
use App\RiderLog;
use Carbon\Carbon;
use App\ServiceType;
use App\UserRequests;
use App\ProviderService;
use App\RiderPaymentLog;
use App\DispatcherToZone;
use App\Model\RiderInvoice;
use App\UserRequestPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RiderPaymentLogController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProviderResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zoneKtm = Zones::where('zone_name', 'Kathmandu')->pluck('id')->first();
        $title="Inside";
        $AllProviders = Provider::with('service', 'accepted', 'cancelled', 'documents')
            ->where('zone_id', $zoneKtm)
            ->orderBy('id', 'DESC');

        if (request()->has('fleet')) {
            $providers = $AllProviders->where('fleet', $request->fleet)->get();
        } else {
            $providers = $AllProviders->paginate(10);
        }
        foreach ($providers as $index => $Provider) {

                $Rides = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $providers[$index]->rides_count = $Rides->count();

                $providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(\DB::raw(
                        'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                    ))->get();
                $totalOrder = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $Provider->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'earning')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $Provider->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'payable')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $Provider->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
                $Provider->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
            }

        // return view('admin.providers.index', compact('providers', 'documents', 'cancel_rides','rides'));
        if (Auth::guard('dispatcher')->user()) {
            $zones = DispatcherToZone::where('dispatcher_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $collection = $providers->getCollection();
            $filtered = $collection->filter(function ($rider) use ($zones) {
                return in_array($rider->zone_id, $zones);
            });
            $providers->setCollection($filtered);
            $rides = UserRequests::where(function ($query) use ($zones) {
                $query->whereIn('zone1', $zones)->orWhereIn('zone2', $zones);
            })->count();
            return view('dispatcher.providers.index', compact('providers'));
        }
        return view('admin.providers.index', compact('providers','title'));
    }

    public function outer_provider(Request $request)
    {
        $zoneKtm = Zones::where('zone_name', 'Kathmandu')->pluck('id')->first();
        $title="Outside";
        $AllProviders = Provider::with('service', 'accepted', 'cancelled', 'documents')
            ->where('zone_id', '!=', $zoneKtm)
            ->orderBy('id', 'DESC');

        if (request()->has('fleet')) {
            $providers = $AllProviders->where('fleet', $request->fleet)->get();
        } else {
            $providers = $AllProviders->paginate(10);
        }
        foreach ($providers as $index => $Provider) {

                $Rides = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $providers[$index]->rides_count = $Rides->count();

                $providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(\DB::raw(
                        'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                    ))->get();
                $totalOrder = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('provider_id', $Provider->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $Provider->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'earning')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $Provider->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'payable')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $Provider->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
                $Provider->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
            }
       
        // return view('admin.providers.index', compact('providers', 'documents', 'cancel_rides','rides'));
        // if(Auth::guard('dispatcher')->user()){
        //     $zones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
        //     $providers=$providers->filter(function($rider) use($zones){
        //         return in_array($rider->zone_id,$zones);
        //     });
        //     $rides=UserRequests::all()->filter(function($req) use($zones){
        //         return (in_array($req->zone1,$zones) || in_array($req->zone2,$zones));
        //     })->count();
        //     return view('dispatcher.providers.index', compact('providers','cancel_rides','rides'));
        // }

        return view('admin.providers.index', compact('providers', 'title'));
    }

    public function search(Request $request)
    {
        $AllProviders = Provider::with('service', 'accepted', 'cancelled', 'documents')
            ->orderBy('id', 'DESC')
            ->where('first_name', 'LIKE', '%' . $request->searchField . '%')
            ->orWhere('last_name', 'LIKE', '%' . $request->searchField . '%')
            ->orWhere('email', 'LIKE', '%' . $request->searchField . '%')
            ->orWhere('mobile', 'LIKE', '%' . $request->searchField . '%');

        if (request()->has('fleet')) {
            $providers = $AllProviders->where('fleet', $request->fleet)->paginate(100);
        } else {
            $providers = $AllProviders->paginate(100);
        }
        $title="Search";
        $rides = UserRequests::with('user', 'provider', 'payment')->orderBy('id', 'desc')->count();
        $cancel_ride = UserRequests::where('status', 'CANCELLED')->get();
        $cancel_rides = $cancel_ride->where('cancelled_by', 'PROVIDER')->count();
        // return view('admin.providers.index', compact('providers', 'documents', 'cancel_rides','rides'));
        if (Auth::guard('dispatcher')->user()) {
            $zones = DispatcherToZone::where('dispatcher_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $providers = $providers->filter(function ($rider) use ($zones) {
                return in_array($rider->zone_id, $zones);
            });
            $rides = UserRequests::all()->filter(function ($req) use ($zones) {
                return (in_array($req->zone1, $zones) || in_array($req->zone2, $zones));
            })->count();
            return view('dispatcher.providers.index', compact('providers', 'cancel_rides', 'rides'));
        }
        return view('admin.providers.index', compact('providers', 'cancel_rides', 'rides','title'));
    }

    /**
     * Display active listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeDrivers(Request $request)
    {
        $providers = Provider::select([
            'providers.id',
            \DB::raw("CONCAT(providers.first_name, ' ', providers.last_name) AS full_name"),
            'providers.mobile',
            \DB::raw("CASE WHEN ur.status='PICKEDUP' THEN COUNT(ur.status) ELSE 0 END AS totalPicked"),
            \DB::raw("CASE WHEN ur.status='ACCEPTED' THEN COUNT(ur.status) ELSE 0 END AS totalAccepted"),
            \DB::raw("(SUM(ur.amount_customer) - 30) AS totalFare"),
            \DB::raw("SUM(ur.cod) AS totalCod"),
        ])
            ->join('user_requests AS ur', 'ur.provider_id', 'providers.id')
            ->orderBy('ur.updated_at', 'DESC')
            ->groupBy('providers.id')
            ->get();
        $todayTotal = Provider::select([
            'providers.id',
            \DB::raw("CONCAT(providers.first_name, ' ', providers.last_name) AS full_name"),
            'providers.mobile',
            \DB::raw("providers.earning AS totalCod"),
            \DB::raw("providers.payable AS totalFare"),
        ])
            ->join('user_requests AS ur', 'ur.provider_id', 'providers.id')
            ->where('ur.updated_at', 'LIKE', date("Y-m-d") . '%')
            ->groupBy('providers.id')
            ->orderBy('ur.updated_at', 'DESC')
            ->get();
        foreach ($todayTotal as $t) {
            $t->totalPicked = UserRequests::where('provider_id', $t->id)
                ->where('status', "PICKEDUP")
                ->count();
            $t->totalAccepted = UserRequests::where('provider_id', $t->id)
                ->where('status', "ACCEPTED")
                ->count();
            $t->todayCod = UserRequests::where('provider_id', $t->id)
                ->where('status', "COMPLETED")
                ->where('updated_at', 'LIKE', date("Y-m-d") . '%')
                ->sum('cod');
            $fareEst = UserRequests::where('provider_id', $t->id)
                ->whereIn('status', ["COMPLETED", "REJECTED"])
                ->where('updated_at', 'LIKE', date("Y-m-d") . '%');
            $t->todayFare = $fareEst->sum('amount_customer') - 30 * $fareEst->count();
        }
        $activeDrivers = Provider::join('user_requests AS ur', 'ur.provider_id', 'providers.id')
            ->whereRaw("CAST(ur.updated_at AS DATE) = '" . Carbon::now()->format('Y-m-d') . "'")
            ->groupBy('providers.id')
            ->get();

        // $allDates= UserRequests::where('created_at', '>=', Carbon::now()->subMonth())
        //             ->groupBy('date')
        //             ->orderBy('date', 'DESC')
        //             ->get(array(
        //                 DB::raw('Date(created_at) as date')
        //             ));
        // $dates=[];
        // $i=0;
        // foreach($allDates as $d){
        //     $dates[$i]=$d->date;
        //     $i++;
        // }
        return view('admin.providers.active-drivers', compact('providers', 'activeDrivers', 'todayTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $services = ServiceType::all();
        $zones = Zones::all();

        return view('admin.providers.create', compact('services', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at Admin.com');
        }

        $this->validate($request, [
            'first_name' => 'required|max:255',
            //'last_name'     => 'required|max:255',
            'email' => 'required|unique:providers,email|email|max:255',
            'mobile' => 'digits_between:6,13',
            //'avatar'         => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
            'type' => 'required',
            'service_type' => 'required',
            'service_number' => 'required',
            'service_model' => 'required',
            'zone_id' => 'required|exists:zones,id',
        ]);

        try {

            $provider = $request->all();

            $provider['password'] = bcrypt($request->password);
            if ($request->hasFile('avatar')) {
                $provider['avatar'] = $request->avatar->store('provider/profile');
            }

            $Provider = Provider::create($provider);

            if ($Provider) {

                $provider_service = ProviderService::create([
                    'provider_id' => $Provider->id,
                    'status' => 'offline',
                    'service_type_id' => $provider['service_type'],
                    'service_number' => $provider['service_number'],
                    'service_model' => $provider['service_model'],
                ]);
            }
            return back()->with('flash_success', 'Driver Details Saved Successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Driver Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $provider = Provider::findOrFail($id);
            return view('admin.providers.provider-details', compact('provider'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $provider = Provider::with('service')
                ->whereHas('service', function ($query) use ($id) {
                    $query->where('provider_id', $id);
                })->where('id', $id)->first();

            if (!$provider) {
                throw new Exception('Driver Not Found!');
            }

            $services = ServiceType::all();
            $zones = Zones::all();

            //$provder_service = ProviderService::where('');
            return view('admin.providers.edit', compact('provider', 'services', 'zones'));
        } catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
            //return back()->with( $e->getMessage() );
        }
    }

    public function outer_edit($id)
    {
        try {

            $provider = Provider::with('service')
                ->whereHas('service', function ($query) use ($id) {
                    $query->where('provider_id', $id);
                })->where('id', $id)->first();

            if (!$provider) {
                throw new Exception('Driver Not Found!');
            }

            $services = ServiceType::all();
            $zones = Zones::all();

            //$provder_service = ProviderService::where('');
            return view('admin.providers.edit_outer', compact('provider', 'services', 'zones'));
        } catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
            //return back()->with( $e->getMessage() );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request, [
            'first_name' => 'required|max:255',
            //'last_name' => 'required|max:255',
            'mobile' => 'digits_between:6,17',
            //'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'type' => 'required',
            'service_type' => 'required',
            'service_number' => 'required',
            'email' => 'required',
            //'password'    => 'confirmed|min:6',
            'service_number' => 'required',
            'service_model' => 'required',
            'zone_id' => 'required|exists:zones,id',
        ]);

        try {

            $provider = Provider::findOrFail($id);
            if (!$provider) {
                throw new Exception('Driver Not Found');
            }

            $provider_service = ProviderService::where('provider_id', $id)->first();
            if (!$provider_service) {
                throw new Exception('Driver Service Not Found');
            }

            if ($request->hasFile('avatar')) {
                if ($provider->avatar) {
                    Storage::delete($provider->avatar);
                }
                $provider->avatar = $request->avatar->store('provider/profile');
            }

            $provider->first_name = $request->first_name;
            //$provider->last_name = $request->last_name;
            $provider->mobile = $request->mobile;
            $provider->email = $request->email;
            $provider->type = $request->type;
            $provider->zone_id = $request->zone_id;
            if ($request->password != "") {
                $provider->password = bcrypt($request->password);
            }
            $provider->update();
            // $provider->save();

            $provider_service->service_type_id = $request->service_type;
            $provider_service->service_number = $request->service_number;
            $provider_service->service_model = $request->service_model;

            $provider_service->update();
            // $provider_service->save();

            if ($request->op) {
                return redirect()->route('admin.provider.outerprovider')->with('flash_success', 'Driver Updated Successfully');
            } else {
                return redirect()->route('admin.provider.index')->with('flash_success', 'Driver Updated Successfully');
            }
        } catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    public function outer_update(Request $request, $id)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request, [
            'first_name' => 'required|max:255',
            //'last_name' => 'required|max:255',
            'mobile' => 'digits_between:6,17',
            //'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'type' => 'required',
            'service_type' => 'required',
            'service_number' => 'required',
            'email' => 'required',
            //'password'    => 'confirmed|min:6',
            'service_number' => 'required',
            'service_model' => 'required',
            'zone_id' => 'required|exists:zones,id',
        ]);

        try {

            $provider = Provider::findOrFail($id);
            if (!$provider) {
                throw new Exception('Driver Not Found');
            }

            $provider_service = ProviderService::where('provider_id', $id)->first();
            if (!$provider_service) {
                throw new Exception('Driver Service Not Found');
            }

            if ($request->hasFile('avatar')) {
                if ($provider->avatar) {
                    Storage::delete($provider->avatar);
                }
                $provider->avatar = $request->avatar->store('provider/profile');
            }

            $provider->first_name = $request->first_name;
            //$provider->last_name = $request->last_name;
            $provider->mobile = $request->mobile;
            $provider->email = $request->email;
            $provider->type = $request->type;
            $provider->zone_id = $request->zone_id;
            if ($request->password != "") {
                $provider->password = bcrypt($request->password);
            }
            $provider->update();
            // $provider->save();

            $provider_service->service_type_id = $request->service_type;
            $provider_service->service_number = $request->service_number;
            $provider_service->service_model = $request->service_model;

            $provider_service->update();
            // $provider_service->save();

            return redirect()->route('admin.provider.outerprovider')->with('flash_success', 'Driver Updated Successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        try {

            Provider::find($id)->delete();

            ProviderService::where('provider_id', $id)->delete();
            DB::table('provider_devices')->where('provider_id', $id)->delete();

            $provider_documents = DB::table('provider_documents')->where('provider_id', $id)->get();

            if ($provider_documents) {
            }

            DB::table('provider_profiles')->where('provider_id', $id)->delete();
            DB::table('provider_zone')->where('driver_id', $id)->delete();

            return back()->with('message', 'Driver deleted successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Driver Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        try {
            $Provider = Provider::findOrFail($id);
            if($Provider->settle==1){
                return back()->with('flash_error', 'Driver Has Been settled Please unsettle this rider to unbanned');
            }
            if ($Provider->service) {
                $Provider->update(['status' => 'approved']);
                return back()->with('flash_success', "Driver Approved");
            } else {
                return redirect()->route('admin.provider.document.index', $id)->with('flash_error', "Driver has not been assigned a vehicle!");
            }
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', "Something went wrong! Please try again later.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        Provider::where('id', $id)->update(['status' => 'banned']);
        return back()->with('flash_success', "Driver Disapproved");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function request($id)
    {

        try {
            $totalRiders = Provider::select("id", "first_name")->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            $requests = UserRequests::where('user_requests.provider_id', $id)->RequestHistory()->get();
            $type = "rider";
            if (Auth::guard('dispatcher')->user() ||Auth::guard('bm')->user()) {
                $zones = DispatcherToZone::where('dispatcher_id', Auth::user()->id)->pluck('zone_id')->toArray();
                $totalRiders = $totalRiders->filter(function ($rider) use ($zones) {
                    return in_array($rider->zone_id, $zones);
                });
                $totalrequest = UserRequests::all()->filter(function ($req) use ($zones) {
                    return (in_array($req->zone1, $zones) || in_array($req->zone2, $zones));
                })->count();
                $provider = Provider::where('id',$id)->get();
                if(Auth::guard('bm')->user())
                {
                    return view('bm.request-backup.index-noedit', compact(['requests','provider','totalrequest','totalpaidamount','totalRiders', 'id', 'type']));   
                }

                return view('dispatcher.request-backup.index-noedit', compact(['requests','provider','totalrequest','totalpaidamount','totalRiders', 'id', 'type']));
            }
            return view('admin.request.index-noedit', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'id', 'type']));
        } catch (Exception $e) {
            if (Auth::guard('dispatcher')->user()) {
                return back()->with('flash_error', 'Something Went Wrong!');
            }
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function searchRiderDetail(Request $request, $id)
    {
        try {
            $totalRiders = Provider::select("id", "first_name")->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            //return $request->status;
            if($request->status=='All')
            {
                $requests = UserRequests::where('user_requests.provider_id', $id)->RequestHistory()->get();
 
            }
            
            else{
                $requests = UserRequests::where('user_requests.provider_id', $id)
                // ->where('created_at', '>=', $request->from_date)
                // ->where('created_at', '<=', $request->to_date)
                
                ->where('status', $request->status)
                ->RequestHistory()
                ->get();
 
            }
            $type = "rider";
            if (Auth::guard('dispatcher')->user() ||Auth::guard('bm')->user()) {
                $zones = DispatcherToZone::where('dispatcher_id', Auth::user()->id)->pluck('zone_id')->toArray();
                $totalRiders = $totalRiders->filter(function ($rider) use ($zones) {
                    return in_array($rider->zone_id, $zones);
                });
                $totalrequest = UserRequests::all()->filter(function ($req) use ($zones) {
                    return (in_array($req->zone1, $zones) || in_array($req->zone2, $zones));
                })->count();
                //added for request
                //return $request->status;
               
                
                $provider = Provider::where('id',$id)->get();
                if(Auth::guard('bm')->user()){
                    return view('bm.request-backup.index-noedit', compact(['requests','provider','totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'id', 'type']));
                }
                return view('dispatcher.request-backup.index-noedit', compact(['requests','provider','totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'id', 'type']));
            }
            return view('admin.request.index-noedit', compact(['requests', 'totalrequest', 'totalcanceltrip', 'totalpaidamount', 'totalRiders', 'id', 'type']));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    /**
     * account statements.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    
    public function statement($id)
    {

        try {
            $logs = RiderPaymentLog::where('provider_id', $id)->get();
            $rides = UserRequests::where('provider_id', $id)->count();
            $Provider = Provider::find($id);
            return view('admin.providers.statement', compact('logs', 'rides', 'Provider'))
                ->with('page', "Payment Logs ");
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }

        //     $requests = UserRequests::where('provider_id', $id)
        //         ->where('status', 'COMPLETED')
        //         ->with('payment')
        //         ->get();

        //     $rides = UserRequests::where('provider_id', $id)->with('payment')->orderBy('id', 'desc')->paginate(10);
        //     $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('provider_id', $id)->count();
        //     $Provider = Provider::find($id);
        //     $revenue = UserRequestPayment::whereHas('request', function ($query) use ($id) {
        //         $query->where('provider_id', $id);
        //     })->select(\DB::raw(
        //         'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
        //     ))->get();

        //     $revenues = UserRequestPayment::sum('total');
        //     $commision = UserRequestPayment::sum('commision');
        //     $Joined = $Provider->created_at ? '- Joined ' . $Provider->created_at->diffForHumans() : '';

        //     return view('admin.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'revenues', 'commision'))
        //         ->with('page', $Provider->first_name . "'s Overall Statement " . $Joined);
        // } catch (Exception $e) {
        //     return back()->with('flash_error', 'Something Went Wrong!');
        // }
    }

    public function inbound($id)
    {

        try {
            $rides = UserRequests::where('provider_id', $id)->where('status', 'PICKEDUP')->with('payment', 'user')->orderBy('id', 'desc')->paginate(10);
            $Provider = Provider::find($id);
            $Joined = $Provider->created_at ? '- Joined ' . $Provider->created_at->diffForHumans() : '';
            if (Auth::guard('dispatcher')->user()) {
                return view('dispatcher.providers.inbound', compact('rides'))
                    ->with('page', $Provider->first_name . "'s Overall Statement " . $Joined);
            }
            return view('admin.providers.inbound', compact('rides'))
                ->with('page', $Provider->first_name . "'s Overall Statement " . $Joined);
        } catch (Exception $e) {
            if (Auth::guard('dispatcher')->user()) {
                return back()->with('flash_error', 'Something Went Wrong!');
            }
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function today(Request $request,$id)
    {
        try {
            $rides = UserRequests::where('provider_id', $id)->where('status', 'PICKEDUP')->with('payment', 'user')->orderBy('id', 'desc')->paginate(10);
            $Provider = Provider::find($id);
            $Joined = $Provider->created_at ? '- Joined ' . $Provider->created_at->diffForHumans() : 'completed_rides';
            if (Auth::guard('dispatcher')->user() || Auth::guard('bm')->user()) {
                if ($request->has('from_date')) {
           
                    $completed_rides = RiderLog::
                    whereBetween('completed_date',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->where('complete_id',$id)->get();
                    $sum=UserRequests::whereBetween('updated_at',array($request->from_date. " 00:00:00",$request->to_date. " 23:59:59"))->where('provider_id',$id)
                    ->where('status','COMPLETED')
                    ->sum('cod');
                }
                else{
                    $completed_rides = RiderLog::whereDate('completed_date', Carbon::today())->where('complete_id',$id)->get();
                    $sum=UserRequests::whereDate('updated_at', Carbon::today())->where('provider_id',$id)
                    ->where('status','COMPLETED')
                    ->sum('cod');
        
                }
                if(Auth::guard('dispatcher')->user()){
                    return view('dispatcher.providers.today', compact('rides','completed_rides','id','sum'))
                    ->with('page', $Provider->first_name . "'s Overall Statement " . $Joined);
                }
                if(Auth::guard('bm')->user()){
                    return view('bm.providers.today', compact('rides','completed_rides','id','sum'))
                    ->with('page', $Provider->first_name . "'s Overall Statement " . $Joined);
                }
                
                
            }
            return view('admin.providers.today', compact('rides'))
                ->with('page', $Provider->first_name . "'s Overall Statement " . $Joined);
        } catch (Exception $e) {
            if (Auth::guard('dispatcher')->user()) {
                return back()->with('flash_error', 'Something Went Wrong!');
            }
            if (Auth::guard('bm')->user()) {
                return back()->with('flash_error', 'Something Went Wrong!');
            }
            
            return back()->with('flash_error', 'Something Went Wrong!');
        }
        
       
    }
    public function payment($id)
    {
        try {
            if (Auth::guard('dispatcher')->user()) {
                $logs = RiderPaymentLog::where('provider_id', $id)->get();
                $rides = UserRequests::where('provider_id', $id)->count();
                $Provider = Provider::find($id);
                return view('dispatcher.providers.payment', compact('logs', 'rides', 'Provider'))
                    ->with('page', "Payment Logs ");
                }
            if(Auth::guard('bm')->user()){
                $logs = RiderPaymentLog::where('provider_id', $id)->get();
                $rides = UserRequests::where('provider_id', $id)->count();
                $Provider = Provider::find($id);
                return view('bm.providers.payment', compact('logs', 'rides', 'Provider'))
                    ->with('page', "Payment Logs ");
            }  
        }
        catch (Exception $e) {
            if (Auth::guard('dispatcher')->user()) {
                return back()->with('flash_error', 'Something Went Wrong!');
            }
            if (Auth::guard('bm')->user()) {
                return back()->with('flash_error', 'Something Went Wrong!');
            }
        }
    }
   

    public function log($id)
    {
      
        try {
            //show different based on account or admin
            $url = url()->current();
            $split = explode("/", $url);
            $role = $split[count($split) - 4];
            

            if ($role == "account") {
                $logs = RiderLog::where('rider_logs.complete_id', $id)
                    ->where('rider_logs.payment_received', '0')
                    ->where("ur.status", "COMPLETED")
                    ->join("user_requests as ur", "rider_logs.request_id", "ur.id")
                    ->select(["rider_logs.*"])
                    ->get();
            } else {
                $logs = RiderLog::where('rider_logs.complete_id', $id)
                    ->where("ur.status", "COMPLETED")
                    ->join("user_requests as ur", "rider_logs.request_id", "ur.id")
                    ->select(["rider_logs.*"])
                    ->get();
            }
            
            $logToday = RiderLog::where(function ($query) use ($id) {
                $query->where('pickup_id', $id)
                    ->orWhere('complete_id', $id);
            })->where(function ($query) {
                $query->where('created_at', 'LIKE', date('Y-m-d') . '%')
                    ->orWhere('updated_at', 'LIKE', date('Y-m-d') . '%');
            });
            
            $countToday = $logToday->count();
            $totalLog=UserRequests::where('provider_id', $id)->get();
            $process = UserRequests::where('provider_id', $id)->where('status', ['DELIVERING', 'ASSIGNED','ACCEPTED'])->count();
            $scheduled = UserRequests::where('provider_id', $id)->where('status', 'SCHEDULED')->count();
            $rejected = UserRequests::where('provider_id', $id)
            ->whereIn('status', ['REJECTED', 'CANCELLED'])
            ->count();
            $returnRemaining = UserRequests::where('provider_id', $id)
            ->whereIn('status', ['REJECTED', 'CANCELLED'])->where('returned_to_hub', 0)
            ->count();
            $returnOrder = UserRequests::where('provider_id', $id)
            ->whereIn('status', ['REJECTED', 'CANCELLED'])->where('returned_to_hub', 1)->where('returned', 1)
            ->count();
            $pickedup=0;
            $completed=UserRequests::where('provider_id', $id)->where('status', 'COMPLETED')->count();
            

            $totalPayable = Provider::find($id, ['payable']);
            $Providers = Provider::where('status', 'approved')
                    ->take(200)->get();
            

                $Rides = UserRequests::where('provider_id', $id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $Providers->rides_count = $Rides->count();

                $Providers->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(\DB::raw(
                        'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                    ))->get();
                $totalOrder = UserRequests::where('provider_id', $id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(cod) as sum_cod"),
                        \DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('provider_id', $id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'earning')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('provider_id', $id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->where('transaction_type', 'payable')
                    ->select([
                        \DB::raw("SUM(amount) as paid"),
                    ])
                    ->first();
                $cityCargo =UserRequests::where('provider_id', $id)
                      ->where('status', 'COMPLETED')
                      ->where('created_at', '>=', '2020-10-15')
                      ->wherehas('user',function($q){
                          $q->where('user_type','!=',env('APP_NAME', 'Hulagi'));
                      })
                    ->select([\DB::raw("SUM(cod) as sum_cod")])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $Providers->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
                $Providers->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
                $Providers->cityCargo=$cityCargo->sum_cod;
            
            return view($role . '.providers.provider-logs', compact(
                'logs',
                'pickedup',
                'completed',
                'countToday',
                'process',
                'scheduled',
                'rejected',
                'role',
                'totalPayable',
                'Providers',
                'totalLog',
                'returnRemaining',
                'returnOrder'
            ));
        } catch (Exception $e) {
            return $e->getMessage();
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function activeProvider(){
        $Providers = Provider::wherehas('activeProvider', function($q){
                        $q->whereRaw('TIMESTAMPDIFF(day, updated_at, CURRENT_TIMESTAMP) <= 7');
                    })->get();
        foreach($Providers as $provider){     
           $Rides = UserRequests::where('provider_id', $provider->id)
                        ->where('status', '<>', 'CANCELLED')
                        ->get()->pluck('id');

            $provider->rides_count = $Rides->count();

            $provider->payment = UserRequestPayment::whereIn('request_id', $Rides)
                ->select(\DB::raw(
                    'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
                ))->get();
            $totalOrder = UserRequests::where('provider_id', $provider->id)
                ->where('status', 'COMPLETED')
                ->where('created_at', '>=', '2020-10-15')
                ->select([\DB::raw("SUM(cod) as sum_cod"),
                    \DB::raw("SUM(amount_customer) as sum_fare")])
                ->first();
            $totalReject = UserRequests::where('provider_id', $provider->id)
                ->where('status', 'REJECTED')
                ->where('created_at', '>=', '2020-10-15')
                ->select([\DB::raw("SUM(amount_customer) as sum_fare")])
                ->first();
            $totalEarningPaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                ->where('provider_id', $provider->id)
                ->where('created_at', '>=', '2020-10-15')
                ->where('transaction_type', 'earning')
                ->select([
                    \DB::raw("SUM(amount) as paid"),
                ])
                ->first();
            $totalPayablePaid = RiderPaymentLog::where('remarks', 'NOT LIKE', '%adjustment%')
                ->where('provider_id', $provider->id)
                ->where('created_at', '>=', '2020-10-15')
                ->where('transaction_type', 'payable')
                ->select([
                    \DB::raw("SUM(amount) as paid"),
                ])
                ->first();
            //paid is negative so, we add it which is same as subtraction
            $provider->newEarning = $totalOrder->sum_fare + $totalReject->sum_fare - $totalEarningPaid->paid;
            $provider->newPayable = $totalOrder->sum_cod - $totalPayablePaid->paid;
        }
        // return $activeProvider;
        return view('account.providers.active-providers', compact('Providers'));
    }

    public function updateLog(Request $request)
    {
        // return response()->json($request);
        $this->validate(
            $request,
            [
                'log_id' => 'required',
            ],
            ['log_id.required' => 'Please Select at least one log']
        );
        try {
            // return response()->json($request);
            //get invoice_no
            $last_order = RiderInvoice::latest()->first();

            if ($last_order) {
                $expNum = explode('-', $last_order->invoice_no);
                //    return $expNum;
                //check first day in a year
                if ($expNum[0] != Carbon::now()->firstOfYear()->format('Y')) {
                    $nextBillNumber = date('Y') . '-0001';
                } else {
                    //increase 1 with last invoice number
                    $nextBillNumber = $expNum[0] . '-' . (str_pad($expNum[1] + 1, 4, '0', STR_PAD_LEFT));
                }
            } else {
                $nextBillNumber = date('Y') . '-0001';
            }
            switch ($request->submit) {
                case 'pay':
                    // return $request->pay_remarks;
                    DB::beginTransaction();
                    $invoice = new RiderInvoice();
                    $invoice->invoice_no = $nextBillNumber;
                    $invoice->paid_amount = $request->paid;
                    $invoice->provider_id = $request->provider_id;
                    $invoice->issued_by = Auth::user()->id;
                    $invoice->save();

                    foreach ($request->log_id as $log) {
                        $rider_log = RiderLog::find($log);
                        $rider_log->payment_received = true;
                        $rider_log->invoice_id = $invoice->id;
                        $rider_log->complete_remarks = $request->pay_remarks ? $request->pay_remarks : "Received by account";
                        $rider_log->save();
                    }
                    $provider = Provider::find($request->provider_id);
                    // return $provider;
                    $request->paid = $request->paid ? $request->paid : 0;
                    // return $request->paid;
                    $provider->payable -= $request->paid;
                    $provider->save();
                    $logRequest = new Request();
                    $logRequest->replace([
                        'provider_id' => $provider->id,
                        'transaction_type' => "payable",
                        'amount' => $request->paid,
                        'remarks' => $request->pay_remarks ? $request->pay_remarks : "Received by account",
                    ]);
                    $riderLog = new RiderPaymentLogController;
                    $riderLog->create($logRequest);
                    DB::commit();
                    session()->flash('flash_success', 'Payment Done Sucessfully');
                    return redirect()->route('account.provider.riderPaymentslip', $invoice->id);
                    break;
                case 'settle':
                    DB::beginTransaction();
                    $invoice = new RiderInvoice();
                    $invoice->invoice_no = $nextBillNumber;
                    $invoice->paid_amount = $request->paid;
                    $invoice->provider_id = $request->provider_id;
                    $invoice->issued_by = Auth::user()->id;
                    $invoice->save();
                    foreach ($request->log_id as $log) {
                        $rider_log = RiderLog::find($log);
                        $rider_log->payment_received = true;
                        $rider_log->invoice_id = $invoice->id;
                        $rider_log->complete_remarks = $request->pay_remarks ? $request->pay_remarks : "Received by account";
                        $rider_log->save();
                    }
                    DB::commit();
                    session()->flash('flash_success', 'Payment Done Sucessfully');
                    return redirect()->route('account.provider.riderPaymentslip', $invoice->id);
                    break;
            }

        } catch (Exception $e) {
            DB::rollback();
            return back()->with('flash_error', $e->getMessage());
        }
    }

    public function Accountstatement($id)
    {

        try {

            $requests = UserRequests::where('provider_id', $id)
                ->where('status', 'COMPLETED')
                ->get();

            $rides = UserRequests::where('provider_id', $id)->orderBy('id', 'desc')->get();
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('provider_id', $id)->count();
            $Provider = Provider::find($id);
            $revenue = UserRequestPayment::whereHas('request', function ($query) use ($id) {
                $query->where('provider_id', $id);
            })->select(\DB::raw(
                'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'
            ))->get();

            $Joined = $Provider->created_at ? '- Joined ' . $Provider->created_at->diffForHumans() : '';

            return view('account.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'Provider'))
                ->with('page', $Provider->first_name . "'s Overall Statement " . $Joined);
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function invoiceSlip($id)
    {
        try {
            $payments = RiderInvoice::find($id);
            return view('account.providers.paymentSlip', compact('payments'));
        } catch (\Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }
}
