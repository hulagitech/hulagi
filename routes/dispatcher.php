<?php
// Route::get('/', 'DispatcherController@new_booking')->name('new_booking');

use App\DispatcherToZone;
use App\UserRequests;
use Illuminate\Support\Facades\Auth;

Route::match(array('GET','POST'),'/recent-trips', 'DispatcherController@index')->name('index');
Route::get('/', 'DispatcherNewController@index');

Route::get('map', 'DispatcherController@map_index')->name('map.index');
Route::get('map/ajax', 'DispatcherController@map_ajax')->name('map.ajax');
Route::get('/trip_data','DispatcherController@trip_data');
Route::get('/provider_zones','DispatcherController@getZonesWithProvider');
Route::get('/user','DispatcherController@getUserDetail');

Route::post('/map/dirver/routine','DispatcherController@saveDriverZoneEntertime');
Route::post('/discancel/ride', 'DispatcherController@cancel_ride');
Route::post('/assign/company', 'DispatcherController@assignCompany');
Route::post('/request/update','DispatcherController@update_trip');

Route::resource('service', 'Resource\ServiceResource');
Route::resource('corporate_list', 'Resource\CorporateAccountResource');
Route::get('get-locations/{type?}', 'LiveTrip@index')->name('live.index');
Route::get('get-details/{type}/{id}', 'LiveTrip@getDetailsD')->name('live.details');

Route::group(['as' => 'dispatchList.', 'prefix' => 'dispatchList'], function () {
    Route::get('/', 'DispatcherController@dispatchListIndex')->name('index');
    Route::post('/','DispatcherController@newDispatch')->name('dispatch');
    Route::post('/myDraft/{id}','DispatcherController@my_Draft')->name('myDraft');
    Route::get('/fs', 'DispatcherController@viewDispatch')->name('myDispatch');
    Route::post('/comment/{id}','DispatcherNewController@Dispatchcomment');

    //Route::get('/receivedDispatch', 'DispatcherController@view_receivedDispatch')->name('receivedDispatch');
    Route::get('/completeReached', 'DispatcherController@view_completeReached')->name('completeReached');
    Route::get('/incompleteReached', 'DispatcherController@view_incompleteReached')->name('incompleteReached');

    Route::get('/draft', 'DispatcherController@viewDraft')->name('draft');
    Route::get('/editdraft/{id}', 'DispatcherController@edit_Draft')->name('editDraft');
    Route::post('/myDispatch','DispatcherController@updateDispatch')->name('updateDispatch');
    Route::get('/myDispatch/{id}','DispatcherController@showDetailDispatch')->name('showDispatch');
    Route::get('/myNewDispatch/{id}','DispatcherController@showNewDetailDispatch')->name('showNewDispatch');
    Route::get('/eachCompleteReceived/{id}','DispatcherController@show_eachCompleteReceived')->name('eachCompleteReceived');

    Route::get('/pendingReceive', 'DispatcherController@pendingDispatch')->name('pending');
    Route::post('/pendingReceive/{id}', 'DispatcherController@receivePending_Dispatch')->name('updatePending');
    Route::post('/incompleteCheck/{id}', 'DispatcherController@incompleteCheckReceive')->name('incompleteCheck');
    Route::post('/eachReceive/{id}', 'DispatcherController@eachPendingReceive')->name('eachReceive');
    Route::get('/draftClear/{id}', 'DispatcherController@clearDraft')->name('draftClear');
    Route::match(array('GET','POST'),'/track', 'DispatcherController@track')->name('track');
    //Return Dispatcher
    Route::get('/return','DispatcherController@dispatchReturnIndex')->name('return');
    Route::post('/return','DispatcherController@DispatchReturned')->name('returned');
    Route::get('/ReturnDispatched','DispatcherController@viewReturnDispatch')->name('returnedDispatched'); 
    Route::get('/returnDispatch/{id}','DispatcherController@showReturnDispatch')->name('showReturnDispatch');
    Route::post('/eachReturnReceive/{id}', 'DispatcherController@eachPendingReturnedReceive')->name('eachReturnReceive');

    Route::get('/rejectedReceive','DispatcherController@returnDispatch')->name('returnDispatch');
    Route::post('/pendingRejectedReceive/{id}', 'DispatcherController@receivePending_ReturnDispatch')->name('updateReturnPending');
});

