<?php

namespace App\Http\Controllers\resource;

use Setting;
use App\Zones;
use App\Provider;
use App\Fare;
use App\ServiceType;
use App\UserRequests;
use App\ProviderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SupportProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $AllProviders = Provider::with('service','accepted','cancelled', 'documents')
                    ->orderBy('id', 'DESC');
		
        if(request()->has('fleet')){
            $providers = $AllProviders->where('fleet',$request->fleet)->get();
        }else{
            $providers = $AllProviders->paginate(100);
        }
        $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
		$cancel_ride = UserRequests::where('status','CANCELLED')->paginate(200);
        $cancel_rides = $cancel_ride->where('cancelled_by','PROVIDER')->count();
        // return view('admin.providers.index', compact('providers', 'documents', 'cancel_rides','rides'));
        return view('support.providers.index', compact('providers','cancel_rides','rides'));
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
        try {	

            $provider = Provider::with('service')
						->whereHas('service', function( $query ) use($id) {
							$query->where('provider_id', $id );
						})->where('id', $id)->first();
			
			if( ! $provider ) {
				throw new Exception('Driver Not Found!');
			}
			
            $services = ServiceType::all();
            $zones=Zones::all();
			
			
			//$provder_service = ProviderService::where('');
			return view('support.providers.edit',compact('provider', 'services', 'zones'));
        } catch (Exception $e) {
			 return back()->with('flash_error',  $e->getMessage() );
			//return back()->with( $e->getMessage() );
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
        
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request, [
            'first_name' => 'required|max:255',
            //'last_name' => 'required|max:255',
            'mobile' => 'digits_between:6,17',
            //'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'type' => 'required',
            'service_type'	=> 'required',
			'service_number'=>	'required',
			'email'	=> 'required',
			//'password'	=> 'confirmed|min:6',
			'service_number'=>	'required',
            'service_model'	=>	'required',
            'zone_id'=>'required|exists:zones,id'
        ]);

        try {

            $provider = Provider::findOrFail($id);
			if( !$provider  ) {
				throw new Exception('Driver Not Found');
			}
			
			$provider_service = ProviderService::where('provider_id', $id)->first();
			if( !$provider_service ) {
				throw new Exception('Driver Service Not Found');
			}
			
			
            if($request->hasFile('avatar')) {
                if($provider->avatar) {
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
            if($request->password!="")
            {
                $provider->password = bcrypt($request->password);
            }
            $provider->update();
            // $provider->save();
    
			$provider_service->service_type_id = $request->service_type;
			$provider_service->service_number = $request->service_number;
            $provider_service->service_model = $request->service_model;
            
            $provider_service->update();	
            // $provider_service->save();

           
                return redirect()->route('support.provider.index')->with('flash_success', 'Driver Updated Successfully');    
            
            	
        }
        catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage() );
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
    public function search(Request $request)
    {
        $AllProviders = Provider::with('service','accepted','cancelled', 'documents')
                    ->orderBy('id', 'DESC')
                    ->where('first_name','LIKE','%'.$request->searchField.'%')
                    ->orWhere('last_name','LIKE','%'.$request->searchField.'%')
                    ->orWhere('email','LIKE','%'.$request->searchField.'%')
                    ->orWhere('mobile','LIKE','%'.$request->searchField.'%');
		
        if(request()->has('fleet')){
            $providers = $AllProviders->where('fleet',$request->fleet)->paginate(100);
        }else{
            $providers = $AllProviders->paginate(100);
        }
        $rides = UserRequests::with('user','provider','payment')->orderBy('id','desc')->count();
		$cancel_ride = UserRequests::where('status','CANCELLED')->get();
        $cancel_rides = $cancel_ride->where('cancelled_by','PROVIDER')->count();
        // return view('admin.providers.index', compact('providers', 'documents', 'cancel_rides','rides'));
        return view('support.providers.index', compact('providers','cancel_rides','rides'));
    }
    public function approve($id)
    {
        try {
            $Provider = Provider::findOrFail($id);
            if($Provider->service) {
                $Provider->update(['status' => 'approved']);
                return back()->with('flash_success', "Driver Approved");
            } else {
                return redirect()->route('support.provider.index', $id)->with('flash_error', "Driver has not been assigned a vehicle!");
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
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', 'Disabled for demo purposes! Please contact us at info@appoets.com');
        }
        
        Provider::where('id',$id)->update(['status' => 'banned']);
        return back()->with('flash_success', "Driver Disapproved");
    }
    public function changeprovidorpassword(Request $request)
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error','Disabled for demo purposes! Please contact us at info@appoets.com');
        }

        $this->validate($request,[
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        try {
            
            $provider = Provider::findOrFail($request->id);
			if( !$provider  ) {
				throw new Exception('Provider Not Found');
			}
            
            if($request->password!="")
            {
                $provider->password = bcrypt($request->password);
            }
             $provider->save();

            return redirect()->back()->with('flash_success', 'Password Updated Successfully'); 
           
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }
    public function fare()
    {
        $fares=Fare::where('domain_name',env('APP_NAME', 'Hulagi'))->get();
        return view('support.fare.index',compact('fares'));
    }

}
