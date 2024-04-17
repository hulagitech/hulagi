<?php

namespace App\Http\Controllers\DispatcherAuth;

use App\Dispatcher;
use App\DispatcherDevice;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class TokenController extends Controller
{
    public function authenticate(Request $request)
    {
        $this->validate($request, [
                'device_id' => 'required',
                'device_type' => 'required|in:android,ios',
                'device_token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                //'logged_in' => 'required'
            ]);

        Config::set('auth.providers.users.model', 'App\Dispatcher');
        
        $credentials = $request->only('email', 'password');
        $User = Dispatcher::where('email',$request->email)->first();
        try {
            
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'The email address or password you entered is incorrect.'], 401);
            }
            
            // if(isset($User->device) && $User->device->udid != $request->device_id){
                
            //     return response()->json(['error' => 'Provider is not allowed to login on multiple devices .'], 401);
            // }
            /*Provider::where('id',Auth::user()->id)->update([
        
                'logged_in' => $request->logged_in,
            ]);*/
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'Something went wrong, Please try again later!'], 500);
        }
        /*$User = Provider::with('service', 'device')->find(Auth::user()->id);*/
        $User->access_token = $token;
        
        if($User->device) {
            DispatcherDevice::where('id',$User->device->id)->update([
        
                'udid' => $request->device_id,
                'token' => $request->device_token,
                'type' => $request->device_type,
            ]);
            
            
        } else {
            DispatcherDevice::create([
                    'dispatcher_id' => $User->id,
                    'udid' => $request->device_id,
                    'token' => $request->device_token,
                    'type' => $request->device_type,
                ]);
            
        }
        
        return response()->json($User);
    }
}
