<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use Hash;
use Mail; 
use Setting;
use Storage;
use App\Card;
use App\Chat;
use App\Fare;
use App\User;
use App\Image;
use App\Items;
use App\Zones;
use Exception;
use Validator;
use App\Redeem;
use App\Reward;
use App\Comment;
use App\Country;
use App\Chatroom;
use App\LostItem;
use App\Provider;
use App\Referral;
use App\Settings;
use Notification;
use App\Promocode;
use App\promozone;
use Carbon\Carbon;
use App\FareSetting;
use App\ServiceType; 
use App\ItemHasImage;
use App\PeakAndNight;
use App\UserRequests;
use App\RequestFilter;
use App\UserComplaint;
use App\CountryPricing;
use App\Helpers\Helper;
use App\PaymentHistory;
use App\PaymentRequest;
use App\PromocodeUsage;
use App\ProviderService;
use App\PushNotification;
use App\UserLocationType;
use App\UserRequestRating;
use Illuminate\Http\Request;
use App\Notifications\ResetPasswordOTP;
use App\Http\Controllers\SendPushNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\ProviderResources\TripController;

class UserApiController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->except('estimated_fare','signup','forgot_password','reset_password','checkReferralCode','setting');
    }
    
    public function setting()
    {
                $settings=array('social_login'=>Setting::get('social_login'),
                                'social_login_driver'=>Setting::get('social_login_driver'));
                return $settings;                
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social_unique_id' => ['required_if:login_by,facebook,google','unique:users'],
                'device_type' => 'required|in:android,ios',
                'device_token' => 'required',
                'device_id' => 'required',
                'login_by' => 'required|in:manual,facebook,google',
                'first_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'mobile' => 'required|',
                'password' => 'required|min:6',
        ]);
        // $this->validate($request, [
        //         'social_unique_id' => ['required_if:login_by,facebook,google','unique:users'],
        //         'device_type' => 'required|in:android,ios',
        //         'device_token' => 'required',
        //         'device_id' => 'required',
        //         'login_by' => 'required|in:manual,facebook,google',
        //         'first_name' => 'required|max:255',
        //         'email' => 'required|email|max:255|unique:users',
        //         'mobile' => 'required|unique:users',
        //         'password' => 'required|min:6',
        //     ]);
        if($validator->fails()){
            return response()->json(['msg'=>'The email has already been taken.']);
        }

        try{
           
            $User = $request->all();

            $User['payment_mode'] = 'CASH';
            $User['password'] = bcrypt($request->password);
            
            $r = User::where('mobile',$request->mobile)->count();
            if($r != 0){
                return response()->json(['msg'=>'The mobile has already been taken.']);
            }
            
            


            // add referral code in user table :Shazz
            /*
            $User['referral_code'] = $this->referralCodeGenerator($request->first_name);
            
            if($request->has('referral_code')){
                $refuser = User::where('referral_code',$request->referral_code)->first();
                if($refuser!=null){
                  $User['refer_id'] = $refuser->id;
                  $refpoint = Setting::get('referral_discount');
                  $refuser->referrals = $refuser->referrals+$refpoint;
                }
            }*/
            $User = User::create($User);
            /*if($request->has('referral_code')){
                $referraldata =  new Referral;
                $refuser = User::where('referral_code',$request->referral_code)->first();
                if($refuser!=null){
                  $referraldata->user_id = $refuser->id;
                  $referraldata->referrral_used_by = $User->id;
                  $referraldata->referral_discount = Setting::get('referral_discount');
                  $referraldata->save();
                }
            }*/
            $name=explode(" ",$User->first_name);
            $referral=strtolower($name[0]).$User->id;
            $User->referral_code=$referral;
            $User->save();
            //sendMail('Registration',$request->email,$request->first_name,'Registration');
            return $User;
        }   catch (Exception $e) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    // check referral code :Shazz
    public function checkReferralCode(Request $request){
        $this->validate($request,[
            'referral_code' => 'required'
        ]);
        try {
           $refuser = User::where('referral_code',$request->referral_code)->first();
           if($refuser!=null){
             return response()->json(['status'=>1,'msg'=>'Referral Code Exist'], 200); 
           }else{
                return response()->json(['status'=>0,'msg'=>'Referral Code Not Exist'], 200); 
           } 
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500); 
        }
        
    }
    // generate referral code :Shazz
    public function referralCodeGenerator(){
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 7; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        return $res;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        try {
            User::where('id', $request->id)->update(['device_id'=> '', 'device_token' => '']);
            return response()->json(['message' => trans('api.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function change_password(Request $request){

        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'old_password' => 'required',
            ]);

        $User = Auth::user();

        if(Hash::check($request->old_password, $User->password))
        {
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => trans('api.user.password_updated')]);
            }else{
                return back()->with('flash_success', 'Password Updated');
            }

        } else {
            return response()->json(['error' => trans('api.user.incorrect_password')], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_location(Request $request){

        $this->validate($request, [
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

        if($user = User::find(Auth::user()->id)){

            $point[0] = $request->latitude;
            $point[1] = $request->longitude;
            $zone_id	=	$this->getLatlngZone_id($point);
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->zone_id =  $zone_id;
            $user->save();

            return response()->json(['message' => trans('api.user.location_updated')]);

        }else{

            return response()->json(['error' => trans('api.user.user_not_found')], 500);

        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function details(Request $request){

        $this->validate($request, [
            'device_type' => 'in:android,ios',
        ]);

        try{

            if($user = User::find(Auth::user()->id)){

                if($request->has('device_token')){
                    $user->device_token = $request->device_token;
                }

                if($request->has('device_type')){
                    $user->device_type = $request->device_type;
                }

                if($request->has('device_id')){
                    $user->device_id = $request->device_id;
                }

                $user->save();

                $user->currency = Setting::get('currency');
                $user->sos = Setting::get('sos_number', '911');
                $user->card = Setting::get('CARD');
                $user->paypal = Setting::get('PAYPAL');
                $user->cash = Setting::get('CASH');
                $user->chat = Setting::get('chat');
                $user->razorpay = Setting::get('RAZORPAY');
                $user->social_login = Setting::get('social_login');
                $user->unit = Setting::get('unit');
                //$user->social_login_driver = Setting::get('social_login_driver');
                $user['min_redeem_point'] = Setting::get('min_redeem_ammount');
                $user['location'] = UserLocationType::where('user_id',Auth::user()->id)->get(); 

                //new wallet
                $totalOrder = UserRequests::where('user_id', $user->id)
                    ->where('status', 'COMPLETED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([DB::raw("SUM(cod) as sum_cod"),
                        DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalReject = UserRequests::where('user_id', $user->id)
                    ->where('status', 'REJECTED')
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([DB::raw("SUM(amount_customer) as sum_fare")])
                    ->first();
                $totalPaid = PaymentHistory::where('remarks', 'NOT LIKE', 'Changed from%')
                    ->where('remarks', 'NOT LIKE', '%adjustment%')
                    ->where('user_id', $user->id)
                    ->where('created_at', '>=', '2020-10-15')
                    ->select([
                        DB::raw("SUM(changed_amount) as paid"),
                    ])
                    ->first();
                //paid is negative so, we add it which is same as subtraction
                $user->wallet_balance = $totalOrder->sum_cod - $totalOrder->sum_fare - $totalReject->sum_fare + $totalPaid->paid;
                $existsRequest= PaymentRequest::where('user_id',Auth::user()->id)->where('is_paid',false)->count();
                if($existsRequest!=0){
                    $payment=PaymentRequest::where('user_id',Auth::user()->id)->where('is_paid',0)->latest()->first();
                    // return $payment;
                    $user->request="Yes";
                    $user->request_amt=$payment->requested_amt;
                    $user->amt_request_date=PaymentRequest::where('user_id',Auth::user()->id)->where('is_paid',0)->select('created_at')->latest()->first();

                }
                else{
                    $user->request="NO" ;
                    $date=PaymentRequest::where('user_id',Auth::user()->id)->whereRaw('TIMESTAMPDIFF(day, updated_at, CURRENT_TIMESTAMP) <= 7')->count();
                    if($date==0){
                        $user->can_request="YES";
                    }
                    else{
                        $user->can_request="NO";
                    }
                //    return $date;
                }

                return $user;

            }   else {
                return response()->json(['error' => trans('api.user.user_not_found')], 500);
            }
        }   catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_profile(Request $request)
    {

        $this->validate($request, [
                'first_name' => 'required|max:255',
                'last_name' => 'max:255',
                'email' => 'email|unique:users,email,'.Auth::user()->id,
                /*'BORP' =>'required',
                'vatpan' =>'required',*/
                'document'=>'mimes:jpeg,bmp,png',
                'picture' => 'mimes:jpeg,bmp,png',
            ]);

        try {

            $user = User::findOrFail(Auth::user()->id);

            if($request->has('first_name')){ 
                $user->first_name = $request->first_name;
            }
            
            if($request->has('last_name')){
                $user->last_name = $request->last_name;
            }
            
            if($request->has('email')){
                $user->email = $request->email;
            }
        
            if($request->has('mobile')){
                $user->mobile = $request->mobile;
            }
            if($request->has('BORP')){
                $user->Business_Person = $request->BORP;
            }
            if($request->has('vatpan')){
                $user->VAT_PAN = $request->vatpan;
            }


            if ($request->document != "") {
                Storage::delete($user->Document);
                $user->Document = $request->document->store('user/profile');
            }

            if ($request->picture != "") {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('user/profile');
            }

            $user->save();

            if($request->ajax()) {
                return response()->json($user);
            }else{
                return back()->with('flash_success', trans('api.user.profile_updated'));
            }
        }

        catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.user.user_not_found')], 500);
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function services() {
        
        if($serviceList = ServiceType::all()) {
            
            return $serviceList;
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function send_request(Request $request) {
        $this->validate($request, [

                's_latitude' 	=> 'required',
                's_longitude' 	=> 'required',
                'd_latitude' 	=> 'required',
                'd_longitude' 	=> 'required',
                'weight'        =>'required',
                'service_type' => 'required|numeric|exists:service_types,id',
                'promo_code' => 'exists:promocodes,promo_code',
                'distance' => 'required|numeric',
                'use_wallet' => 'numeric',
                'payment_mode' => 'required|in:CASH,CARD,PAYPAL,RAZORPAY',
                'card_id' => ['required_if:payment_mode,CARD','exists:cards,card_id,user_id,'.Auth::user()->id],
            
            ]);
            $User=User::where('id',Auth::user()->id)->first();
            if($User->new_wallet(Auth::user()->id)< -1500){
                return response()->json(['error' => 'Your Balance is Lower than Limit, So Please Load your Wallet. Contat Hulagi for Further Information'], 500);
            }

       // Log::info('New Request from User: '.Auth::user()->id);
       // Log::info('Request Details:', $request->all());

        //this code makes user to  only request one delivery at a time
            /*
        $ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();

		
        if($ActiveRequests > 0) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.ride.request_inprogress')], 500);
            } else {
                return response()->json(['error' => 'Already request is in progress. Try again later'], 500);
                //return redirect('dashboard')->with('flash_error', 'Already request is in progress. Try again later');
                //dd('hii');
            }
        }

        if($request->has('schedule_date') && $request->has('schedule_time')){
            $beforeschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->subHour(1);
            $afterschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->addHour(1);

            $CheckScheduling = UserRequests::where('status','SCHEDULED')
                            ->where('user_id', Auth::user()->id)
                            ->whereBetween('schedule_at',[$beforeschedule_time,$afterschedule_time])
                            ->count();


            if($CheckScheduling > 0){
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.request_scheduled')], 500);
                }else{
                    return response()->json(['error' => 'Already request is in progress. Try again later'], 500);
                    //return redirect('dashboard')->with('flash_error', 'Already request is Scheduled on this time.');
                }
            }
        }
        */

        $distance = Setting::get('provider_search_radius', '10');
        $service_type = $request->service_type;
		$latitude 	= 0;
		$longitude	= 0;
			
		if( $request->s_latitude &&  $request->s_longitude  ) {
			$latitude 	= $request->s_latitude;
			$longitude	= $request->s_longitude;
        }
        //these codes searches for providers while putting request which is not relevent
        //as we need to add order even if no rider are available
        /*
		
		$Providers = Provider::with('service')
            // ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id')
            ->select()
            ->where('status', 'approved')
            // ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
            ->whereHas('service', function($query) use ($service_type){
                        // $query->whereRaw("(status ='active') or (status='riding' and full=1)");
                        $query->where('service_type_id',$service_type);
            })
            // ->orderBy('distance')
            ->get();

        // List Providers who are currently busy and add them to the filter list.

        if(count($Providers) == 0) {
            if($request->ajax()) {
                // Push Notification to User
                return response()->json(['error' => trans('api.ride.no_providers_found')]); 
            }else{
                return response()->json(['error' => 'No Providers Found! Please try again. asd'.$debug]); 
                //return back()->with('flash_success', 'No Providers Found! Please try again.');
            }
        }
        */

        try{
			
			
			/*
            //$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".env('GOOGLE_MAP_KEY');
            //echo   $details;
		    //$json = curl($details);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $details);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch); 
            $details = json_decode($response, TRUE); 
			
			
            $route_key = $details['routes'][0]['overview_polyline']['points'];
           // echo "<pre/>";
			 //print_r($route_key); die;
			 
			*/
			$route_key =  array();
			$ch = curl_init();
			/*
			Because of ours stupid android developer won't able to send request in array format
			
			for($i = 0; $i < 3; $i++ ) {
				if(  !empty ( $in_request['s_latitude'][$i] ) &&  !empty( $in_request['s_longitude'][$i]) && !empty ( $in_request['d_latitude'][$i] ) && !empty ( $in_request['d_longitude'][$i] ) ) {
					$details = "https://maps.googleapis.com/maps/api/directions/json?origin=". $in_request['s_latitude'][$i] .",". $in_request['s_longitude'][$i] ."&destination=". $in_request['d_latitude'][$i] .",". $in_request['d_longitude'][$i] ."&mode=driving&key=".env('GOOGLE_MAP_KEY');
					$json = curl($details);
					$details = json_decode($json, TRUE);
					$route_key[] = $details['routes'][0]['overview_polyline']['points'];
				}
			}
			*/
			
			//location 1
			if(  $request->s_latitude &&  $request->s_longitude &&  $request->d_latitude && $request->d_longitude ) {
				$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".env('GOOGLE_MAP_KEY');
				$json = curl($details);
                $details = json_decode($json, TRUE);
				$route_key[] = isset($details['routes'][0]['overview_polyline']['points'])?$details['routes'][0]['overview_polyline']['points']:null;
			}

			//location 2
			// if(  $request->s_latitude_2 &&  $request->s_longitude_2 &&  $request->d_latitude_2 && $request->d_longitude_2 ) {
			// 	$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude_2.",".$request->s_longitude_2."&destination=".$request->d_latitude_2.",".$request->d_longitude_2."&mode=driving&key=".env('GOOGLE_MAP_KEY');
			// 	$json = curl($details);
			// 	$details = json_decode($json, TRUE);
			// 	$route_key[] = $details['routes'][0]['overview_polyline']['points'];

			// }

			//location 3
			// if(  $request->s_latitude_3 &&  $request->s_longitude_3 &&  $request->d_latitude_3 && $request->d_longitude_3 ) {
			// 	$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude_3.",".$request->s_longitude_3."&destination=".$request->d_latitude_3.",".$request->d_longitude_3."&mode=driving&key=".env('GOOGLE_MAP_KEY');
			// 	$json = curl($details);
			// 	$details = json_decode($json, TRUE);
			// 	$route_key[] = $details['routes'][0]['overview_polyline']['points'];
			// }
	//	dd('hi');
            $date = Carbon::today()->toDateString();
            if($request->promo_code != null){
                $promo_code =Promocode::where('promo_code',$request->promo_code)->first();
                $count = PromocodeUsage::where('promocode_id',$promo_code->id)->count();
                $user_count=PromocodeUsage::where('promocode_id',$promo_code->id)->where('user_id',Auth::user()->id)->count();
                if($promo_code->set_limit == $count || $promo_code->number_of_time==$user_count){
                    if($request->ajax()) {
                        return response()->json(['success' => false,'error' =>  'Promocode has cross its limit'], 500);
                    }else{
                        return response()->json(['success' => false,'error' =>  'Promocode has cross its limit'], 500);
                        //return redirect('dashboard')->with('flash_error', 'Already request is Scheduled on this time.');
                    }
                }
                if($promo_code){    
                    // dd($promo_code->expiration);
                    // dd(Carbon::now());
                    if($promo_code->expiration<$date){
                    //    return "expired";
                        if($request->ajax()) {
                            return response()->json(['success' => false,'error' => 'Promocode has Expired'], 500);
                        }else{
                            return response()->json(['success' => false,'error' =>  'Promocode has Expired'], 500);
                            //return redirect('dashboard')->with('flash_error', 'Already request is Scheduled on this time.');
                        }
                    }
                   
                }
            }
            $UserRequest = new UserRequests;
            $UserRequest->booking_id = Helper::generate_booking_id();
            $UserRequest->user_id = Auth::user()->id;
            // $UserRequest->provider_id = $Providers[0]->id;
            // $UserRequest->current_provider_id = $Providers[0]->id;
            $UserRequest->service_type_id = $request->service_type;

            if(isset($request->device)){
            // if(true){
                $request->user_id=Auth::user()->id;
                $json_string=$this->add_item($request);
                $responseItems=json_decode($json_string->content());
                $UserRequest->item_id         = $responseItems->item_id;
            }
            else{
                $UserRequest->item_id         = $request->item_id;
            }
            
            $UserRequest->cod = $request->cod ? $request->cod : '0';
            $UserRequest->special_note = $request->special_note;
            $zones=$this->zoneSelector($request->s_latitude,$request->s_longitude,$request->d_latitude,$request->d_longitude);
            
            $UserRequest->zone1 = $zones['zone1'];
            $UserRequest->zone2 = $zones['zone2'];
			
            $UserRequest->payment_mode = $request->payment_mode;
            $UserRequest->fare= $request->fare;
            $UserRequest->status = 'PENDING';
             $order=UserRequests::where('user_id',Auth::user()->id)->count();
            // if(Auth::user()->created_at >= '2022-04-10' || $order>100){
            //     switch ($order){
            //         case $order>3000:
            //             $UserRequest->amount_customer= $request->fare-$request->fare*10/100;
            //             break;
            //         case $order>1000:
            //         $UserRequest->amount_customer= $request->fare-$request->fare*5/100;
            //             break;
            //         case $order>500:
            //         $UserRequest->amount_customer= $request->fare-$request->fare*3/100;
            //             break;
            //         case $order>60:
            //             $UserRequest->amount_customer= $request->fare;
            //             break;
            //         case $order>10:
            //             $UserRequest->amount_customer= $request->fare+$request->fare*20/100;
            //             break;
            //         default:
            //             $UserRequest->amount_customer= $request->fare + $request->fare*50/100;
            //             break;
            //     }
            // }
            // else{
            $UserRequest->amount_customer= $request->fare;
            // }

            if(isset($promo_code)){
                $promozone=PromoZone::where('promocode_id',$promo_code->id)->first();
                // dd($promozone);
                if($promozone!=null){
                    $pomozone=promozone::where('promocode_id',$promo_code->id)->whereIn('Zone_id',[$zones['zone1'],$zones['zone2']])->first();
                    $respromo=promozone::where('promocode_id',$promo_code->id)->whereIn('Restricted_Zone_id',[$zones['zone1'],$zones['zone2']])->first();
                    $all=promozone::where('promocode_id',$promo_code->id)->where('Zone_id',0)->first();
                        if(isset($pomozone)){
                            $data=$this->promocode($promo_code,$UserRequest);
                            if($data){    
                                if(isset($data->getdata()->error)){
                                    return $data;
                                }
                            }
                            PromocodeUsage::create(
                                [
                                    'user_id'=>Auth::user()->id,
                                    'promocode_id'=>$promo_code->id,
                                    'status'=>'used'
                                ]
                            );
                        }
                        elseif(isset($respromo)){
                           return response()->json(['success' => false,'error' => 'Promocode is not applicable for this zone'], 500);                            
                        }
                        elseif($all){
                            $data=$this->promocode($promo_code,$UserRequest);
                            if($data){    
                                if(isset($data->getdata()->error)){
                                    return $data;
                                }
                            } 
                            PromocodeUsage::create(
                                [
                                    'user_id'=>Auth::user()->id,
                                    'promocode_id'=>$promo_code->id,
                                    'status'=>'used'
                                ]
                            );
                        }
                        else{
                            // dd('Promocode is not applicable for this zone');
                            return response()->json(['success' => false,'error' => 'Promocode is not applicable for this zone'], 500);   
                        }
                }
                else{
                    $data=$this->promocode($promo_code,$UserRequest);
                    if($data){    
                        if(isset($data->getdata()->error)){
                            return $data;
                        }
                    }
                    PromocodeUsage::create(
                        [
                            'user_id'=>Auth::user()->id,
                            'promocode_id'=>$promo_code->id,
                            'status'=>'used'
                        ]
                    );
                } 
            }   
            $UserRequest->cargo= $request->cargo;
			
            $UserRequest->s_address = $request->s_address ? $request->s_address : '';
            $UserRequest->d_address = $request->d_address ? $request->d_address : '';
			
            $UserRequest->s_latitude = $request->s_latitude ? $request->s_latitude : 0.00000 ;
            $UserRequest->s_longitude = $request->s_longitude ? $request->s_longitude : 0.00000 ;

            $UserRequest->d_latitude = $request->d_latitude ? $request->d_latitude : 0.00000;
            $UserRequest->d_longitude = $request->d_longitude ? $request->d_longitude : 0.00000;

            if(Auth::user()->wallet_balance > 0){
                $UserRequest->use_wallet = $request->use_wallet ? : 0;
            }

            $UserRequest->assigned_at = Carbon::now();
			
            $UserRequest->route_key =  serialize( $route_key );
            $UserRequest->weight =  $request->weight;
            $UserRequest->Pickedup_number =  $request->phone;
            $UserRequest->promo_code =  $request->promo_code;

            

            /*
            if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0){
                $UserRequest->surge = 1;
            }
            */

            if($request->has('schedule_date') && $request->has('schedule_time')){
                $UserRequest->schedule_at = date("Y-m-d H:i:s",strtotime("$request->schedule_date $request->schedule_time"));
            }

            $UserRequest->save();
            // dd($UserRequest);

            // Log::info('New Request id : '. $UserRequest->id .'Assigned to provider : '. $UserRequest->current_provider_id);
			

            // update payment mode 

			
            User::where('id',Auth::user()->id)->update(['payment_mode' => $request->payment_mode]);
            Items::where('id',$UserRequest->item_id)->update(['request_id' => $UserRequest->id]);
            if($request->has('card_id')){

                Card::where('user_id',Auth::user()->id)->update(['is_default' => 0]);
                Card::where('card_id',$request->card_id)->update(['is_default' => 1]);
            }
			
            if($request->ajax()) {
				
                return response()->json([
                        'message' => 'New request Created!',
                        'request_id' => $UserRequest->id,
                        'current_provider' => $UserRequest->current_provider_id,
                        'booking_id' => $UserRequest->booking_id,
                        'date' => date("Y/m/d")
                    ]);
            }else{
                return response()->json([
                    'request_id' => $UserRequest->id,
                    'error' => 'dashboard']);
                //return redirect('dashboard');
            }

        } catch (Exception $e) {
			echo $e->getMessage(); die;
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return response()->json(['error' => 'Something went wrong while sending request. Please try again.'], 500);
                //return back()->with('error', 'Something went wrong while sending request. Please try again.');
            }
        }
    }
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function search_provider(Request $request) {

        //Log::info('New Request from User: '.Auth::user()->id);
        //Log::info('Request Details:', $request->all());
        
        $request = UserRequests::where('user_id',Auth::user()->id)->where('status','SCHEDULED')->orderBy('id', 'DESC')->first();
        
        $spoint[0]	=	$request['s_latitude']; 
		$spoint[1]	=	$request['s_longitude'];
		$dpoint[0]	=	$request['d_latitude']; 
		$dpoint[1]	=	$request['d_longitude'];
		$szone_id	=	$this->getLatlngZone_id($spoint);
		$dzone_id	=	$this->getLatlngZone_id($dpoint);
    	        
        /*$ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();

        if($ActiveRequests > 1) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.ride.request_inprogress')], 500);
            } else {
                return redirect('dashboard')->with('flash_error', 'Already request is in progress. Try again later.');
            }
        }*/
        
        
         
        //$ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();
        $distance       =   Setting::get('provider_search_radius', '10');
        $latitude	    =	$request['s_latitude']; 
		$longitude	    =	$request['s_longitude'];
		$service_type	=   $request['service_type_id']; 
		$promo_code	    =	$request['d_longitude'];
		
        /*$latitude     = $request->s_latitude;
        $longitude    = $request->s_longitude;
        $service_type = $request->service_type;
		$promo_code	  = $request->promo_code;*/
        /*
        $Providers    = Provider::with('service')
                        ->select(DB::Raw("(6387 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id')
                        ->where('status', 'approved')
                        ->whereRaw("(6387 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                        ->whereHas('service', function($query) use ($service_type){
                                    $query->where('status','active');
                                    $query->where('service_type_id',$service_type);
                                })
                        ->orderBy('distance','asc')
                        ->get();
        //dd(count($Providers));
       
        //List Providers who are currently busy and add them to the filter list.
        if(count($Providers) == 0) {
            return back()->with('flash_success', 'No Providers Found! Please try again. def');
        }
        */
 
            try{
    
                $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".env('GOOGLE_MAP_KEY');
    
                $json = curl($details);
    
                $details = json_decode($json, TRUE);
                
                $route_key  = $details['routes'][0]['overview_polyline']['points'];
                $booking_id = Helper::generate_booking_id();
                
                $UserRequest = UserRequests::findOrFail($request['id']);
                //$UserRequest = new UserRequests;
                $UserRequest->booking_id = $booking_id;
                //$UserRequest->user_id = Auth::user()->id;

                // $UserRequest->provider_id = $Providers[0]->id;
                // $UserRequest->current_provider_id = $Providers[0]->id;

                //$UserRequest->service_type_id = $request->service_type;
                //$UserRequest->payment_mode = $request->payment_mode;
    			//$UserRequest->promo_code =	$request->promo_code;
                
                $UserRequest->status = 'PENDING';
    
                //dd('hi');
    
                if(Auth::user()->wallet_balance > 0) {
                    //$UserRequest->use_wallet = $request->use_wallet ? : 0;
                }
    
                $UserRequest->assigned_at = Carbon::now();
                $UserRequest->route_key = $route_key;
                /*
                if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0) {
                    $UserRequest->surge = 1;
                }
                */
    
                
                $checkrequest = UserRequests::where('status','PENDING')->where('user_id', Auth::user()->id)->get();
                if(count($checkrequest)==0)
                {
                    $UserRequest->save();
                }
                
                $data = array(
                    'username'      => Auth::user()->first_name,
                    'usermobile'    => Auth::user()->mobile,
                    'payment_mode'  => Auth::user()->payment_mode,
                    'booking_id'    => $booking_id,
                    // 'drivername'    => $Providers[0]->first_name,
                    // 'drivermobile'  => $Providers[0]->mobile
                );
                
                /*
                 //Send New Request Email to Admin
                Mail::send('emails.new_request_notification', [ 'data' => $data ] , function($message) use ($data) {
                    $message->to( config('mail.admin.address') )->subject('New Request Accepted By Driver | Wedrive ');
                    $message->from( config('mail.from.address' ) , config('mail.from.name') );
                });
                */
                
                //Log::info('New Request id : '. $UserRequest->id .' Assigned to provider : '. $UserRequest->current_provider_id);
    
                // update payment mode
    
                /*User::where('id',Auth::user()->id)->update(['payment_mode' => $request->payment_mode]);
    
                if($request->has('card_id'))    {
    
                    Card::where('user_id',Auth::user()->id)->update(['is_default' => 0]);
                    Card::where('card_id',$request->card_id)->update(['is_default' => 1]);
                }*/
    
                // (new SendPushNotification)->IncomingRequest($Providers[0]->id);
                
                /*
                if(isset($UserRequest->id) && $UserRequest->id!=''):
                    foreach ($Providers as $key => $Provider) {
        
                        $Filter = new RequestFilter;
                        // Send push notifications to the first provider
                        // incoming request push to provider
                        $Filter->request_id = $UserRequest->id;
                        $Filter->provider_id = $Provider->id; 
                        $Filter->save();
                    }
                endif;
                */
    
                if($UserRequest) {  
                    return response()->json([
                            'message' => 'Providor assigned to sheduled request!',
                            'request_id' => $UserRequest->id,
                            'current_provider' => $UserRequest->provider_id,
                        ]);
                }else {
                    return response()->json(['error' => 'dashboard'], 200);
                    //return view('user.dashboard');
                    //return redirect('dashboard');
                    //dd('hi');
                }
    
            }   catch (Exception $e) {
                return response()->json(['error' => $e->getMessage() ]);
            } 
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancel_request(Request $request) {

        // $this->validate($request, [
        //     'request_id' => 'required|numeric|exists:user_requests,id,user_id,'.Auth::user()->id,
        // ]);
        $this->validate($request, [
            'request_id' => 'required|numeric',
        ]);
        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);

            if($UserRequest->status == 'CANCELLED')
            {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_cancelled')], 500); 
                }   else{
                    return back()->with('flash_error', 'Request is Already Cancelled!');
                }
            }
            /*if($UserRequest->status != 'PENDING')
            {
                (new SendPushNotification)->UserCancellRide($UserRequest);
            }*/
            
            if(in_array($UserRequest->status, ['PENDING','STARTED','ARRIVED','SCHEDULED'])) {

                if($UserRequest->status != 'PENDING'){
                    $this->validate($request, [
                        'cancel_reason'=> 'max:255',
                    ]);
                }

                $UserRequest->status = 'CANCELLED';
                $UserRequest->cancel_reason = $request->cancel_reason;
                $UserRequest->cancelled_by = 'USER';
                $UserRequest->save();

                RequestFilter::where('request_id', $UserRequest->id)->delete();

                if($UserRequest->status != 'SCHEDULED') {

                    if($UserRequest->provider_id != 0)  {

                        ProviderService::where('provider_id',$UserRequest->provider_id)->update(['status' => 'active']);

                    }
                }

                // Send Push Notification to User
                
                (new SendPushNotification)->UserCancellRide($UserRequest);

                if($request->ajax()) {
                    return response()->json(['message' => trans('api.ride.ride_cancelled')]); 
                }   else{
                    return redirect('dashboard')->with('flash_success','Request Cancelled Successfully');
                }

            }   else {
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_onride')], 500); 
                }else{
                    return back()->with('flash_error', 'Service Already Started!');
                }
            }
        }

        catch (ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }else{
                return back()->with('flash_error', 'No Request Found!');
            }
        }

    }



    public function getCurrentTrips() {
        try{
			
            $UserRequests = UserRequests::UserOngoingTrips(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
			
            return $UserRequests;
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage() ]);
        }
    }

    /**
     * Show the request status check.
     *
     * @return \Illuminate\Http\Response
     */

public function request_status_check1() {
    //dd($request->request_id);
        try{
            $check_status = ['CANCELLED', 'SCHEDULED'];

            $UserRequests = UserRequests::UserRequestStatusCheck(Auth::user()->id, $check_status)->orderBy('created_at','asc')
                                        ->get()
                                        ->toArray();
            if(isset($UserRequests[0]['payment']['promocode_id']))
            {
                $promocode_id =  $UserRequests[0]['payment']['promocode_id'];
                $promocode =  Promocode::where('id', $promocode_id)->first();
                $promocode_name = $promocode['promo_code'];
                $UserRequests[0]['payment']['promocode_name']=$promocode_name;
            }
            /*$promocode_id =  $UserRequests[0]['payment']['promocode_id'];
            $promocode =  Promocode::where('id', $promocode_id)->first();
            $promocode_name = $promocode['promo_code'];*/
            //$UserRequests[0]['payment']['promocode_name']="$promocode_name";
            $search_status = ['PENDING','SCHEDULED'];
            $UserRequestsFilter = UserRequests::UserRequestAssignProvider(Auth::user()->id,$search_status)->get(); 

            /*
            $Timeout = Setting::get('provider_select_timeout', 180);
            if(!empty($UserRequestsFilter)){
                for ($i=0; $i < sizeof($UserRequestsFilter); $i++) {
                    $ExpiredTime = $Timeout - (time() - strtotime($UserRequestsFilter[$i]->assigned_at));
                    if($UserRequestsFilter[$i]->status == 'PENDING' && $ExpiredTime < 0) {
                        $Providertrip = new TripController();
                        $Providertrip->assign_next_provider($UserRequestsFilter[$i]->id);
                    }else if($UserRequestsFilter[$i]->status == 'PENDING' && $ExpiredTime > 0){
                        break;
                    }
                }
            }
            */
            //dd($request->request_id);
            // UserRequests::where('id',$request->request_id)->update(['special_note' => $request->special_note]);
            return response()->json(['data' => $UserRequests]);
            
        }   catch (Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    public function request_status_check(Request $request) {
    
        try{
            $check_status = ['CANCELLED', 'SCHEDULED'];

            $UserRequests = UserRequests::UserRequestStatusCheck(Auth::user()->id, $check_status)
                                        ->get()
                                        ->toArray();
            Log::debug($UserRequests);
            //dd($UserRequests[0]['user']['first_name']);                            
            if(isset($UserRequests[0]['payment']['promocode_id']))
            {
                $promocode_id =  $UserRequests[0]['payment']['promocode_id'];
                $promocode =  Promocode::where('id', $promocode_id)->first();
                $promocode_name = $promocode['promo_code'];
                $UserRequests[0]['payment']['promocode_name']=$promocode_name;
            }
            /*$promocode_id =  $UserRequests[0]['payment']['promocode_id'];
            $promocode =  Promocode::where('id', $promocode_id)->first();
            $promocode_name = $promocode['promo_code'];*/
            //$UserRequests[0]['payment']['promocode_name']="$promocode_name";
            $search_status = ['PENDING','SCHEDULED'];
            $UserRequestsFilter = UserRequests::UserRequestAssignProvider(Auth::user()->id,$search_status)->get(); 

            /*
            $Timeout = Setting::get('provider_select_timeout', 180);
            if(!empty($UserRequestsFilter)){
                for ($i=0; $i < sizeof($UserRequestsFilter); $i++) {
                    $ExpiredTime = $Timeout - (time() - strtotime($UserRequestsFilter[$i]->assigned_at));
                    if($UserRequestsFilter[$i]->status == 'PENDING' && $ExpiredTime < 0) {
                        $Providertrip = new TripController();
                        $Providertrip->assign_next_provider($UserRequestsFilter[$i]->id);
                    }else if($UserRequestsFilter[$i]->status == 'PENDING' && $ExpiredTime > 0){
                        break;
                    }
                }
            }
            */
            if($request->special_note!="")
            {
                $req_data = UserRequests::findOrFail($request->request_id);
                //dd($req_data['provider_id']);
                //$UserRequests[0]['user']['first_name']='user';
                (new SendPushNotification)->specialNoteNotifyProvider($req_data['provider_id'],$request->special_note,$request->request_id,$UserRequests[0]['user']['first_name']);
            }
            //(new SendPushNotification)->specialNoteNotifyProvider($UserRequests[0]['provider_id'],$request->message,$request->request_id,$UserRequests[0]['user']['first_name']);
            /*UserRequests::where('id',$request->request_id)->update(['special_note' => $request->special_note]);*/
            return response()->json(['data' => $UserRequests]);
            
        }   catch (Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function rate_provider(Request $request) {


        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id,user_id,'.Auth::user()->id,
                'rating' => 'required|integer|in:1,2,3,4,5',
                'comment' => 'max:255',
            ]);
    
        $UserRequests = UserRequests::where('id' ,$request->request_id)
                ->where('status' ,'COMPLETED')
                //->where('paid', 1)
                ->where('paid', 0)
                ->first();
        
        if ($UserRequests) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.user.not_paid')], 500);
            } else {
                return back()->with('flash_error', 'Service Already Started!');
            }
        }

        try{

            $UserRequest = UserRequests::findOrFail($request->request_id);
            $review = UserRequestRating::where('request_id',$request->request_id)->count();
            
            if($review==0) {
                UserRequestRating::create([
                    'provider_id' => $UserRequest->provider_id,
                    'user_id' => $UserRequest->user_id,
                    'request_id' => $UserRequest->id,
                    'user_rating' => $request->rating,
                    'user_comment' => $request->comment,
                ]);
            } else {
                $UserRequest->rating->update([
                    'user_rating' => $request->rating,
                    'user_comment' => $request->comment,
                ]);
            }
            /*if($UserRequest->rating == null) {
                dd('UserRequestRating');
                    UserRequestRating::create([
                        'provider_id' => $UserRequest->provider_id,
                        'user_id' => $UserRequest->user_id,
                        'request_id' => $UserRequest->id,
                        'user_rating' => $request->rating,
                        'user_comment' => $request->comment,
                    ]);
            } else {
                    dd('else');
                    $UserRequest->rating->update([
                        'user_rating' => $request->rating,
                        'user_comment' => $request->comment,
                    ]);
            }*/

            $UserRequest->user_rated = 1;
            $UserRequest->save();
            
            $average = UserRequestRating::where('provider_id', $UserRequest->provider_id)->avg('user_rating');
            
            if($average=='null')
            {
                $average=0;
            } 
            
            Provider::where('id',$UserRequest->provider_id)->update(['rating' => $average]);

            // Send Push Notification to Provider 
            if($request->ajax()){
                return response()->json(['message' => trans('api.ride.provider_rated')]); 
            }else{
                return redirect('dashboard')->with('flash_success', 'Driver Rated Successfully!');
            }
        }   catch (Exception $e) {
                if($request->ajax()){
                    return response()->json(['error' => trans('api.something_went_wrong')], 500);
                }else{
                    return back()->with('flash_error', 'Something went wrong');
                }
        }

    } 

    public function check_rate_provider(Request $request) {
	     
	     $data = UserRequests::select('id as request_id','paid','user_rated','provider_id')->where('user_id',Auth::user()->id)->where('status','COMPLETED')->orderBy('id','desc')->first();
	     $data->user_name = Auth::user()->first_name;
	     $data->provider_name = Provider::where('id',$data->provider_id)->value('first_name');
	     $data->provider_picture = Provider::where('id',$data->provider_id)->value('avatar');
	     //dd($data);
	     return $data;
	 }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function trips() {
    
        try{
            $UserRequests = UserRequests::UserTrips(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }


public function alltripsWithRider() {
    
        try{
            $UserRequests = UserRequests::AllUserTrips(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                $data=[];
                $index=0;
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                    $data[$index]['ride']=$value;
                    $data[$index]['item']=items::where('id',$value->item_id)->first();
                    if($value->status!="PENDING" && $value->status!="COMPLETED" && $value->status!="REJECTED" && $value->status!="CANCELLED"){
                        $data[$index]['rider']=Provider::where('id',$value->provider_id)
                            ->select(array('first_name','mobile'))
                            ->first();
                    }
                    else{
                        $data[$index]['rider']=array('first_name'=>null,'mobile'=>null);
                    }
                    $index++;
                }
            }
            return $data;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    public function alltrips() {
    
        try{
            $UserRequests = UserRequests::AllUserTrips(Auth::user()->id)->orderBy('created_at','asc')->paginate(50);
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function estimated_fare(Request $request) {
        
        //Log::info('Estimate', $request->all());
        // return response()->json([
        //     'estimated_fare' => 'Some data'
        // ]);
        $validate=Validator::make($request->all(),[
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
            ]);
    if($validate->fails()){
        return "error";
        return response()->json(['error' => $validate->messages()]);
    }
        // $this->validate($request,[
        //     's_latitude' => 'required|numeric',
        //     's_longitude' => 'required|numeric',
        //     'd_latitude' => 'required|numeric',
        //     'd_longitude' => 'required|numeric',
        //     'service_type' => 'required|numeric|exists:service_types,id',
        // ]);

        try{

            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=".env('GOOGLE_MAP_KEY');

            $json = curl($details);

            $details = json_decode($json, TRUE);

            @$meter = $details['rows'][0]['elements'][0]['distance']['value'];
            @$time = $details['rows'][0]['elements'][0]['duration']['text'];
            @$seconds = $details['rows'][0]['elements'][0]['duration']['value'];

            @$kilometer = round($meter/1000);
            @$minutes = round($seconds/60);

            $tax_percentage = Setting::get('tax_percentage');
            $currency = Setting::get('currency');
            $commission_percentage = Setting::get('commission_percentage');
            $service_type = ServiceType::findOrFail($request->service_type);
			$total_discount = 0;
            $price = $service_type->fixed;
            $currentDay = date('l');
            $Time  = Carbon::now(env('APP_TIMEZONE'));
            $booking_time = $Time->toTimeString();
            //return $service_type;exit;

            
            // condition
      			
		    $fareSetting = FareSetting::where('from_km','<=',round($kilometer,0))->where('upto_km','>=',round($kilometer,0))
		    	//->where('peak_hour','YES')
		   		->where('status',1)
		     	->orderBy('id','DESC')
		     	->first();
		    if(!empty($fareSetting)){
		    	$peakAndNight  = new PeakAndNight;
		    	$peakAndNight = $peakAndNight->where('start_time','<=',$booking_time)
		    	->where('end_time','>=',$booking_time)
		    	->where('status',1);
		    	if($fareSetting->peak_hour=='YES' && $fareSetting->late_night=='YES'){
		    		$peakAndNight = $peakAndNight->where(function($q) use($currentDay){
		    			$q->where('day',$currentDay)
		    			  ->orWhere('day',null);
		    		});

		    	}else{
		    		$peakAndNight = $peakAndNight->where(['day'=>$currentDay]);	
		    	}
		    	$peakAndNight = $peakAndNight->where('fare_setting_id',$fareSetting->id);
		    	$peakAndNight = $peakAndNight->orderBy('id','DESC')
		    	->first();
		   
		    	if(!empty($peakAndNight)){
	
		    		$amount = (($service_type->fixed+($kilometer*$fareSetting->price_per_km))*1); //double price on two way ride
		    		$Commision     = $amount * ( $commission_percentage/100 );
		    		$extra_tax_price = ( $peakAndNight->fare_in_percentage/100 ) * $amount;
		    		$amount = $amount + $extra_tax_price;
		    		$tax_price = ( $tax_percentage/100 ) * $amount;
		    		$total = $amount + $Commision +$tax_price;	
		    	}else{
		    	    
		    			// fare setting applied without peak day and time
		    			 //dd($fareSetting->price_per_km);
		    			$amount = (($service_type->fixed+($kilometer*$fareSetting->price_per_km))*1); //double price on two way ride
		    			
		    			$Commision     = $amount * ( $commission_percentage/100 );
		    			$tax_price = ( $tax_percentage/100 ) * $amount;
		    			$total = $amount + $Commision + $tax_price;
		    	         
		    	}
		    }   else{
		        
				// else condition
	            if($service_type->calculator == 'MIN') {
	                $price += $service_type->minute * $minutes;
	            } else if($service_type->calculator == 'HOUR') {
	                $price += $service_type->minute * 60;
	            } else if($service_type->calculator == 'DISTANCE') {
	                $price += ($kilometer * $service_type->price);
	            } else if($service_type->calculator == 'DISTANCEMIN') {
	                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes);
	            } else if($service_type->calculator == 'DISTANCEHOUR') {
	                $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
	            } else {
	                $price += ($kilometer * $service_type->price);
	            }
	            $Commision     = $price * ( $commission_percentage/100 );
	            $tax_price = ( $tax_percentage/100 ) * $price;
	            $total = $price + $Commision + $tax_price;
				//
			
		    }		
      /////////////////////////////////////////////////////////////////////////////////////////////
			//sid
			if ( $request->has('promo_code') ) {
				// Apply  promo code
				if($promo_code =  Promocode::where('promo_code', $request->promo_code)->first() ) {
					$total_discount =  ($total * $promo_code->discount)/100;
					$total = $total - $total_discount; 
				}
			}
		    

            // shazz:
            // check if user have any active referral discount
            $referral_used = Referral::where(['user_id'=>Auth::user()->id,'referral_status'=>1])->first();
            if($referral_used!=null){
               $total_discount =  ($total * $referral_used->referral_discount)/100;
               $total = $total - $total_discount;  
            }
            /// end check

            $ActiveProviders = ProviderService::AvailableServiceProvider($request->service_type)->get()->pluck('provider_id');
			
            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->s_latitude;
            $longitude = $request->s_longitude;
            
            $Providers = Provider::whereIn('id', $ActiveProviders)
                ->where('status', 'approved')
                // ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                ->get();

            $surge = 0;
            
            // if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0){
            //     $surge_price = (Setting::get('surge_percentage')/100) * $total;
            //     $total += $surge_price;
            //     $surge = 1;
            // }
            
            //$Total= $total+$commission_percentage;
			
            $fare=0;
            $km=number_format($meter/1000,2);
            $zones=Zones::where("status","active")->get();
            $zone1=null;
            $zone2=null;
            foreach($zones as $zone){
                //if the given addresses is in a zone then proceed else send error

                //first convert the map data in correct form
                $coordinates=unserialize($zone->coordinate);
                $poly=[];
                foreach($coordinates as $index=>$c){
                    $val=explode(",",$c);
                    $poly[$index]=['lat'=>$val[0],'lng'=>$val[1]];
                }

                //now compare it with the given inputs
                $sCheck=\GeometryLibrary\PolyUtil::containsLocation(
                    ['lat' => $request->s_latitude, 'lng' => $request->s_longitude],$poly);  
                
                $dCheck=\GeometryLibrary\PolyUtil::containsLocation(
                    ['lat' => $request->d_latitude, 'lng' => $request->d_longitude],$poly);
                if($sCheck){
                    $zone1=$zone;
                }
                if($dCheck){
                    $zone2=$zone;
                }  
            }
            if($zone1 && $zone2){
                $fareObj=null;
                //first know if both zones are same. If yes, then apply distance based rates
                if($zone1==$zone2){
                    $fareObj=Fare::where('zone1_id',$zone1->id)
                            ->where('zone2_id',$zone2->id)
                            ->where('km','>',$km)
                            ->orderBy('km','ASC')
                            ->first();
                }
                else{
                    if(isset($request->cargo)){
                        $fareObj=Fare::where('zone1_id',$zone1->id)
                            ->where('zone2_id',$zone2->id)
                            ->where('cargo',$request->cargo)
                            ->first();    
                    }
                    else{
                        $fareObj=Fare::where('zone1_id',$zone1->id)
                                ->where('zone2_id',$zone2->id)
                                ->first();
                    }
                }
                if($fareObj){
                    $fare=$fareObj->fare;
                    return response()->json([
                        // 'estimated_fare' => bcdiv($total,1,2), 
                        'estimated_fare' => $fare, 
                        'distance' => $km,
                        'time' => $time,
                        //'surge' => $surge,
                        //'surge_value' => '1.4X',
                        'tax_price' => bcdiv($tax_price,1,2),
                        'base_price' => $service_type->fixed,
                        'wallet_balance' => Auth::user()->wallet_balance,
                        'discount'		=> bcdiv($total_discount,1,2),
                        'currency'   => $currency,
                    ]);
                }   
                else{
                    return response()->json([
                        'error'=>"Out of Service area of operation"
                    ]);
                }
            }
            else{
                //invalid area selection: Not in our operation zone
                return response()->json([
                    'error'=>"Out of Service area of operation"
                ]);
            }/*
            if($km<3){
                $fare=60;
            }
            else if($km<4){
                $fare=70;
            }
            else if($km<5){
                $fare=80;
            }
            else if($km<6){
                $fare=90;
            }
            else{
                $fare=115;
            }
            return response()->json([
                    // 'estimated_fare' => bcdiv($total,1,2), 
                    'estimated_fare' => $fare, 
                    'distance' => $km,
                    'time' => $time,
                    //'surge' => $surge,
                    //'surge_value' => '1.4X',
                    'tax_price' => bcdiv($tax_price,1,2),
                    'base_price' => $service_type->fixed,
                    'wallet_balance' => Auth::user()->wallet_balance,
					'discount'		=> bcdiv($total_discount,1,2),
					'currency'   => $currency
                ]);
                */

        }   catch(Exception $e) {
        	
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function trip_details(Request $request) {

         $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);
    
        try{
            $UserRequests = UserRequests::where('user_id',Auth::user()->id)
                            ->where('id',$request->request_id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x191919|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }


    public function alltrip_details(Request $request) {

             $this->validate($request, [
                    'request_id' => 'required|integer|exists:user_requests,id',
                ]);
        
            try{
                $UserRequests = UserRequests::AllUserTripDetails(Auth::user()->id,$request->request_id)->get();
                if(!empty($UserRequests)){
                    $s_map_icon = asset('asset/img/map-start2.png');
                    $d_map_icon = asset('asset/img/marker-stop.png');
                    foreach ($UserRequests as $key => $value) {
                        $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                                "autoscale=1".
                                "&size=320x130".
                                "&maptype=terrian".
                                "&format=png".
                                "&visual_refresh=true".
                                "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                                "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                                "&path=color:0x191919|weight:3|enc:".$value->route_key.
                                "&key=".env('GOOGLE_MAP_KEY');
                    }
                }
                return $UserRequests;
            }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }
    /**
     * get all promo code.
     *
     * @return \Illuminate\Http\Response
     */

    public function promocodes() {
        try{
            $this->check_expiry();

            return PromocodeUsage::Active()
                    ->where('user_id', Auth::user()->id)
                    ->with('promocode')
                    ->get();

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    } 


    public function check_expiry(){
        try{
            $Promocode = Promocode::all();
            foreach ($Promocode as $index => $promo) {
                if(date("Y-m-d") > $promo->expiration){
                    $promo->status = 'EXPIRED';
                    $promo->save();
                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'EXPIRED']);
                }else{
                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'ADDED']);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * add promo code.
     *
     * @return \Illuminate\Http\Response
     */

    public function add_promocode(Request $request) {

        $this->validate($request, [
                'promocode' => 'required|exists:promocodes,promo_code',
            ]);
        try{
            $find_promo = Promocode::where('promo_code',$request->promocode)->first();

            if($find_promo->status == 'EXPIRED' || (date("Y-m-d") > $find_promo->expiration)){

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('api.promocode_expired'), 
                        'code' => 'promocode_expired'
                    ]);

                }   else{
                    return back()->with('flash_error', trans('api.promocode_expired'));
                }

            }   elseif(PromocodeUsage::where('promocode_id',$find_promo->id)->where('user_id', Auth::user()->id)->where('status','ADDED')->count() > 0){

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('api.promocode_already_in_use'), 
                        'code' => 'promocode_already_in_use'
                        ]);

                }else{
                    return back()->with('flash_error', 'Promocode Already in use');
                }
            }   else{
                $promo = new PromocodeUsage;
                $promo->promocode_id = $find_promo->id;
                $promo->user_id = Auth::user()->id;
                $promo->status = 'ADDED';
                $promo->save();
                if($request->ajax()){
                    return response()->json([
                            'message' => trans('api.promocode_applied') ,
                            'code' => 'promocode_applied'
                         ]); 
                }else{
                    return back()->with('flash_success', trans('api.promocode_applied'));
                }
            }
        }
        catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something Went Wrong');
            }
        }
    } 
    
    
    public function remove_promocode(Request $request)
    {
        $deletepromo = PromocodeUsage::where('promocode_id',$request->id)->delete();
        dd($deletepromo);
        //PromocodeUsage::where('promocode_id',$find_promo->id)
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function upcoming_trips() {
    
        try{
            $UserRequests = UserRequests::UserUpcomingTrips(Auth::user()->id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function upcoming_trip_details(Request $request) {

         $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
            ]);
       
        try{
            $UserRequests = UserRequests::UserUpcomingTripDetails(Auth::user()->id,$request->request_id)->get();
            if(!empty($UserRequests)){
                $s_map_icon = asset('asset/img/map-start2.png');
                $d_map_icon = asset('asset/img/marker-stop.png');
                foreach ($UserRequests as $key => $value) {
                    $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                            "autoscale=1".
                            "&size=320x130".
                            "&maptype=terrian".
                            "&format=png".
                            "&visual_refresh=true".
                            "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                            "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                            "&path=color:0x000000|weight:3|enc:".$value->route_key.
                            "&key=".env('GOOGLE_MAP_KEY');
                }
            }
            return $UserRequests;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }


    /**
     * Show the nearby providers.
     *
     * @return \Illuminate\Http\Response
     */

    public function show_providers(Request $request) {

        $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'service' => 'numeric|exists:service_types,id',
            ]);

        try{

            $distance = Setting::get('provider_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            if($request->has('service')){
                $ActiveProviders = ProviderService::AvailableServiceProvider($request->service)->get()->pluck('provider_id');
                $Providers = Provider::whereIn('id', $ActiveProviders)
                    ->where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();
            } else {
                $Providers = Provider::where('status', 'approved')
                    ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                    ->get();
            }

            if(count($Providers) == 0) {
                if($request->ajax()) {
                    return response()->json(['message' => "No Providers Found"]); 
                }else{
                    return back()->with('flash_success', 'No Providers Found! Please try again. 1232');
                }
            }
        
            return $Providers;

        } catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something went wrong while sending request. Please try again.');
            }
        }
    }


    /**
     * Forgot Password.
     *
     * @return \Illuminate\Http\Response
     */


    public function forgot_password(Request $request){
            // dd($request->email);
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);
        // $this->validate($request, [
        //         'email' => 'required|email|exists:users,email',
        //     ]);
        if($validator->fails()){
                // return "hello";
                return response()->json(['msg' => "User Not Found"]);
        }

        try{  
            
            $user = User::where('email' , $request->email)->first();

            $otp = mt_rand(100000, 999999);

            $user->otp = $otp;
            $user->save();

            Notification::send($user, new ResetPasswordOTP($otp));

            return response()->json([
                'message' => 'OTP sent to your email!',
                'user' => $user
            ]);

        }catch(Exception $e){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }



    /**
     * Reset Password.
     *
     * @return \Illuminate\Http\Response
     */

    public function reset_password(Request $request){

        $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'id' => 'required|numeric|exists:users,id'
            ]);

        try{

            $User = User::findOrFail($request->id);
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => 'Password Updated']);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    }

    /**
     * help Details.
     *
     * @return \Illuminate\Http\Response
     */

    public function help_details(Request $request){

        try{

            if($request->ajax()) {
                return response()->json([
                    'contact_number' => Setting::get('contact_number',''), 
                    'contact_email' => Setting::get('contact_email','')
                     ]);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    }

    public function createDefaultLocation(Request $request){

        try{
                $count = UserLocationType::where('user_id',Auth::user()->id)->where('location_type',$request->location_type)->count();


          if($count == 0){
            
           $data = UserLocationType::Create($request->all());

            }else{

              UserLocationType::where('user_id',Auth::user()->id)->where('location_type',$request->location_type)->update($request->all());


               }
            if($request->ajax()) {
                return response()->json(['status' =>1,'msg'=>'successfully created']);
            }

        }catch (Exception $e) {
            return $e;
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    }

    public function create_complaint(Request $request) {
        
	
                UserComplaint::Create($request->all());
               
                return response()->json([ 'success' =>'yes','message' => 'Compalint Created Successfuly !' ]);

      

    }
   

	
	
	function test() {
	
	
		$user = User::find(31);
		
		$UserReq = UserRequests::find(370);
		
		 
		(new SendPushNotification)->WalletMoney(31, 50 ); 
		
	/*
		$message = 'sid jangra';
		$to = 'fMT0lMedUYs:APA91bFQt984-yy3U8OvcjrcIrmAWOOZh1KPIDmcWTtegVvKmG2EdYhQM7W2jvbI6sYY6moplk3IQx_GiNPrJBoV0OwKxJKQzY8VY5dQWSJo5vTjriVc4MnZTaf8xwY4LhcEVtDwLxXe';
		$url = 'https://fcm.googleapis.com/fcm/send';

		$fields = array (
				'registration_ids' => array (
						$id
				),
				'notification' => array (
						"message" => $message
				)
		);
		$fields = json_encode ( $fields );

		$headers = array (
				'Authorization: key=' . "AAAADy0gw_I:APA91bHJfnAsBLAqLymWggX-wL4Mej3Lp65JMekHfcCyojUqvwMG2CWrPm89Ggtb2BHifyFF1CETpGgShYm-n11Dtg340ZeWrM4XZD0kNASdlAjaSBaxoz06-od6bHKRClYSOMTv9KC0",
				'Content-Type: application/json'
		);

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

		$result = curl_exec ( $ch );
		 echo $result;
		curl_close ( $ch );
	 
		
		shell_exec('curl -X POST --header "Authorization: key=AAAADy0gw_I:APA91bGBYuwoA6dF1x1bOdYjnyvKPo3IVglGq8SHBSOyOS9HaFr8L39n9P5yhksrNpO_gAgmR30Dahw4YCLMU1za84O-GHKKDJEr8zX--sE1CKr-rdbPhx_LWADCBoMymmoZqypuiaQX" --header "Content-Type: application/json" https://fcm.googleapis.com/fcm/send -d "{\"to\":\"'.$to.'\",\"priority\":\"high\",\"notification\":{\"body\": \"'.stripslashes($message).'\"}}"');
		
		 */
	}
	
	public function match_location(Request $request) {

        $this->validate($request, [
            
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

        try{

            $zones = Zones::orderBy('created_at' , 'desc')->get();
            $Locations = unserialize($zones[0]['coordinate']);
         //   dd($Locations);
         $arr='';
         
            $match = $request->latitude.','.$request->longitude;
            $find = 0;
            foreach($Locations as $loc):
                
               if(strstr($match,substr($loc, 0, ((strpos($loc, '.')+1)+6))) !=false){
                   $find=1;
                   break;
                   
               }
            endforeach;
            
            //$Data = json_encode(array_values($Locations));
            //dd(json_decode($Data));
        
            
            if ($find==1)
            {
              return response()->json(['msg'=>'Data Found']);
            }else{
              return response()->json(['msg'=>'Data Not Found']);
            }
        }

        catch (Exception $e) {
            
            if($request->ajax()){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return back()->with('flash_error', 'Something Went Wrong');
            }
        }

    } 
    
    public function getChat(Request $request){
		
        $this->validate($request, [
                'request_id' => 'required',              
            ]);
			
        $userName = Auth::user()->first_name;
  
        if($request->has('message') && $request->has('provider_id') && $request->has('user_id') && $request->has('type'))   {
            //push notification
          
			(new SendPushNotification)->chatNotifyProvider($request->provider_id,$request->message,$request->request_id,$userName);
			$message = $request->message;
			$msgCreate = Chat::Create([
						'request_id'=>$request->request_id,
						'provider_id'=>$request->provider_id,
						'user_id'=>$request->user_id,
						'message'=>$request->message,
						'type'=>$request->type,
				]);
			}
          
	 	$r = Chat::where('request_id',$request->request_id)->get();
	 	return response()->json(['status'=>1,"data"=>$r]);
	}
	
	public function getLatlngZone_id( $point ) {
		$id = 0;
		$zones = Zones::all(); 
		if( count( $zones ) ) {
			foreach( $zones as $zone ) {
				if( $zone->coordinate ) {
					$coordinate = unserialize( $zone->coordinate );
					$polygon = [];
					foreach( $coordinate as $coord ) {
						$new_coord = explode(",", $coord );
						$polygon[] = $new_coord;
					}
					
					if ( Helper::pointInPolygon($point, $polygon) ) {
						return $zone->id;
					}
				}
			}
		}		
		return $id;		
	}
	
	public function notification(Request $request)
    {
        $id = Auth::user()->id;
        /*$notifications = PushNotification::where('type',1)->whereRaw("find_in_set($id,to_user)")->get();
            
                return response()->json(['Data' =>$notifications]);*/
        try {
            //dd(date('Y-m-d'));
            $notifications = PushNotification::where('type',1)->whereRaw("find_in_set($id,to_user)")->whereDate('expiration_date', '>=', date('Y-m-d'))->orderBy('id','desc')->get();
            return response()->json(['Data' =>$notifications]);
            
        }   catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    
    public function getvalidzone(Request $request)
    {
        $spoint[0]	=	$request->s_latitude; 
		$spoint[1]	=	$request->s_longitude;
		$dpoint[0]	=	$request->d_latitude; 
		$dpoint[1]	=	$request->d_longitude;
		$szone_id	=	$this->getLatlngZone_id($spoint);
		$dzone_id	=	$this->getLatlngZone_id($dpoint);
		
        $szones = Zones::select('status')->where('id',$szone_id)->where('status','active')->first();

		if(count($szones) > 0)
    	{
    	        $dzones = Zones::select('status')->where('id',$dzone_id)->where('status','active')->first();
        		if(count($dzones) > 0)
        		{
        		    return response()->json(['status'=>1,'success' => 'Valid Zones.'], 200);
        		} else{
        		    return response()->json(['status'=>0,'error' => 'Sorry we are not serveing this area.'], 200);
        		}
        }       else{
        		    return response()->json(['status'=>0,'error' => 'Sorry we are not serveing this area.'], 200);
        		}		
    }
    
    
    public function review(Request $request)
    {
        try{
            $review = UserRequestRating::select('user_rating','provider_comment','created_at')->where('user_id',Auth::user()->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            
            return response()->json(['Data' =>$review]);
                
           
            
        } catch(Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    
    public function lost_item(Request $request)
    {
        $this->validate($request, [
                'trip_id' => 'required',              
            ]);
        try{
            $lost_item = LostItem::where('user_id',Auth::user()->id)->where('trip_id',$request->trip_id)
                    ->orderBy('id', 'DESC')
                    ->get();
            
            return response()->json(['Data' =>$lost_item]);
                
           
            
        } catch(Exception $e) {
            //dd($e->getMessage());
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    
    public function add_lost_item(Request $request)
    {

        $this->validate($request, [
                'subject' => 'required|max:255',
                'lost_item' => 'max:255',
                'description' => 'required'
            ]);

         try {
            LostItem::where('user_id', Auth::user()->id)->where('trip_id', $request->trip_id)->delete();
            $message = new LostItem();
            $user = User::where('id',Auth::user()->id)->first();
            $message->user_id       =   $user->id;
            $message->trip_id       =   $request->trip_id;
            $message->name          =   $user->first_name;
            $message->email         =   $user->email;        
            $message->lost_item     =   $request->lost_item;
            $message->subject     =   $request->subject;
            $message->description     =   $request->description;
            $message->phone       =   $user->mobile;
            $message->save();

            if($request->ajax()) {
                return response()->json($message);
            }else{
                return back()->with('flash_success', 'Lost item saved');
            }
        }

        catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.user.user_not_found')], 500);
        }

    }
    
    public function addOrchangeLocation(Request $request) {

        $this->validate($request,[
            'd_address' => 'required',
            'd_latitude' => 'required',
            'd_longitude' => 'required',
            'request_id' => 'required',
            'status'=>'required',
        ]);
 
        try {
            
            // $request = $request->all();
            
            if($request->status === 'CHANGE'){
                
                UserRequests::where('id',$request->request_id)->update([
                                                          'd_address'=>$request->d_address,
                                                          'd_latitude'=>$request->d_latitude,
                                                          'd_longitude'=>$request->d_longitude
                                                          ]);
                $UserRequests = UserRequests::where('id',$request->request_id)->first();
                $message='Destination Location changed By User.';
                $userName='TEST';
                (new SendPushNotification)->changeLocationNotifyProvider($UserRequests['provider_id'],$message,$request->request_id,$userName);                                          
                return response()->json(['status'=>1,'msg'=>'successfully location changed']);
            }
            else{
            
                $data = AddChangeLocation::Create($request->all());
                
                return response()->json(['status'=>1,'msg'=>'successfully added','data'=>$data]);
            }
           
        }   catch (Exception $e) {
            
        }
	}



    public function getRewardHistory(Request $request){
        try {
            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);
            $total_points = Reward::where('user_id',$user_id)->sum('point_earn');
            $used_points = Redeem::where('user_id',$user_id)->sum('redeem_point');
            return response()->json(['balance_points' =>$user->total_points,'total_points'=>$total_points,'used_points'=>$used_points]);
        } catch (Exception $e) {
              return response()->json(['error' => "Something Went Wrong"]);
        }
    }

    public function redeemPoint(Request $request){
        $this->validate($request, [
                'redeem_point' => 'required',              
            ]);
        try {
                $user_id = Auth::user()->id;
                $redeempoint = Setting::get('redeem_amount');
                $min_redeem_point = Setting::get('min_redeem_ammount');
            if($request->redeem_point>=$min_redeem_point){
                $redeemammount = $request->redeem_point * $redeempoint;
                $redeemPoint = new Redeem;
                $redeemPoint->user_id = $user_id;
                $redeemPoint->redeem_point = $request->redeem_point;
                $redeemPoint->redeem_amount = $redeemammount;
                $redeemPoint->save();
                $User = User::findOrFail($user_id);
                $User->wallet_balance = $User->wallet_balance + $redeemammount;
                $total_points = $User->total_points-$request->redeem_point;
                $User->total_points = $total_points;
                $User->save();
                return response()->json(['status' =>1,'msg'=>"Redeem amount added in your wallet"]);
            }else{
                return response()->json(['status' =>0,'msg'=>"You are not eligible for redeem"]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => "Something Went Wrong"]);
        }
    }
    
    public function add_item(Request $request) {
         
        //dd($request->all());
			 $this->validate ($request,[
				'service_type' => 'required',
				/* ['qty' => 'required|numeric'],
				['user_id' => 'required'],  
                ['height' => 'required'],
                ['width' => 'required'],
                ['weight' => 'required'],
                ['rec_name' => 'required'],
                ['rec_mobile' => 'required'] */
				
			]);
			
            //DB::beginTransaction();

         try{
			 
				$image_message='Image Not Processed';
           
		   //if($request->ajax()) {
			 
				$itemd = new Items();
			
                $itemd->name          = (  $request->name  ) ? $request->name : '';
				$itemd->qty           = ( $request->qty ) ? $request->qty : 1;
                $itemd->height        = ($request->height ) ? $request->height : '';
                $itemd->width        = ($request->width ) ? $request->width : '';

                $itemd->rec_name      = ($request->rec_name ) ? $request->rec_name : '';
                $itemd->rec_mobile    = ($request->rec_mobile ) ? $request->rec_mobile : '';
                $itemd->rec_email     = ($request->rec_email ) ? $request->rec_email : '';
                $itemd->rec_address   = ($request->rec_address ) ? $request->rec_address : '';
                $itemd->weight        = ($request->weight ) ? $request->weight : '';
				$itemd->discription   = ($request->discription ) ? $request->discription : '';
				$itemd->special_notes = '';
                $itemd->user_id       = $request->user_id; 
				$itemd->document_type	 =  ( $request->service_type ) ? $request->service_type : '';
            
                $itemd->save();
                //dd($itemd->save());
                $destination = storage_path('app/public/user/item');
                $total=$request->TotalImages;
                if ($request->TotalImages>0) {
                    for($j=0; $j<$total;$j++){
                        $img = 'image'.$j;
                        $images = $request->$img;
                       $image_name = $images->getClientOriginalName();
                        $image_extension = substr($image_name, strpos($image_name, ".") + 1);
                        $file_name =rand().'.'.$image_extension;
                        $images->move($destination,$file_name);
                        //image insertion
                        $insertImage = new Image();
                        $insertImage->image_path=$file_name;
                        $insertImage->save();
                       
                        //image and item relationship
                        $insertImageRelation =new ItemHasImage();
                        $insertImageRelation->item_id = $itemd->id;
                        $insertImageRelation->image_id = $insertImage->id;
                        $insertImageRelation->save();
                    }
                    $image_message = "Images Inserted";
                }
               
                $is_array	=	is_array($request->file('image')) ? 'Array' : 'not an Array';

                if (is_array($request->file('image'))) {
                  
                    foreach($request->file('image') as $image)
                    {
                       
                        $image_name = $image->getClientOriginalName();
                       
                        $image_extension = substr($image_name, strpos($image_name, ".") + 1);
                        $file_name =rand().'.'.$image_extension;
                        $image->move($destination,$file_name);
                        
                        //image insertion
                        $insertImage = new Image();
                        $insertImage->image_path=$file_name;
                        $insertImage->save();
                     
                        //image and item relationship
                        $insertImageRelation =new ItemHasImage();
                        $insertImageRelation->item_id = $itemd->id;
                        $insertImageRelation->image_id = $insertImage->id;
                        $insertImageRelation->save();                    
                    }
                    $image_message = "Images Inserted";
                }   else{
                    $image_message = "Images Not in Array Format";
                }
                //DB::commit();
                return response()->json([
                      'error' =>'no',
					  'success' =>'yes',
					  'item_id'=>$itemd->id,
                      'message' => 'Insert Items',
                      'images'=>$image_message,
                      'request'=>$request->all()
                     ]);
           // }

        }   catch (Exception $e) {
            //DB::rollback();
            return response()->json(['error' =>$e->getMessage() ]);
        } 

    }
	
	public function  itemDetail() {
		 
        try{
            $item = Items::where('user_id' , Auth::user()->id)->orderBy('id','DESC')->first(); 
           $image_ids=ItemHasImage::where('item_id','=',$item->id)->select('image_id')->get()->toArray();
           $image_ids= array_column($image_ids,'image_id');
        
           $images=Image::whereIn('id',$image_ids)->select('image_path')->get()->toArray();
           //print_r($images); die;
            return response()->json([
                'message' => 'user item Details',
                'item' => $item,
                'images'=>$images
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    } 

	public function  itemDetailById(Request $request){
            $all = $request->all();
          
		 
        try{
            $item = Items::find($all['id']); 
          if($item){
			 
			    if($item->image){
					$item->image =asset('storage/app/public/user/item')."/".$item->image;
			    }
            return response()->json([
                'message' => 'user item Details',
                'item' => $item
            ]);
           }else{
                return response()->json([
                'message' => 'user item not found!',
                'item' =>''
            ]);

           }
          

        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    public function zoneSelector($s_latitude,$s_longitude,$d_latitude,$d_longitude){
        $zones=Zones::where("status","active")->get();
        $zone1=null;
        $zone2=null;
        foreach($zones as $zone){
            //if the given addresses is in a zone then proceed else send error

            //first convert the map data in correct form
            $coordinates=unserialize($zone->coordinate);
            $poly=[];
            foreach($coordinates as $index=>$c){
                $val=explode(",",$c);
                $poly[$index]=['lat'=>$val[0],'lng'=>$val[1]];
            }

            //now compare it with the given inputs
            $sCheck=\GeometryLibrary\PolyUtil::containsLocation(
                ['lat' => $s_latitude, 'lng' => $s_longitude],$poly);  
            
            $dCheck=\GeometryLibrary\PolyUtil::containsLocation(
                ['lat' => $d_latitude, 'lng' => $d_longitude],$poly);
            if($sCheck){
                $zone1=$zone;
            }
            if($dCheck){
                $zone2=$zone;
            }  
        }
        return [
            'zone1'=>$zone1->id,
            'zone2'=>$zone2->id
        ];
    }
    public function pending()
    {
        $pending = UserRequests::where('status','PENDING')->groupby('user_id')->get();
        return $pending;
    }

    
    public function send_requestSupport(Request $request) {
        $this->validate($request, [

                's_latitude' 	=> 'required',
                's_longitude' 	=> 'required',
                'd_latitude' 	=> 'required',
                'd_longitude' 	=> 'required',
                'weight'        =>'required',
                'service_type' => 'required|numeric|exists:service_types,id',
                'promo_code' => 'exists:promocodes,promo_code',
                'distance' => 'required|numeric',
                'use_wallet' => 'numeric',
                'payment_mode' => 'required|in:CASH,CARD,PAYPAL,RAZORPAY',
                'card_id' => ['required_if:payment_mode,CARD','exists:cards,card_id,user_id,'.Auth::user()->id],
                'user_id'=>'required',
            
            ]);

       // Log::info('New Request from User: '.Auth::user()->id);
       // Log::info('Request Details:', $request->all());

        //this code makes user to  only request one delivery at a time
            /*
        $ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();

		
        if($ActiveRequests > 0) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.ride.request_inprogress')], 500);
            } else {
                return response()->json(['error' => 'Already request is in progress. Try again later'], 500);
                //return redirect('dashboard')->with('flash_error', 'Already request is in progress. Try again later');
                //dd('hii');
            }
        }

        if($request->has('schedule_date') && $request->has('schedule_time')){
            $beforeschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->subHour(1);
            $afterschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->addHour(1);

            $CheckScheduling = UserRequests::where('status','SCHEDULED')
                            ->where('user_id', Auth::user()->id)
                            ->whereBetween('schedule_at',[$beforeschedule_time,$afterschedule_time])
                            ->count();


            if($CheckScheduling > 0){
                if($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.request_scheduled')], 500);
                }else{
                    return response()->json(['error' => 'Already request is in progress. Try again later'], 500);
                    //return redirect('dashboard')->with('flash_error', 'Already request is Scheduled on this time.');
                }
            }
        }
        */

        $distance = Setting::get('provider_search_radius', '10');
        $service_type = $request->service_type;
		$latitude 	= 0;
		$longitude	= 0;
			
		if( $request->s_latitude &&  $request->s_longitude  ) {
			$latitude 	= $request->s_latitude;
			$longitude	= $request->s_longitude;
        }
        //these codes searches for providers while putting request which is not relevent
        //as we need to add order even if no rider are available
        /*
		
		$Providers = Provider::with('service')
            // ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id')
            ->select()
            ->where('status', 'approved')
            // ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
            ->whereHas('service', function($query) use ($service_type){
                        // $query->whereRaw("(status ='active') or (status='riding' and full=1)");
                        $query->where('service_type_id',$service_type);
            })
            // ->orderBy('distance')
            ->get();

        // List Providers who are currently busy and add them to the filter list.

        if(count($Providers) == 0) {
            if($request->ajax()) {
                // Push Notification to User
                return response()->json(['error' => trans('api.ride.no_providers_found')]); 
            }else{
                return response()->json(['error' => 'No Providers Found! Please try again. asd'.$debug]); 
                //return back()->with('flash_success', 'No Providers Found! Please try again.');
            }
        }
        */

        try{
			
			
			/*
            //$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".env('GOOGLE_MAP_KEY');
            //echo   $details;
		    //$json = curl($details);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $details);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch); 
            $details = json_decode($response, TRUE); 
			
			
            $route_key = $details['routes'][0]['overview_polyline']['points'];
           // echo "<pre/>";
			 //print_r($route_key); die;
			 
			*/
			$route_key =  array();
			$ch = curl_init();
			/*
			Because of ours stupid android developer won't able to send request in array format
			
			for($i = 0; $i < 3; $i++ ) {
				if(  !empty ( $in_request['s_latitude'][$i] ) &&  !empty( $in_request['s_longitude'][$i]) && !empty ( $in_request['d_latitude'][$i] ) && !empty ( $in_request['d_longitude'][$i] ) ) {
					$details = "https://maps.googleapis.com/maps/api/directions/json?origin=". $in_request['s_latitude'][$i] .",". $in_request['s_longitude'][$i] ."&destination=". $in_request['d_latitude'][$i] .",". $in_request['d_longitude'][$i] ."&mode=driving&key=".env('GOOGLE_MAP_KEY');
					$json = curl($details);
					$details = json_decode($json, TRUE);
					$route_key[] = $details['routes'][0]['overview_polyline']['points'];
				}
			}
			*/
            $User = User::findOrFail($request->user_id);
			//location 1
			if(  $request->s_latitude &&  $request->s_longitude &&  $request->d_latitude && $request->d_longitude ) {
				$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".env('GOOGLE_MAP_KEY');
				$json = curl($details);
                $details = json_decode($json, TRUE);
				$route_key[] = isset($details['routes'][0]['overview_polyline']['points'])?$details['routes'][0]['overview_polyline']['points']:null;
			}
            $UserRequest = new UserRequests;
            $UserRequest->booking_id = Helper::generate_booking_id();
            $UserRequest->user_id = $request->user_id;
            $UserRequest->service_type_id = $request->service_type;

            if(isset($request->device)){
                $request->user_id=$request->user_id;
                $json_string=$this->add_item($request);
                $responseItems=json_decode($json_string->content());
                $UserRequest->item_id         = $responseItems->item_id;
            }
            else{
                $UserRequest->item_id         = $request->item_id;
            }
            
            $UserRequest->cod = $request->cod ? $request->cod : '0';
            $UserRequest->special_note = $request->special_note;
            $zones=$this->zoneSelector($request->s_latitude,$request->s_longitude,$request->d_latitude,$request->d_longitude);
            $UserRequest->zone1 = $zones['zone1'];
            $UserRequest->zone2 = $zones['zone2'];
			
            $UserRequest->payment_mode = $request->payment_mode;
            $UserRequest->status = 'PENDING';
            
            $UserRequest->amount_customer= $request->fare - (($User->discount_percentage/100) * $request->fare);
            $UserRequest->fare= $request->fare- (($User->discount_percentage/100) * $request->fare);
            $UserRequest->cargo= $request->cargo;
			
            $UserRequest->s_address = $request->s_address ? $request->s_address : '';
            $UserRequest->d_address = $request->d_address ? $request->d_address : '';
			
            $UserRequest->s_latitude = $request->s_latitude ? $request->s_latitude : 0.00000 ;
            $UserRequest->s_longitude = $request->s_longitude ? $request->s_longitude : 0.00000 ;

            $UserRequest->d_latitude = $request->d_latitude ? $request->d_latitude : 0.00000;
            $UserRequest->d_longitude = $request->d_longitude ? $request->d_longitude : 0.00000;
		    $UserRequest->distance = $request->distance;
			
			$ip_address = ( $request->ajax() ) ? $request->ip_address : $request->ip();
			$UserRequest->request_ip = $ip_address; 

            if(Auth::user()->wallet_balance > 0){
                $UserRequest->use_wallet = $request->use_wallet ? : 0;
            }

            $UserRequest->assigned_at = Carbon::now();
			
            $UserRequest->route_key =  serialize( $route_key );
            $UserRequest->weight =  $request->weight;
            $UserRequest->Pickedup_number =  $request->phone;

            if($request->has('schedule_date') && $request->has('schedule_time')){
                $UserRequest->schedule_at = date("Y-m-d H:i:s",strtotime("$request->schedule_date $request->schedule_time"));
            }

            $UserRequest->save();
			

            // update payment mode 

			
            User::where('id',$request->user_id)->update(['payment_mode' => $request->payment_mode]);
            Items::where('id',$UserRequest->item_id)->update(['request_id' => $UserRequest->id]);
            if($request->has('card_id')){

                Card::where('user_id',$request->user_id)->update(['is_default' => 0]);
                Card::where('card_id',$request->card_id)->update(['is_default' => 1]);
            }
			
            if($request->ajax()) {
				
                return response()->json([
                        'message' => 'New request Created!',
                        'request_id' => $UserRequest->id,
                        'current_provider' => $UserRequest->current_provider_id,
                        'booking_id' => $UserRequest->booking_id,
                        'date' => date("Y/m/d")
                    ]);
            }else{
                return response()->json([
                    'request_id' => $UserRequest->id,
                    'error' => 'dashboard']);
            }

        } catch (Exception $e) {
			echo $e->getMessage(); die;
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }else{
                return response()->json(['error' => 'Something went wrong while sending request. Please try again.'], 500);
            }
        }
    }
    public function bookingDetails($booking_id){
        $UserRequests=UserRequests::where('booking_id',$booking_id)->where('user_id',Auth::user()->id)->get();
        if(!empty($UserRequests)){
            $s_map_icon = asset('asset/img/map-start2.png');
            $d_map_icon = asset('asset/img/marker-stop.png');
            $data=[];
            $index=0;
            foreach ($UserRequests as $key => $value) {
                $UserRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
                        "autoscale=1".
                        "&size=320x130".
                        "&maptype=terrian".
                        "&format=png".
                        "&visual_refresh=true".
                        "&markers=icon:".$s_map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
                        "&markers=icon:".$d_map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
                        "&path=color:0x191919|weight:3|enc:".$value->route_key.
                        "&key=".env('GOOGLE_MAP_KEY');
                $data[$index]['ride']=$value;
                $data[$index]['item']=items::where('id',$value->item_id)->first();
                $data[$index]['comment']=Comment::where('request_id',$value->id)->select('authorised_type','comments')->get();
                if($value->status!="PENDING" && $value->status!="COMPLETED" && $value->status!="REJECTED" && $value->status!="CANCELLED"){
                    $data[$index]['rider']=Provider::where('id',$value->provider_id)
                        ->select(array('first_name','mobile'))
                        ->first();
                }
                else{
                    $data[$index]['rider']=array('first_name'=>null,'mobile'=>null);
                }
                $index++;
            }
        }
        return $data;
    }
    public function promocode($promo_code,$UserRequest){
        if($promo_code->Discount_type=="Percentage"){
          
            if($promo_code->user_type==1 && Auth::user()->Business_Person=="Business"){
              

                $UserRequest->amount_customer= $UserRequest->amount_customer-$promo_code->discount*$UserRequest->amount_customer/100;
            }
            elseif($promo_code->user_type==2 && Auth::user()->Business_Person=="Person"){
            
                $UserRequest->amount_customer= $UserRequest->amount_customer-$promo_code->discount*$UserRequest->amount_customer/100;
            }
            elseif($promo_code->user_type==3){
               
                $UserRequest->amount_customer= $UserRequest->amount_customer-$promo_code->discount*$UserRequest->amount_customer/100;
            }
            else{
                
                return response()->json(['error' =>  'Promocode is not applicable for you'], 500);
            }
        }
        else{
            if($promo_code->user_type==1 && Auth::user()->Business_Person=="Business"){
              

                $UserRequest->amount_customer= $UserRequest->amount_customer-$promo_code->discount;
            }
            elseif($promo_code->user_type==2 && Auth::user()->Business_Person=="Person"){
               
                $UserRequest->amount_customer= $UserRequest->amount_customer-$promo_code->discount;
            }
            elseif($promo_code->user_type==3){
                
                $UserRequest->amount_customer= $UserRequest->amount_customer-$promo_code->discount;
            }
            else{
                
                return response()->json(['error' =>  'Promocode is not applicable for you'], 500);
            }
        }
    }



}
