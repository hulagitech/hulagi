<?php


namespace App\Http\Controllers;

use Auth;
use Setting;
use App\Fare;
use App\User;
use App\Zones;
use Validator;
use App\Provider;

use App\Settings;
use App\Promocode;
use App\ServiceType;
use App\PromocodeUsage;
use App\ProviderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AjaxHandlerController extends Controller
{
	
	protected $UserAPI;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI)
    {
        $this->UserAPI = $UserAPI;
    }


  /**
     *  Apply Promo codes promo code.
     *
     * @return \Illuminate\Http\Response
     */

    public function applyPromoCodeOnEstimatedFare(Request $request) {
		
		$validator = Validator::make($request->all(), [
             'promo_code' => 'required|exists:promocodes,promo_code',
           
        ]);
		
		if ($validator->fails()) {
			
				return response()->json([
                        'errors' => $validator->getMessageBag()->toArray(), 
                        'code' => 'request_error'
                    ]);
					
			}
		
		
        try{

            $find_promo = Promocode::where('promo_code',$request->promo_code)->first();

            if($find_promo->status == 'EXPIRED' || (date("Y-m-d") > $find_promo->expiration)){

                if($request->ajax()){

                    return response()->json([
                        'message' => trans('api.promocode_expired'), 
                        'code' => 'promocode_expired'
                    ]);

                }else{
                    return back()->with('flash_error', trans('api.promocode_expired'));
                }

            }elseif(PromocodeUsage::where('promocode_id',$find_promo->id)->where('user_id', Auth::user()->id)->where('status','ADDED')->count() > 0){

                if($request->ajax()) {

                    return response()->json([
                        'message' => trans('api.promocode_already_in_use'), 
                        'code' => 'promocode_already_in_use'
                        ]);

                } else {
                    return back()->with('flash_error', 'Promocode Already in use');
                }

            } else {
				
                // apply promo_code on estimated fare
                $fare =   $this->getEstimatedFare( $request );
                
                if($request->ajax()){

                    return response()->json([
                            'message' 	=> trans('api.promocode_applied') ,
							'fare'		=> $fare,
                            'code' 		=> 'promocode_applied'
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


    public function getEstimatedFare(Request $request ) {
        
        $fare = $this->UserAPI->estimated_fare($request)->getData();	
        $fare->estimated_fare = currency( $fare->estimated_fare );
        
        return $fare;
    
    }



    public function estimated_fare(Request $request) {
        
        $this->validate($request,[
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
        ]);
        

        try{

            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=".env('GOOGLE_MAP_KEY');

            $json = curl($details);

            $details = json_decode($json, TRUE);

            @$meter = $details['rows'][0]['elements'][0]['distance']['value'];

            $fare=0;
            $km=number_format($meter/1000,2);

            if($request->user_id){
                $User=User::where('id',$request->user_id)->get()->first();
            }
            
            //check if the given pickup and destination address lies inside some zone

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
                $sameZone=false;
                //first know if both zones are same. If yes, then apply distance based rates
                if($zone1==$zone2){
                    $fareObj=Fare::where('zone1_id',$zone1->id)
                            ->where('zone2_id',$zone2->id)
                            ->where('km','>',$km)
                            ->orderBy('km','ASC')
                            ->first();
                    $sameZone = true;
                }
                else{
                    if(isset($request->cargo) && $request->cargo=="1"){
                        $fareObj=Fare::where('zone1_id',$zone1->id)
                            ->where('zone2_id',$zone2->id)
                            ->where('cargo','1')
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
                    $percentage=$fareObj->Percentage_increase;
                    if($request->user_id){
                        if($User->Business_Person=="Business"){
                            return response()->json([
                                'estimated_fare' => $fare, 
                                'distance' => $km,
                                'sameZone' => $sameZone,
                                'percentage'=>$percentage,
                            ]);
                        }
                        else{
                            return response()->json([
                                'estimated_fare' => $fare*$percentage/100+$fare, 
                                'distance' => $km,
                                'sameZone' => $sameZone,
                                'percentage'=>$percentage,
                            ]);
                        }
                    }
                    elseif(Auth::user()){
                        if(Auth::user()->Business_Person=="Business"){
                            return response()->json([
                                'estimated_fare' => $fare, 
                                'distance' => $km,
                                'sameZone' => $sameZone,
                                'percentage'=>$percentage,
                            ]);
                        }
                        else{
                            return response()->json([
                                'estimated_fare' => $fare*$percentage/100+$fare, 
                                'distance' => $km,
                                'sameZone' => $sameZone,
                                'percentage'=>$percentage,
                            ]);
                        }
                    }
                    else{
                        return response()->json([
                                'estimated_fare' => $fare, 
                                'distance' => $km,
                                'sameZone' => $sameZone,
                            ]);
                    }
                        
                }   
                else{
                    dd("Fare not found");
                }
            }
            else{
                //invalid area selection: Not in our operation zone
                dd("Zone not found");
            }

        }   catch(Exception $e) {
        	
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
        
        // $this->validate($request,[
        //         's_latitude' => 'required|numeric',
        //         's_longitude' => 'required|numeric',
        //         'd_latitude' => 'required|numeric',
        //         'd_longitude' => 'required|numeric',
        //         'service_type' => 'required|numeric|exists:service_types,id',
        //     ]);

        // try{

        //     $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=".env('GOOGLE_MAP_KEY');

        //     $json = curl($details);

        //     $details = json_decode($json, TRUE);

        //     $meter = $details['rows'][0]['elements'][0]['distance']['value'];
        //     $time = $details['rows'][0]['elements'][0]['duration']['text'];
        //     $seconds = $details['rows'][0]['elements'][0]['duration']['value'];

        //     $kilometer = round($meter/1000);
        //     $minutes = round($seconds/60);

        //     $tax_percentage = Setting::get('tax_percentage');
        //     $commission_percentage = Setting::get('commission_percentage');
        //     $service_type = ServiceType::findOrFail($request->service_type);
		// 	$total_discount = 0;
            
        //     $price = $service_type->fixed;

        //     if($service_type->calculator == 'MIN') {
        //         $price += $service_type->minute * $minutes;
        //     } else if($service_type->calculator == 'HOUR') {
        //         $price += $service_type->minute * 60;
        //     } else if($service_type->calculator == 'DISTANCE') {
        //         $price += ($kilometer * $service_type->price);
        //     } else if($service_type->calculator == 'DISTANCEMIN') {
        //         $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes);
        //     } else if($service_type->calculator == 'DISTANCEHOUR') {
        //         $price += ($kilometer * $service_type->price) + ($service_type->minute * $minutes * 60);
        //     } else {
        //         $price += ($kilometer * $service_type->price);
        //     }

        //     $tax_price = ( $tax_percentage/100 ) * $price;
        //     $total = $price + $tax_price;
			
		// 	//sid
		// 	if ( $request->has('promo_code') ) {
		// 		// Apply  promo code
		// 		if($promo_code =  Promocode::where('promo_code', $request->promo_code)->first() ) {
		// 			$total_discount =  ($total * $promo_code->discount)/100;
		// 			$total = $total - $total_discount; 
		// 		}
		// 	}
		
        //     $ActiveProviders = ProviderService::AvailableServiceProvider($request->service_type)->get()->pluck('provider_id');

        //     $distance = Setting::get('provider_search_radius', '10');
        //     $latitude = $request->s_latitude;
        //     $longitude = $request->s_longitude;

        //     $Providers = Provider::whereIn('id', $ActiveProviders)
        //         ->where('status', 'approved')
        //         ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
        //         ->get();

        //     $surge = 0;
            
        //     if($Providers->count() <= Setting::get('surge_trigger') && $Providers->count() > 0){
        //         $surge_price = (Setting::get('surge_percentage')/100) * $total;
        //         $total += $surge_price;
        //         $surge = 1;
        //     }
            
                
        //     return response()->json([
        //             'estimated_fare' => currency( round($total,2) ), 
        //             'distance' => $kilometer,
        //             'time' => $time,
        //             'surge' => $surge,
        //             'surge_value' => '1.4X',
        //             'tax_price' => $tax_price,
        //             'base_price' => $service_type->fixed,
		// 			'discount'		=> round($total_discount,2)
        //         ]);

        // } catch(Exception $e) {
        //     return response()->json(['error' => trans('api.something_went_wrong')], 500);
        // }
    }   

}

?>