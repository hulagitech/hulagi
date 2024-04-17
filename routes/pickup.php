<?php 
Route::get('/dashboard', 'PickupController@dashboard')->name('dashboard');
Route::match(array('GET','POST'),'dateSearch', 'Resource\PickupTripResourceController@dateSearch')->name('dateSearch');
Route::get('pickup/remaining', 'Resource\PickupTripResourceController@pickupRemaining')->name('remaining');

Route::post('requests/{id}','Resource\PickupTripResourceController@update');
Route::get('show/{id}', 'Resource\PickupTripResourceController@show')->name('order_details');
Route::post('/comments/{id}', 'Resource\PickupTripResourceController@pickupComment');
//Map Routes
Route::get('map', 'PickupController@mapView')->name('map.view');
Route::get('get-locations/{type?}', 'PickupMapController@index')->name('map.show');
Route::get('get-details/{type}/{id}', 'PickupMapController@getDetails')->name('live.details');
Route::post('map/rider/{id}', 'PickupMapController@assignProvider')->name('edit.provider');


//Bulk Assign Routes
Route::get('/bulkAssign','Resource\PickupTripResourceController@bulkAssign')->name('orders.bulkassign');
Route::get('vendorAssign/{id}','Resource\PickupTripResourceController@vendorAssign')->name('vendorAssign');
Route::post('bulkAssign/{id}', 'Resource\PickupTripResourceController@storeBulkAssign')->name('bulkassign');

//Ticket Routes
Route::get('newticket', 'PickupTicketController@add_newTicket')->name('newticket');
Route::get('/searchUser', 'PickupTicketController@search_user');
Route::get('/user_add_ticket/{id}', 'PickupTicketController@ticket_add');
Route::post('/create_ticket', 'PickupTicketController@save_user_ticket');
Route::get('/opentickets', 'PickupTicketController@openTickets')->name('opentickets');
Route::get('/ticket_comment/{id}', 'PickupTicketController@commentTickets');
Route::post('/close_ticket/{id}', 'PickupTicketController@close_Tickets');
Route::post('/ticket_reply/{id}', 'PickupTicketController@replyTickets');

//comment
Route::get('/pickupUnsolveComment', 'PickupTicketController@pickupUnsolve');

//pickup_user

Route::get('profile', 'PickupController@profile')->name('profile');
Route::post('profile', 'PickupController@profile_update')->name('profile.update');

Route::get('password', 'PickupController@password')->name('password');
Route::post('password', 'PickupController@password_update')->name('password.update');

//User Details
Route::resource('user', 'Resource\SupportVendorController');
Route::get('user/{id}/order','Resource\SupportVendorController@order')->name('user.order');
Route::get('/userSearch','Resource\SupportVendorController@search');
Route::post('changeuserpassword', 'SupportController@changeuserpassword')->name('changeuserpassword');
Route::get('user/{id}/request', 'Resource\SupportVendorController@request')->name('user.request');


//order 
Route::post('/create/item', 'HomeController@create_item');
Route::get('/confirm/ride', 'RideController@confirm_ride');
Route::post('/create/ride', 'RideController@Create_rideSupport');
Route::post('/get_fare', 'AjaxHandlerController@estimated_fare')->name('getfare');
Route::get('/check-phone/{number}','HomeController@checkPhone');

//pickup rider
Route::get('pickupRider','PickupController@pickedupRider')->name('rider.index');
Route::get('riderSearch','PickupController@searchRider');
Route::get('/pickupRider/remaining/{id}/{status}', 'PickupController@returnRemaining')->name('rider.remaining');

//print bulk according to rider
Route::get('RiderInbound/{id}', 'PickupController@all_vendor')->name('riderInbound');
Route::post('printInvoice', 'InvoiceController@pickup_invoice')->name('bulkinvocie');
Route::post('/changeCargo/{id}', 'PickupController@change_cargo');
