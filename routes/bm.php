<?php


Route::group(['as' => 'bm.', 'prefix' => 'bm'], function () {
	// Route::get('/', 'SupportController@index')->name('index');
Route::get('/', 'BmController@dashboard')->name('index');
Route::get('/dashboard', 'BmController@dashboard')->name('dashboard');
Route::get('profile', 'BmController@profile')->name('profile');
Route::post('profile', 'BmController@profile_update')->name('profile.update');
	
});

// Route::get('/', 'BmController@index')->name('index');

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', 'BmController@dashboard')->name('index');
Route::get('/dashboard', 'BmController@dashboard')->name('dashboard');

 
// Profile
Route::get('profile', 'BmController@profile')->name('profile');
Route::post('profile', 'BmController@profile_update')->name('profile.update');

Route::get('password', 'BmController@password')->name('password');
Route::post('password', 'BmController@password_update')->name('password.update');

// Order Comments (Solved/Unsolve)
Route::get('/unsolve_comments', 'BmController@unsolve_Comments')->name('unsolve_comments');
Route::get('/solved_comments', 'BmController@solved_Comments')->name('solved_comments');
Route::get('/oc_detail/{id}', 'BmController@orderComment_Detail');
Route::post('/order_reply/{id}', 'BmController@orderCommentReply');
Route::post('/solved/{id}', 'BmController@solvedOrder');
Route::post('/unsolve/{id}', 'BmController@unsolveOrder');
Route::post('/edit_dept_order/{id}', 'BmController@orderDepartment');

//branch Comment

Route::get('/branch_solve_comments', 'BmController@branchSloveComments')->name('branchComment');

Route::get('/branch_unsolve_comments', 'BmController@branchUnsolveComments')->name('branch_unsolve_Comments');

// Today's Tickets List and Its comment
Route::get('/todaytickets', 'TicketCommentController@bm_todayTickets')->name('todaytickets');
Route::get('/today_ticket_detail/{id}', 'TicketCommentController@bm_tdetailTickets');
Route::post('/today_close_ticket/{id}', 'TicketCommentController@bm_tcloseTickets');

// All Tickets List and Its comment
Route::get('/opentickets', 'TicketCommentController@bm_allTickets')->name('opentickets');
Route::get('/ticket_detail/{id}', 'TicketCommentController@bm_detailTickets');
Route::post('/close_ticket/{id}', 'TicketCommentController@bm_closeTickets');

// Tickets Comment Reply
Route::post('/ticket_reply/{id}', 'TicketCommentController@bm_replyTickets');

//Provider
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
Route::get('provider','BmController@Provider')->name('provider');

Route::get('zoneProvider','BmController@zoneProvider');
Route::resource('requests', 'Resource\TripResource');


//To show the Details

Route::match(array('GET','POST'),'/recent-trips', 'BmController@RecentTrips')->name('recenttrips');

// List Of bm SORTCENTER and DELIVERING.
Route::get('/sortcenter', 'BmController@bm_sortcenter')->name('sortcenter');
Route::get('/returnRemaining', 'BmController@dispatcher_returnRemaining')->name('returnRemaining');
Route::post('/rider_assign/{id}', 'BmController@riderAssign');
Route::get('/delivering', 'BmController@dispatcher_delivering')->name('delivering');
Route::get('/scheduled', 'BmController@dispatcher_scheduled')->name('scheduled');

// Order Detail and also its Comments "SORTCENTER and DELIVERING".

Route::get('/order_detail/{id}', 'BmController@orders_Detail')->name('order_detail');

//delay serch

Route::match(array('GET','POST'),'delaySearch', 'BmController@delaySearch')->name('delaySearch');
Route::get('CustomerQuery','BmController@CustomerQuery')->name('CustomerQuery');
Route::get('InactiveOrder','BmController@InactiveOrder')->name('InactiveOrder');
Route::post('/getOrderDetails/{id}', 'BmController@getOrderDetails')->name('getOrderDetails');


Route::resource('requests', 'Resource\TripResource');

