<?php

use Illuminate\Support\Facades\Auth;

Route::post('/oauth/token' , 'DispatcherAuth\TokenController@authenticate');

Route::group(['middleware' => ['dispatcher.api']], function () {
    Route::get('dashboard','DispatcherApiController@dashboard');
    Route::get('rider', 'DispatcherApiController@rider');
    Route::post('/logout' , 'DispatcherApiController@logout');
    Route::post('assignRider', 'DispatcherApiController@assignRider');

});
?>