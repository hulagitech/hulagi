<?php


Route::group(['as' => 'support.', 'prefix' => 'support'], function () {
	// Route::get('/', 'SupportController@index')->name('index');
Route::get('/', 'SupportController@dashboard')->name('index');
Route::get('/dashboard', 'SupportController@dashboard')->name('dashboard');
Route::get('profile', 'SupportController@profile')->name('profile');
Route::post('profile', 'SupportController@profile_update')->name('profile.update');
	
});

// Route::get('/', 'SupportController@index')->name('index');

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', 'SupportController@dashboard')->name('index');
Route::get('/dashboard', 'SupportController@dashboard')->name('dashboard');
//

 
// Profile
Route::get('profile', 'SupportController@profile')->name('profile');
Route::post('profile', 'SupportController@profile_update')->name('profile.update');

Route::get('password', 'SupportController@password')->name('password');
Route::post('password', 'SupportController@password_update')->name('password.update');

// Query
Route::get('/open-ticket/{type}', 'SupportController@openTicket')->name('openTicket');
Route::get('/close-ticket', 'SupportController@closeTicket')->name('closeTicket');
Route::get('/open-ticket-details/{id}', 'SupportController@openTicketDetails')->name('openTicketDetails');
Route::patch('/transfer/{id}', 'SupportController@transfer')->name('transfer');
Route::resource('bank', 'Resource\SupportBankResource');

// Settlement
Route::resource('new_account', 'Resource\SupportBankResource@new_account');
Route::get('approved_account', 'Resource\SupportBankResource@approved_account');
Route::get('new_withdraw', 'Resource\SupportBankResource@new_withdraw');
Route::get('approved_withdraw', 'Resource\SupportBankResource@approved_withdraw');
Route::get('disapproved_withdraw', 'Resource\SupportBankResource@disapproved_withdraw');

// Order Comments (Solved/Unsolve)
Route::get('/allorder/comment', 'SupportCommentController@allOrderComment');
Route::get('/supportComment', 'SupportCommentController@supportComment');
Route::get('/allorder/comment/{id}', 'SupportCommentController@all_comment');
Route::post('/order_reply/{id}', 'SupportCommentController@cs_orderReply');
//Route::get('/neworder/comment', 'SupportCommentController@todayOrderComment');
Route::get('/solved_comment', 'SupportCommentController@solved_Comments');
Route::post('/solve_comment/{id}', 'SupportCommentController@solve_Comment');
Route::post('/unsolve_comment/{id}', 'SupportCommentController@unsolve_Comment');


// Order
// Route::get('/cs_dateSearch', 'SupportController@cs_orderSearch');
Route::match(array('GET','POST'),'dateSearch', 'SupportController@dateSearch')->name('requests.dateSearch');
// Route::get('allRequests', 'SupportController@allRequests')->name('requests.allRequests');


// Ticket Comments
Route::get('/add_newticket', 'SupportCommentController@add_newTicket');
Route::get('/searchUser', 'SupportCommentController@search_user');
Route::get('/user_all_tickets/{id}', 'SupportCommentController@user_AllTickets');
Route::get('/user_ticket_comment/{id}', 'SupportCommentController@user_commentTickets');
Route::post('/user_closeOpen/{id}', 'SupportCommentController@user_close_open');

Route::get('/user_add_ticket/{id}', 'SupportCommentController@ticket_add');
Route::post('/create_ticket', 'SupportCommentController@save_user_ticket');

Route::get('/todaytickets', 'SupportCommentController@todayTickets');
Route::get('/opentickets', 'SupportCommentController@openTickets');
Route::get('/closetickets', 'SupportCommentController@closeTickets');
Route::get('/today_ticket_comment/{id}', 'SupportCommentController@today_commentTickets');
Route::get('/ticket_comment/{id}', 'SupportCommentController@commentTickets');
Route::post('/ticket_reply/{id}', 'SupportCommentController@replyTickets');
Route::post('/today_close_ticket/{id}', 'SupportCommentController@today_close_Tickets');
Route::post('/close_ticket/{id}', 'SupportCommentController@close_Tickets');
Route::post('/open_ticket/{id}', 'SupportCommentController@open_Tickets');

// Edit Department from CS.
Route::post('/edit_department/{id}', 'SupportCommentController@ticketDepartment');

// Edit Department from Order Comments.
Route::post('/edit_dept_order/{id}', 'SupportCommentController@orderDepartment');

// Edit Receiver Number of "Order By Date".
Route::post('/dropoff_no/{id}', 'SupportController@dropoffNo');
Route::post('/status/{id}', 'SupportController@statusChange');
//  cargo 
Route::post('/changeCargo/{id}', 'SupportController@change_cargo');
//order details
Route::get('show/{id}', 'SupportController@show')->name('order_details');
Route::post('/comments/{id}', 'SupportController@supportComment');

//user 
Route::resource('user', 'Resource\SupportVendorController');
Route::get('user/{id}/order','Resource\SupportVendorController@order')->name('user.order');
Route::get('/userSearch','Resource\SupportVendorController@search');
Route::post('changeuserpassword', 'SupportController@changeuserpassword')->name('changeuserpassword');
Route::get('user/{id}/request', 'Resource\SupportVendorController@request')->name('user.request');

//provider 
Route::resource('provider', 'Resource\SupportProviderController');
Route::get('/providerSearch','Resource\SupportProviderController@search');
Route::get('provider/{id}/approve', 'Resource\SupportProviderController@approve')->name('approve');
Route::get('provider/{id}/disapprove', 'Resource\SupportProviderController@disapprove')->name('disapprove');
Route::post('changeprovidorpassword', 'Resource\SupportProviderController@changeprovidorpassword')->name('SupportproviderController');
//fare
Route::get('/fare','Resource\SupportProviderController@fare')->name('fare');

//order 
Route::post('/create/item', 'HomeController@create_item');
Route::get('/confirm/ride', 'RideController@confirm_ride');
Route::post('/create/ride', 'RideController@Create_rideSupport');
Route::post('/get_fare', 'AjaxHandlerController@estimated_fare')->name('getfare');
Route::get('/check-phone/{number}','HomeController@checkPhone');