Route::group(['as' => 'dispatchList.', 'prefix' => 'dispatchList'], function () {
    Route::get('/', 'bmController@dispatchListIndex')->name('index');
    Route::post('/','bmController@newDispatch')->name('dispatch');
    Route::post('/myDraft/{id}','bmController@my_Draft')->name('myDraft');
    Route::get('/fs', 'bmNewController@viewDispatch')->name('myDispatch');
    Route::post('/comment/{id}','bmController@Dispatchcomment');

    //Route::get('/receivedDispatch', 'bmController@view_receivedDispatch')->name('receivedDispatch');
    Route::get('/completeReached', 'bmNewController@view_completeReached')->name('completeReached');
    Route::get('/incompleteReached', 'bmNewController@view_incompleteReached')->name('incompleteReached');

    Route::get('/draft', 'bmNewController@viewDraft')->name('draft');
    Route::get('/editdraft/{id}', 'bmController@edit_Draft')->name('editDraft');
    Route::post('/myDispatch','bmController@updateDispatch')->name('updateDispatch');
    Route::get('/myDispatch/{id}','bmNewController@showDetailDispatch')->name('showDispatch');
    Route::get('/myNewDispatch/{id}','bmNewController@showNewDetailDispatch')->name('showNewDispatch');
    Route::get('/eachCompleteReceived/{id}','bmNewController@show_eachCompleteReceived')->name('eachCompleteReceived');

    Route::get('/pendingReceive', 'bmNewController@pendingDispatch')->name('pending');
    Route::post('/pendingReceive/{id}', 'bmNewController@receivePending_Dispatch')->name('updatePending');
    Route::post('/incompleteCheck/{id}', 'bmController@incompleteCheckReceive')->name('incompleteCheck');
    Route::post('/eachReceive/{id}', 'bmController@eachPendingReceive')->name('eachReceive');
    Route::get('/draftClear/{id}', 'bmController@clearDraft')->name('draftClear');
    Route::match(array('GET','POST'),'/track', 'bmNewController@track')->name('track');
    //Return bm
    Route::get('/return','bmController@dispatchReturnIndex')->name('return');
    Route::post('/return','bmController@DispatchReturned')->name('returned');
    Route::get('/ReturnDispatched','bmNewController@viewReturnDispatch')->name('returnedDispatched'); 
    Route::get('/returnDispatch/{id}','bmController@showReturnDispatch')->name('showReturnDispatch');
    Route::post('/eachReturnReceive/{id}', 'bmController@eachPendingReturnedReceive')->name('eachReturnReceive');

    Route::get('/rejectedReceive','bmNewController@returnDispatch')->name('returnDispatch');
    Route::post('/pendingRejectedReceive/{id}', 'bmController@receivePending_ReturnDispatch')->name('updateReturnPending');
});
Route::get('/openTicket', 'bmNewController@openTicket')->name('openTicket');
Route::get('/closeTicket', 'bmNewController@closeTicket')->name('closeTicket');
Route::get('/completeReceived', 'bmNewController@complete_received');
Route::get('/incompleteReceived', 'bmNewController@incomplete_received');
Route::get('/eachCompleteReceived/{id}','bmNewController@show_eachCompleteReceived')->name('eachCompleteReceived');
Route::get('/incompleteReceived/{id}', 'bmNewController@incomplete_received');

//for pickup of Zone
Route::get('bulkassign', 'bmNewController@bulkassign')->name('bulkassign');
Route::get('vendorAssign/{id}','bmNewController@vendorAssign')->name('vendorAssign');



//order 
Route::post('/create/item', 'HomeController@create_item');
Route::get('/confirm/ride', 'RideController@confirm_ride');
Route::post('/create/ride', 'RideController@Create_rideSupport');
Route::post('/get_fare', 'AjaxHandlerController@estimated_fare')->name('getfare');
Route::get('/check-phone/{number}','HomeController@checkPhone');


//User 
Route::resource('user', 'Resource\bmUserResource');
Route::get('user/{id}/order','Resource\bmUserResource@order')->name('user.order');
Route::get('/userSearch','Resource\bmUserResource@search');
Route::post('changeuserpassword', 'bmUserResource@changeuserpassword')->name('changeuserpassword');
Route::get('user/{id}/request', 'Resource\bmUserResource@request')->name('user.request');