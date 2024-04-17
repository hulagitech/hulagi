<?php
Route::get('/dashboard', 'SortCenterController@dashboard')->name('dashboard');
Route::match(array('GET','POST'),'dateSearch', 'Resource\SortCenterTripResourceController@dateSearch')->name('dateSearch');
Route::post('requests/{id} ', 'Resource\SortCenterTripResourceController@update');
Route::post('riderAssign/{id} ', 'SortCenterController@riderAssign');

Route::get('allinbound', 'Resource\SortCenterTripResourceController@all_inbound')->name('inbound');
Route::get('bulk/inbound', 'Resource\SortCenterTripResourceController@bulk_inbound')->name('bulk_inbound');
Route::post('bulk/inbound', 'Resource\SortCenterTripResourceController@bulk_inbound_post')->name('bulk_inbound_post');
Route::get('rider', 'Resource\SortCenterTripResourceController@rider')->name('rider');
Route::get('searchRider','Resource\SortCenterTripResourceController@searchRider');
Route::get('rider/{id}/{status}', 'Resource\SortCenterTripResourceController@order');
Route::get('outbound', 'Resource\SortCenterTripResourceController@outbound')->name('outbound');
Route::post('outbound', 'Resource\SortCenterTripResourceController@newOutbound');
Route::get('inbound','Resource\SortCenterTripResourceController@inBound');
Route::get('vendorInbound/{id}', 'SortCenterController@all_vendor')->name('vendorInbound');
Route::post('/inbound_order/{id}', 'Resource\SortCenterTripResourceController@inboundOrder')->name('requests.inbound_order');

Route::get('/sortcenterOrders','Resource\SortCenterTripResourceController@sortCenterOrders');

Route::get('inside-valley', 'Resource\SortCenterTripResourceController@insideValley')->name('inside_valley');
Route::get('show/{id}', 'Resource\SortCenterTripResourceController@show')->name('order_details');
Route::post('hold', 'SortCenterController@hold')->name('hold');
Route::post('/comments/{id}', 'Resource\SortCenterTripResourceController@commentSortcenter');
Route::post('printInvoice', 'InvoiceController@sortcenter_invoice')->name('bulkinvocie');
Route::post('printInvoice/{id}', 'InvoiceController@singleSortCenterInvoice')->name('singleinvoice');


//exchange Order 
Route::Post('exchangeOrder','Resource\SortCenterTripResourceController@exchangeOrder');


//Ticket 
Route::get('newticket', 'SortcenterTicketController@add_newTicket')->name('newticket');
Route::get('/searchUser', 'SortcenterTicketController@search_user');
Route::get('/user_add_ticket/{id}', 'SortcenterTicketController@ticket_add');
Route::post('/create_ticket', 'SortcenterTicketController@save_user_ticket');
Route::get('/opentickets', 'SortcenterTicketController@openTickets')->name('opentickets');
Route::get('/ticket_comment/{id}', 'SortcenterTicketController@commentTickets');
Route::post('/close_ticket/{id}', 'SortcenterTicketController@close_Tickets');
Route::post('/ticket_reply/{id}', 'SortcenterTicketController@replyTickets');
//comment
Route::get('/sortcenterUnsolveComment', 'SortcenterTicketController@sortcenterUnsolve');
Route::get('/ktmdeliveryreamining','Resource\SortCenterTripResourceController@ktm');
//cargo
Route::post('/changeCargo/{id}', 'SortcenterTicketController@change_cargo');

//profile

Route::get('profile', 'SortCenterController@profile')->name('profile');
Route::post('profile', 'SortCenterController@profile_update')->name('profile.update');

Route::get('password', 'SortCenterController@password')->name('password');
Route::post('password', 'SortCenterController@password_update')->name('password.update');