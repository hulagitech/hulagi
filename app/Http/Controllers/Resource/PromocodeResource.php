<?php

namespace App\Http\Controllers\Resource;

use Setting;
use App\User;
use App\Zones;
use App\Reward;
use App\Referral;
use App\Promocode;
use App\promozone;
use App\PromocodeUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PromocodeResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promocodes = Promocode::orderBy('created_at' , 'desc')->get();
        return view('admin.promocode.index', compact('promocodes'));
    }
    
    public function getPromoCodes(){
        return Promocode::orderBy('created_at' , 'desc')->get();
    }
    
    public function userPromoCode(){
        $promocodes = Promocode::orderBy('created_at' , 'desc')->get();
        return view('admin.promocode.users', compact('promocodes'));
    }
    
    public function getPromocodeUser(Request $request){
        return PromocodeUsage::where('promocode_id', $request->promocode_id)->with('promocode','promouser')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zones::orderBy('created_at' , 'desc')->get();
        return view('admin.promocode.create',compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->flash();
        // dd($request->all());
        $this->validate($request, [
            'promo_code' => 'required|max:100',
            'Discount_type' => 'required|not_in:-- Choose Discount Type --',
            'discount' => 'required|numeric',
            'expiration' => 'required',
            'set_limit' => 'required',
            'number_of_time' => 'required',
            'user_type' => 'required|not_in:-- Choose User Type --',
            
            // 'zone' => 'required',
        ]);
        try{
            $request->flash();
            $promocodes=$request->all();
            $promocodes=Promocode::create($promocodes);

            if($request->zone || $request->restricted_zone){
                $zones=explode(',',$request->zone);
                $resticted_zones=explode(',',$request->restricted_zone);
                // dd($zones);
                // dd($resticted_zones);
                    // dd($resticted_zones);
                    if(sizeof($zones)>=sizeof($resticted_zones)){
                        // dd($zones);
                        // dd(isset($resticted_zones[0]));
                        foreach($zones as $index=>$zone){
                            $zone_id=Zones::where('zone_name',$zone)->pluck('id')->first();
                            if($zone_id==null){
                                $zone_id=0;
                            }
                            if(isset($resticted_zones[$index])){
                                $restricted_id=Zones::where('zone_name',$resticted_zones[$index])->pluck('id')->first();
                                if($restricted_id==null){
                                    $restricted_id=0;
                                }
                            }else{
                                    $restricted_id=0;
                            }
                            if($zone_id || $restricted_id){
                                if($index==0){
                                    promozone::where('promocode_id',$promocodes->id)->delete();
                                }
                                // dd($restricted_id);
                                $connDispatch=new promozone;
                                $connDispatch->promocode_id=$promocodes->id;
                                $connDispatch->Zone_id=$zone_id;
                                $connDispatch->Restricted_Zone_id=$restricted_id;
                                $connDispatch->save();
                            }
                        }
                    }
                    else{
                        foreach($resticted_zones as $index=>$resticted_zones){
                            $restricted_id=Zones::where('zone_name',$resticted_zones)->pluck('id')->first();
                            if($resticted_zones==null){
                                $restricted_id=0;
                            }
                            // dd($restricted_id);
                            if(isset($zone_id[$index])) {
                                $zone_id=Zones::where('zone_name',$zones[$index])->pluck('id')->first();
                                if($zone_id==null)
                                {
                                    $zone_id=0;
                                }
                            }
                            else{
                                    $zone_id=0;
                            }
                            // dd($zone_id);
                            if($restricted_id){
                                if($index==0){
                                    promozone::where('promocode_id',$promocodes->id)->delete();
                                }
                                $connDispatch=new promozone;
                                $connDispatch->promocode_id=$promocodes->id;
                                $connDispatch->Zone_id=$zone_id;
                                $connDispatch->Restricted_Zone_id=$restricted_id;
                                $connDispatch->save();
                            }
                        }
                    }
                }
        
            $request->flush();
        return back()->with('flash_success','Promocode Saved Successfully');
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Promocode Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Promocode::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $promocode = Promocode::findOrFail($id);
            // dd($promocode);
            return view('admin.promocode.edit',compact('promocode'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'promo_code' => 'required|max:100',
            'discount' => 'required|numeric',
            'expiration' => 'required',
        ]);

        try {
            if($request->zone || $request->restricted_zone){
                $zones=explode(',',$request->zone);
                $resticted_zones=explode(',',$request->restricted_zone);
                    // dd($resticted_zones);
                    if(sizeof($zones)>=sizeof($resticted_zones)){
                        foreach($zones as $index=>$zone){
                            $zone_id=Zones::where('zone_name',$zone)->pluck('id')->first();
                            if($zone_id==null){
                                $zone_id=0;
                            }
                            if(isset($resticted_zones[$index])){
                                $restricted_id=Zones::where('zone_name',$resticted_zones[$index])->pluck('id')->first();
                                if($restricted_id==null){
                                    $restricted_id=0;}
                            }else{
                                $restricted_id=0;
                            }
                            if($zone_id || $restricted_id){
                                if($index==0){
                                    promozone::where('promocode_id',$id)->delete();
                                }
                                $connDispatch=new promozone;
                                $connDispatch->promocode_id=$id;
                                $connDispatch->Zone_id=$zone_id;
                                $connDispatch->Restricted_Zone_id=$restricted_id;
                                $connDispatch->save();
                            }
                        }
                    }
                    else{
                        foreach($resticted_zones as $index=>$resticted_zones){
                            $restricted_id=Zones::where('zone_name',$resticted_zones)->pluck('id')->first();
                            if($resticted_zones==null){
                                $restricted_id=0;
                            }
                            // dd($restricted_id);
                            if(isset($zone_id[$index])) {
                                $zone_id=Zones::where('zone_name',$zones[$index])->pluck('id')->first();
                                if($zone_id==null)
                                {
                                    $zone_id=0;
                                }
                            }
                            else{
                                    $zone_id=0;
                                }
                            // dd($zone_id);
                            if($restricted_id || $zone_id){
                                if($index==0){
                                    promozone::where('promocode_id',$id)->delete();
                                }
                                $connDispatch=new promozone;
                                $connDispatch->promocode_id=$id;
                                $connDispatch->Zone_id=$zone_id;
                                $connDispatch->Restricted_Zone_id=$restricted_id;
                                $connDispatch->save();
                            }
                        }
                    }
            }

           $promo = Promocode::findOrFail($id);
            $promo->discount = $request->discount;
            $promo->expiration = $request->expiration;
            $promo->save();

            return redirect()->route('admin.promocode.index')->with('flash_success', 'Promocode Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Promocode Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promocode  $promocode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Promocode::find($id)->delete();
            return back()->with('message', 'Promocode deleted successfully');
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Promocode Not Found');
        }
    }

    public function rewardRuleIndex(){   
        // rewarded history;
        $reward_history  =  Reward::all();
        $min_redeem_ammount =  Setting::get('min_redeem_ammount');
        $reward_point = Setting::get('reward_point');
        $redeem_amount = Setting::get('redeem_amount');
        $currency = Setting::get('currency');

        return view('admin.reward.index', compact('reward_history','min_redeem_ammount','reward_point','redeem_amount','currency'));
    }
    
    public function rewardRuleCreate(){   
        // rewarded history;
        $reward_history  =  Reward::all();
        $min_redeem_ammount =  Setting::get('min_redeem_ammount');
        $reward_point = Setting::get('reward_point');
        $redeem_amount = Setting::get('redeem_amount');
        $currency = Setting::get('currency');

        return view('admin.reward.create', compact('reward_history','min_redeem_ammount','reward_point','redeem_amount','currency'));
    }

    public function rewardRuleUpdate(Request $request){   
        // rewarded rule update;
        Setting::set('min_redeem_ammount', $request->min_redeem_ammount);
        Setting::set('reward_point', $request->reward_point);
        Setting::save();
        return back()->with('message', 'Reward Rule Updated successfully');
    }


    public function referralRuleIndex(){   
        // rewarded history;
        $referral_history  =  Referral::/*where('refer_id','!=',0)*/all();
        $referral_discount =  Setting::get('referral_discount');
        return view('admin.referral.index', compact('referral_history','referral_discount'));
    }
    public function referralRuleCreate(){   
        // rewarded history;
        $referral_history  =  User::where('refer_id','!=',0)->get();
        $referral_discount =  Setting::get('referral_discount');
        return view('admin.referral.create', compact('referral_history','referral_discount'));
    }


    public function referralRuleUpdate(Request $request){   
        // rewarded rule update;
        Setting::set('referral_discount', $request->referral_discount);
        Setting::save();
        return back()->with('message', 'Referral Rule Updated successfully');
    }
}
