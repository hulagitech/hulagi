<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Setting;
use App\Card;
use App\Items;
use Validator;

class RideController extends Controller
{
protected $UserAPI;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }


    /**
     * Ride Confirmation.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm_ride( Request $request )
    {
        $fare = $this->UserAPI->estimated_fare($request)->getData();
        
        //caculation of custom fare

        if($fare->distance<3){
            $fare->estimated_fare=60;
        }
        else if($fare->distance<4){
            $fare->estimated_fare=70;
        }
        else if($fare->distance<5){
            $fare->estimated_fare=80;
        }
        else if($fare->distance<6){
            $fare->estimated_fare=90;
        }
        else{
            $fare->estimated_fare=115;
        }
        
        // dd($fare);
        if(isset($fare->error) && $fare->error=='dashboard')
        {
            return redirect('dashboard');
        }
        $service = (new Resource\ServiceResource)->show($request->service_type);
        
        $cards =  Card::where('user_id', Auth::user()->id)->get();
		
		$ip 	=   \Request::getClientIp(true);
        $ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
		
        if($request->has('current_longitude') && $request->has('current_latitude'))
        {
            User::where('id',Auth::user()->id)->update([
                'latitude' => $request->current_latitude,
                'longitude' => $request->current_longitude
            ]);
        }

        return view('user.ride.confirm_ride',compact('request','fare','service','cards', 'ip_details'));
    }

    /**
     * Create Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_ride(Request $request)
    {
        $data = $this->UserAPI->send_request($request);
        // dd($data->getData());
        $error=$data->getData();
        if(isset($error->error)){
            // dd("HEY");
            return response()->json(['success' => 'false','error'=> $error->error],500);
        }
        else{
            // dd("HEY");
            if($request->ajax()){
                return response()->json([
                    'success' => 'true',
                    'booking_id' => $data->getData()->booking_id,
                    'date' => $data->getData()->date
                ]);
            }
            if(isset($data->getData()->error) && $data->getData()->error=='dashboard')
            {
                $item=Items::latest()
                    ->first()
                    ->update(['request_id'=> $data->getData()->request_id]);
                return redirect('new_trips')->with('message', 'Order Placed')
                        ->with('s_address_old', $request->s_address)
                        ->with('s_latitude_old', $request->s_latitude)
                        ->with('s_longitude_old', $request->s_longitude);
            }
        }
        return redirect()->back()->with('message', $data->getData()->error ? $data->getData()->error:$data->getData()->flash_error);
    }

    public function Create_rideSupport(Request $request){
        {
            $data = $this->UserAPI->send_requestSupport($request);
            //dd($data->error);
            if($request->ajax()){
                return response()->json([
                    'success' => 'true',
                    'booking_id' => $data->getData()->booking_id,
                    'date' => $data->getData()->date
                ]);
            }
            if(isset($data->getData()->error) && $data->getData()->error=='dashboard')
            {
                $item=Items::latest()
                    ->first()
                    ->update(['request_id'=> $data->getData()->request_id]);
                return redirect('new_trips')->with('message', 'Order Placed')
                        ->with('s_address_old', $request->s_address)
                        ->with('s_latitude_old', $request->s_latitude)
                        ->with('s_longitude_old', $request->s_longitude);
            }
            return redirect()->back()->with('message', $data->getData()->error ? $data->getData()->error:$data->getData()->flash_error);
        }
    }

    
    public function fastCreate(Request $request)
    {
        try{
            $request->request->add([
                'service_type' => 1,
                'payment_mode' => 'CASH'
                ]);
            $validate=Validator::make($request->all(),[
    				'special_note' => '',
    				'cod' => '',
    				'rec_name' => 'required',
    				'rec_mobile' => 'required',
    				's_address' => 'required',
    				'd_address' => 'required',
    				's_latitude' 	=> 'required',
                    's_longitude' 	=> 'required',
                    'd_latitude' 	=> 'required',
                    'd_longitude' 	=> 'required',
                    // 'service_type' => 'required|numeric|exists:service_types,id',
                    // 'promo_code' => 'exists:promocodes,promo_code',
                    // 'use_wallet' => 'numeric',
                    // 'payment_mode' => 'required|in:CASH,CARD,PAYPAL,RAZORPAY',
                    'card_id' => ['required_if:payment_mode,CARD','exists:cards,card_id,user_id,'.Auth::user()->id],
    				'device' => 'required',
                    ]);
            if($validate->fails()){
                return response()->json(['error' => $validate->messages()]);}
            if(Auth::user()->settle==1){
                return response()->json(['error' => 'Your Account Has been Settled.Please Contact Hulagi For More Details']);
            }
    		$ajaxController= new AjaxHandlerController($this->UserAPI);
            $fares= $ajaxController->estimated_fare($request);
            $request->request->add([
                'distance' => $fares->getData()->distance,
                'fare' => $fares->getData()->estimated_fare,
                ]);
    		$data = $this->UserAPI->send_request($request);
            if(isset($data->getData()->error) && $data->getData()->error=='dashboard')
            {
                if($request->ajax()){
                    return response()->json([
                        'success' => 'true'
                    ]);
                }
                $item=Items::latest()
                    ->first()
                    ->update(['request_id'=> $data->getData()->request_id]);
                return response()->json([
                        'success' => 'true'
                    ]);
            }
            return response()->json(['error' =>"Yes" ]);
        }
        catch (Exception $e) {
            return response()->json(['error' =>$e->getMessage() ]);
        } 
    }
    
    /**
     * Get Request Status Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        return $this->UserAPI->request_status_check($request);
    }

    /**
     * Cancel Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel_ride(Request $request)
    {
        return $this->UserAPI->cancel_request($request);
    }

    /**
     * Rate Ride.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request)
    {
        return $this->UserAPI->rate_provider($request);
    }
}
