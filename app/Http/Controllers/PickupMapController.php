<?php

namespace App\Http\Controllers;

use App\User;
use App\Provider;
use App\UserRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RiderLogController;

class PickupMapController extends Controller
{
    public function index($type = null){
        switch($type){
            case "pending":
                return $this->pendingOrders();
                break;
            case "accepted":
                return $this->acceptedOrders();
                break;
            case "pickedup":
                return $this->pickedupOrders();
                break;
            case "partner":
                return $this->driver();
                break;
            default:
                return array_merge($this->pendingOrders(),$this->acceptedOrders(),$this->pickedupOrders(),$this->driver());

        }
    }
    public function pendingOrders()
    {
        $data = UserRequests::where('status','PENDING')
        ->where('s_latitude','!=',0)
        ->where('s_longitude','!=',0)
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->s_latitude;
            $item->longitude = (double)$item->s_longitude;
            $item['icon'] = 'pending';
            return $item;
        });
        return $data->toArray();
    }
    public function driver(){
        $data =  Provider::where('status','!=','banned')->get(['id','latitude','longitude']);
        $data = $data->map(function($item){
            $item->latitude = (double)$item->latitude;
            $item->longitude = (double)$item->longitude;
            $item['icon'] = 'partner';
            return $item;
        });
        return $data->toArray();
    }
    public function acceptedOrders()
    {
        $data = UserRequests::where('status','ACCEPTED')
        ->where('s_latitude','!=',0)
        ->where('s_longitude','!=',0)
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->s_latitude;
            $item->longitude = (double)$item->s_longitude;
            $item['icon'] = 'accepted';
            return $item;
        });
        return $data->toArray();
    }
    public function pickedupOrders()
    {
        $data = UserRequests::where('status','PICKEDUP')
        ->where('s_latitude','!=',0)
        ->where('s_longitude','!=',0)
        ->get();
        $data = $data->map(function($item){
            $item->latitude = (double)$item->s_latitude;
            $item->longitude = (double)$item->s_longitude;
            $item['icon'] = 'pickedup';
            return $item;
        });
        return $data->toArray();
    }

    public function getDetails($type, $id)
    {
        switch($type){
            case "pending":
                return $this->pendingOrdersDetails($id);
                break;
            case "accepted":
                return $this->acceptedOrdersDetails($id);
                break;
            case "pickedup":
                return $this->pickedupOrdersDetails($id);
                break;
            case "partner":
                return $this->driverDetails($id);
                break;
            default:
                return null;

        }
    }

    public function pendingOrdersDetails($id)
    {

        $rq =  UserRequests::find($id);
        $user = User::find($rq->user_id);
        $totalRiders=Provider::select("id","first_name")->where("status","approved")->where('type','pickup')->orderBy('first_name')->get();
        return view('pickup.map.hello',compact('rq','user','totalRiders','id'));
       
    }

    public function acceptedOrdersDetails($id)
    {
        $rq =  UserRequests::find($id);
        
        $user = User::find($rq->user_id);
      
        return   '<div id="siteNotice">'.
            '</div>'.
            '<div id="bodyContent" style="width:250px;">'.
            '<div style="width:100%" class="row">'.
                
                '<div style="position: relative; top: 16px;padding-left:20px;">'.
                    "<h5>".($user->first_name ?? 'Passanger')."</h5>".
                    "<p>Passanger</p>".
                '</div>'.
            '</div><br>'.
            '<div style="width:100%" class="row">'.
                
                '<div style="position: relative; top: 10px; padding-left:20px;">'.
                    "<h5>".($rq->provider->first_name ?? "Driver")."</h5>".
                    "<p>Driver</p>".
                '</div>'.
            '</div><br>'.
            '<div style="width:100%;padding-left:20px;" class="row">'.
                "<p><b>From:</b> {$rq->s_address} </p>".
                "<p><b>To:</b> {$rq->d_address}</p>".
                "<p><b>Status:</b> {$rq->status}</p>".
                
            '</div>'.
            '</div>'.
            '</div>';
    }

    public function pickedupOrdersDetails($id)
    {
        $rq =  UserRequests::find($id);
        $user = User::find($rq->user_id);
        $totalRiders=Provider::select("id","first_name")->where("status","approved")->where('type','pickup')->orderBy('first_name')->get();
        return   '<div id="siteNotice">'.
            '</div>'.
            '<div id="bodyContent" style="width:250px;">'.
            '<div style="width:100%" class="row">'.
                
                '<div style="position: relative; top: 16px;padding-left:20px;">'.
                    "<h5>".($user->first_name ?? 'Passanger')."</h5>".
                    "<h6>".'('.($user->mobile).')'."</h6>".
                    "<p>Passanger</p>".
                '</div>'.
            '</div><br>'.
            '<div style="width:100%" class="row">'.
                
                '<div style="position: relative; top: 10px; padding-left:20px;">'.
                    "<h5>".($rq->provider->first_name ?? "Driver")."</h5>".
                    "<p>Driver</p>".
                '</div>'.
            '</div><br>'.
            '<div style="width:100%;padding-left:20px;" class="row">'.
                "<p><b>From:</b> {$rq->s_address} </p>".
                "<p><b>To:</b> {$rq->d_address}</p>".
                "<p><b>Status:</b> {$rq->status}</p>".
                 
            '</div>'.
            
            '</div>';
    }

    public function driverDetails($id)
    {
        $provider = Provider::find($id);
        $details = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$provider->latitude},{$provider->longitude}&key=".env('GOOGLE_MAP_KEY');
        
            $json = curl($details);

            $details = json_decode($json, TRUE);
           
            $add = $details['results'][0]['formatted_address'];
        return   '<div id="siteNotice">'.
            '</div>'.
            '<div id="bodyContent" style="width:250px;">'.
            '<div style="width:100%" class="row">'.
                '<div style="width:100px%;float:left;padding-left:20px;">'.
                    '<img src="'.('http://quickrideja.com/storage/app/public/'.$provider->avatar ?? 'http://quickrideja.com/storage/app/public/provider/profile/user.png').'" style="width:70px;height:70px;border-radius:50%;">'.
                '</div>'.
                '<div style="position: relative; top: 16px; text-align:center;">'.
                    "<h5>{$provider->first_name}</h5>".
                    "<p>{$add}</p>".
                '</div>'.
            '</div><br>'.
            '<div style="width:100%;padding-left:20px;" class="row">'.
                 '<h5 style="text-align:center;">'.
                 
            '</div>'.
            
            '</div>'.
            '</div>';
    }

    public function assignProvider(Request $request, $user_id)
    {
        try {
            DB::beginTransaction();
            $orders_id = UserRequests::where('user_id',$user_id)
            ->where('status','PENDING')->get();
            $requests = UserRequests::where('user_id', $user_id)
                                        ->where('status','PENDING')->
                                        update(array('provider_id'=>$request->provider_id, 'status'=>"ACCEPTED"));
            foreach($orders_id as $order_id){
                $logRequest=new Request();
                $logRequest->replace([
                    'request_id' => $order_id->id,
                    'pickup_id' =>$request->provider_id,
                    'pickup_remarks' => ""
                ]);
                $riderLog=new RiderLogController;
                $riderLog->create($logRequest);
            }
            DB::commit();
                return response()->json(["success"=>"Rider Assigned Sucessfully"]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error"=>$e->getMessage()]);
        }
    }
}
