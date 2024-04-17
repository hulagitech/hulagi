<?php
namespace App\Http\Controllers\Resource;

use App\City;
use App\Country;
use App\MiniZone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Provider;
use App\State;
use App\UserRequests;
use Illuminate\Support\Facades\DB;
use Auth;
class MiniZoneResource extends Controller
{
    public function index(Request $request)
    {
	    $zones = MiniZone::orderBy('created_at' , 'desc')->get();
	   
        return view('admin.minizone.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
		$all_zones = $this->makeZoesArray();
		//$country = Country::where('id',101)->with('states')->get();
        return view('admin.minizone.create', compact('all_zones'));
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
            'name' => 'required',
			'coordinate'=>'required',
        ]);

        try{
		
			$json = array();
			$id = 0;
			$country = Country::find($request->country,['name']);
			$state = State::find($request->state,['name']);
			$city = City::find($request->city,['name']);
			if( $request->id >  0 ) {
				$zone = MiniZone::where('id', $request->id )->first();
				if( $zone ) {
					$zone->zone_name 	=	$request->name;
					$zone->country 		=	$country->name;
					$zone->state 		=	$state->name;
					$zone->city 		=	$city->name;
					$zone->status 		=	$request->status;
					$zone->currency 	=	$request->currency;
					$zone->coordinate	=	serialize( $request->coordinate);
					$zone->save();

					$id = $zone;
				}
				
			} else {
		
				$zone 				=	new MiniZone;
				$zone->zone_name 	=	$request->name;
				$zone->country 		=	$country->name;
				$zone->state 		=	$state->name;
				$zone->city 		=	$city->name;
				$zone->status 		=	$request->status;
				$zone->currency 	=	$request->currency;
				$zone->coordinate	=	serialize($request->coordinate);
				$zone->save();
				$id = $zone;
			}
			
			$json['status'] = $id;
            return response()->json($json);

        }   catch (Exception $e) {
			
            return response()->json(['error' => $e->getMessage() ]);
        
		}
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $providerDocument
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        try {
			
            $zone = MiniZone::findOrFail($id);
			$zone->coordinate = $this->makeCoordinate( $zone->coordinate );
			
			$all_zones = $this->makeZoesArray();
			
			
			
            return view('admin.minizone.create',compact('zone', 'all_zones'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.minizone.index')->with('flash_error', 'No result found'); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $providerDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		try {
			
			return view('admin.minizone.create');

        } catch (Exception $e) {
            return back()->with('flash_error', 'Zone Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $providerDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		
        try {
			
			$zone = MiniZone::where('id', $id )->first();
			
			if(!$zone) {
				return back()->with('flash_error', 'Zone Not Found');
			}
			
			$provider_zones = DB::table('mini_zones')->where('id', $zone->id )->get()->pluck('id')->toArray();
		
			if( $provider_zones ) {
				
				DB::table('mini_zones')->whereIn('id', $provider_zones)->delete();
			
			}
			
			$zone->delete();
			
            return back()->with('flash_success', 'Zone deleted successfully');
        } 
        catch (Exception $e) {
            
            return back()->with('flash_error', 'Zone Not Found');
        }
    }
	
	
	public function makeZoesArray( ) {
		$all_zones = [];
		$zones_obj = MiniZone::orderBy('created_at' , 'desc')->get();
		if( $zones_obj ) {
			foreach( $zones_obj as $zone ) {
				$all_zones[] = [ 'id' => $zone->id, 'name' => $zone->name, 'latlng' =>  $this->makeCoordinate( $zone->coordinate ) ];
			}
		}
		
		return $all_zones;
		
	}
	
	public function makeCoordinate( $path ) {
		$new_coordiante  = array();
		$coordinate = unserialize( $path );
		foreach( $coordinate as $coord ) {
			$new_coordiante[] = $this->makeLatlng( $coord );
		}
		
		return $new_coordiante;
		
	}
	
	public function makeLatlng( $coord ) {
		$path = explode(',', $coord);
		$latlng['lat'] = $path[0];
		$latlng['lng'] = $path[1];
		
		return  $latlng;
		
		
	}
	public function getCountry(){
		return $country = Country::get();
	}
	public function getState(Request $request){
		
		
		return State::where('country_id',$request->country_id)->get();
			
	}
	public function getCity(Request $request){
        
		return City::where('state_id',$request->state_id)->get();
	}


	public function track(Request $request){
		try {
            if(isset($request->search)){
				$zone=MiniZone::where("id",$request->zone)->first();
				if($request->zone=="-1" || !$zone){
					return back()->with('error',"Select a valid zone");
				}
				if($request->status=="Both"){
					$status=['COMPLETED','REJECTED'];
				}
				else{
					$status=[$request->status];
				}
				if($request->searchField){
					$requests=UserRequests::where('booking_id',"LIKE","%".$request->searchField."%")
								->whereIn('status',$status)
								->get();
					$requests=$requests->filter(function($item) use ($zone,$request){
						return $this->inZone($zone,$item,$request->type);
					});
					// dd($requests);
				}
				else{
					$requests=UserRequests::whereIn('status',$status);
					if($request->rider=="Select Partner"){
						$requests=$requests->get();
					}
					else{
						$requests=$requests->where('provider_id',$request->rider)->get();
					}
					$requests=$requests->filter(function($item) use ($zone,$request){
						return $this->inZone($zone,$item,$request->type);
					});
				}
				$oldQuery=$request->all();
            }
            else{
				$oldQuery=[];
				$requests=[];
			}
			$zones=MiniZone::where('status','active')->get();
			$riders=Provider::where('status','approved')->orderBy('first_name','ASC')->get();
			if(Auth::guard('account')->user()){
                return view('account.track.index', compact(['zones','riders','requests','oldQuery'])); 
            }
			return view('admin.minizone.track', compact(['zones','riders','requests','oldQuery']));
			
        }   catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
	}

	public function inZone(MiniZone $zone, UserRequests $request, $type){
		//if the given addresses is in a zone then proceed else send error

		//first convert the map data in correct form
		$coordinates=unserialize($zone->coordinate);
		$poly=[];
		foreach($coordinates as $index=>$c){
			$val=explode(",",$c);
			$poly[$index]=['lat'=>$val[0],'lng'=>$val[1]];
		}

		//now compare it with the given inputs
		$check=false;
		if($type=="0"){
			$check=\GeometryLibrary\PolyUtil::containsLocation(
				['lat' => $request->s_latitude, 'lng' => $request->s_longitude],$poly);
		}else{
			$check=\GeometryLibrary\PolyUtil::containsLocation(
				['lat' => $request->d_latitude, 'lng' => $request->d_longitude],$poly);
		}
		return $check;
	}
}