//Route::post('/saveinDraft','DispatcherController@savein_Draft')->name('saveinDraft');ka

Route::get('/dispatchOrders/{id}',function($id){
    $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
    $selectedZones=DispatcherToZone::where('dispatcher_id',$id)->pluck('zone_id')->toArray();
    $requests=UserRequests::where('status','SORTCENTER')
								->whereIn('zone1',$currentZones)
								->whereIn('zone2',$selectedZones)
                                ->pluck('booking_id')
                                ->toArray();
	return response($requests);
});
Route::get('/dispatchOrdersrReturn',function(){
        $currentZones=DispatcherToZone::where('dispatcher_id',Auth::user()->id)->pluck('zone_id')->toArray();
        $requests=UserRequests::where('status','Rejected')->where('returned_to_hub',0)
                                    ->where('returned',0)
                                    ->whereIn('zone2',$currentZones)
                                    ->pluck('booking_id')
                                    ->toArray();
        return response($requests);
});

Route::group(['as' => 'dispatcher.', 'prefix' => 'dispatcher'], function () {
    // Route::get('/', 'DispatcherController@index')->name('index');
    Route::post('/', 'DispatcherController@store')->name('store');
    Route::post('/create/item', 'HomeController@create_item');
    Route::post('/getFare', 'DispatcherController@get_ride_fare')->name('getFare');
    Route::get('/trips', 'DispatcherController@trips')->name('trips');
    Route::get('/single-trip', 'DispatcherController@singleTrip')->name('singleTrip');
    Route::get('/trips/{trip}/{provider}/{type}', 'DispatcherController@assign')->name('assign');
    //Route::get('/dispatch/trips/{trip}/{provider}/{type}', 'DispatcherController@assign')->name('assign');
    Route::get('/users', 'DispatcherController@users')->name('users');
    Route::get('/providers', 'DispatcherController@providers')->name('providers');
    Route::post('/provider_list', 'DispatcherController@providerList')->name('provider_list');
    Route::get('/getlogs','DispatcherController@getlogs');
});

Route::resource('requests', 'Resource\TripResource');
Route::resource('provider', 'Resource\ProviderResource');
Route::group(['as' => 'provider.'], function () {
    Route::get('review/provider', 'AdminController@provider_review')->name('review');
    Route::get('provider/{id}/approve', 'Resource\ProviderResource@approve')->name('approve');
    Route::get('provider/{id}/disapprove', 'Resource\ProviderResource@disapprove')->name('disapprove');
	Route::get('provider/{id}/request', 'Resource\ProviderResource@request')->name('request');
	//Searching inside Rider Details
	Route::post('/riderdetailSearch/{id}','Resource\ProviderResource@searchRiderDetail');
	//.............
	Route::get('provider/{id}/statement', 'Resource\ProviderResource@statement')->name('statement');
	Route::get('provider/{id}/inbound', 'Resource\ProviderResource@inbound')->name('inbound');
    Route::get('provider/{id}/today', 'Resource\ProviderResource@today')->name('today');
    Route::get('provide{id}/payment','Resource\ProviderResource@payment')->name('payment');
	Route::get('provider/{id}/log', 'Resource\ProviderResource@log')->name('log');
	Route::post('provider/log/{id}', 'Resource\ProviderResource@updateLog');
    Route::resource('provider/{provider}/document', 'Resource\ProviderDocumentResource');
    Route::delete('provider/{provider}/service/{document}', 'Resource\ProviderDocumentResource@service_destroy')->name('document.service');
    Route::get('provider/{provider}/document/{document}/upload', 'Resource\ProviderDocumentResource@get_provider_document_upload');
	Route::post('provider/{provider}/document/{document}/upload', 'Resource\ProviderDocumentResource@provider_document_upload');
	Route::get('provider/{provider}/document/{document}/update', 'Resource\ProviderDocumentResource@edit_provider_document_upload');
	Route::post('provider/{provider}/document/{document}/update', 'Resource\ProviderDocumentResource@update_provider_document_upload');
});
Route::get('/providerSearch','Resource\ProviderResource@search');

Route::get('password', 'DispatcherController@password')->name('password');
Route::post('password', 'DispatcherController@password_update')->name('password.update');

Route::get('profile', 'DispatcherController@profile')->name('profile');
Route::post('profile', 'DispatcherController@profile_update')->name('profile.update');
Route::get('/openTicket', 'DispatcherController@openTicket')->name('openTicket');
Route::get('/closeTicket', 'DispatcherController@closeTicket')->name('closeTicket');
Route::get('/ticket-details/{id}', 'DispatcherController@ticketDetails')->name('ticketDetail');
Route::post('/ticket_reply/{id}', 'DispatcherController@replyTickets');
Route::post('/close_ticket/{id}', 'DispatcherController@close_Tickets');
Route::patch('/transfer/{id}', 'DispatcherController@transfer')->name('transfer');
Route::get('/test','DispatcherController@test');

//Dispatcher Bulk Received
Route::get('/completeReceived', 'DispatcherNewController@complete_received');
Route::get('/incompleteReceived', 'DispatcherNewController@incomplete_received');

//Rider Informations.
Route::get('/dispatcher_provider', 'DispatcherNewController@dispatcherProvider');

// Dispatcher SORTCENTER and DELIVERING.
Route::get('/sortcenter', 'DispatcherNewController@dispatcher_sortcenter')->name('sortcenter');
Route::get('/returnRemaining', 'DispatcherNewController@dispatcher_returnRemaining')->name('returnRemaining');
Route::post('/rider_assign/{id}', 'DispatcherNewController@riderAssign');
Route::get('/delivering', 'DispatcherNewController@dispatcher_delivering')->name('delivering');
Route::get('/scheduled', 'DispatcherNewController@dispatcher_scheduled')->name('scheduled');


// Order Comment.
Route::get('/order_comment/{id}', 'DispatcherNewController@orderComment')->name('order_comment');
// Route::post('/order_reply/{id}', 'DispatcherNewController@orderReply');


// Order Comments (Solved/Unsolve)
Route::get('/unsolve_comments', 'DispatcherNewController@unsolve_Comments')->name('unsolve_comments');
Route::get('/solved_comments', 'DispatcherNewController@solved_Comments')->name('solved_comments');
Route::get('/oc_detail/{id}', 'DispatcherNewController@orderComment_Detail')->name('oc_detail');
Route::post('/order_reply/{id}', 'DispatcherNewController@orderCommentReply');
Route::post('/solved/{id}', 'DispatcherNewController@solvedOrder');
Route::post('/unsolve/{id}', 'DispatcherNewController@unsolveOrder');
// Route::post('/edit_dept_order/{id}', 'DispatcherNewController@orderDepartment');

// Order Detail and also its Comments "SORTCENTER and DELIVERING".
Route::get('/order_detail/{id}', 'DispatcherNewController@orders_Detail')->name('order_detail');
// ticket 
// Route::get('/ticket', 'DispatcherController@openTicket')->name('ticket');

//delay serch
Route::match(array('GET','POST'),'delaySearch', 'DispatcherNewController@delaySearch')->name('delaySearch');
Route::get('CustomerQuery','DispatcherNewController@CustomerQuery')->name('CustomerQuery');
Route::get('InactiveOrder','DispatcherNewController@InactiveOrder')->name('InactiveOrder');
 // Payment detail search

//  Route::get(/'payment/{id}');

Route::get('zoneProvider','DispatcherNewController@zoneProvider');


Route::post('/getOrderDetails/{id}', 'DispatcherNewController@getOrderDetails')->name('getOrderDetails');