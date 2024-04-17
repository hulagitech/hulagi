<?php


Route::group(['as' => 'return.', 'prefix' => 'return'], function () {
	// Route::get('/', 'SupportController@index')->name('index');
	
	Route::get('/', 'ReturnController@dashboard')->name('index');
	Route::get('/dashboard', 'ReturnController@dashboard')->name('dashboard');
	Route::get('profile', 'ReturnController@profile')->name('profile');
	Route::post('profile', 'ReturnController@profile_update')->name('profile.update');



	
});
Route::post('requests/{id} ', 'ReturnController@update');
// Route::get('/', 'ReturnController@index')->name('index');

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', 'ReturnController@dashboard')->name('index');
Route::get('/dashboard', 'ReturnController@dashboard')->name('dashboard');

 
// Profile
Route::get('profile', 'ReturnController@profile')->name('profile');
Route::post('profile', 'ReturnController@profile_update')->name('profile.update');

Route::get('password', 'ReturnController@password')->name('password');
Route::post('password', 'ReturnController@password_update')->name('password.update');

// Return Orders
Route::get('tobereturn', 'ReturnController@tobe_return')->name('tobereturn');
Route::match(array('GET','POST'),'inboundSearch', 'ReturnController@inboundSearch')->name('inboundSearch');
Route::post('/order_inhub/{id}', 'ReturnController@orderIn_hub')->name('order_inhub');
Route::get('allOrder_inHub', 'ReturnController@allorder_inhub')->name('allOrder_inHub');
Route::post('/returnRider/{id}', 'ReturnController@return_Rider');
Route::post('/returnCompleted/{id}', 'ReturnController@return_completed')->name('returnCompleted');
Route::post('/returnInCompleted/{id}', 'ReturnController@return_incompleted')->name('returnInCompleted');
Route::get('returnedOrder', 'ReturnController@returned_order')->name('returnedOrder');
Route::get('details/{id}', 'ReturnController@return_details')->name('details');
Route::post('hold/{id}', 'ReturnController@hold')->name('hold');
Route::match(array('GET','POST'),'dateSearch', 'ReturnController@dateSearch')->name('dateSearch');
Route::get('show/{id}', 'ReturnController@show')->name('order_details');
Route::post('/comments/{id}', 'ReturnController@returnComment');
Route::get('/inbound', 'ReturnController@return_inbound')->name('return_inbound');
Route::post('/inbound', 'ReturnController@return_inbound_post')->name('return_inbound');
Route::get('/delaysearch', 'ReturnController@delaysearch')->name('returndelay');
Route::get('/outsidereturnOrder','ReturnController@outsideReturnOrder')->name('returOutside');


// Today's Tickets List and Its comment
Route::get('/todaytickets', 'TicketCommentController@return_todayTickets')->name('todaytickets');
Route::get('/today_ticket_detail/{id}', 'TicketCommentController@return_tdetailTickets');
Route::post('/today_close_ticket/{id}', 'TicketCommentController@return_tcloseTickets');

// All Tickets List and Its comment
Route::get('newticket', 'TicketCommentController@add_newTicket')->name('newticket');
Route::get('/searchUser', 'TicketCommentController@search_user');
Route::get('/user_add_ticket/{id}', 'TicketCommentController@ticket_add');
Route::post('/create_ticket', 'TicketCommentController@save_user_ticket');
Route::get('/opentickets', 'TicketCommentController@return_allTickets')->name('opentickets');

// Route::get('/opentickets', 'TicketCommentController@return_allTickets')->name('opentickets');
Route::get('/ticket_detail/{id}', 'TicketCommentController@return_detailTickets');
Route::post('/ticket_reply/{id}', 'TicketCommentController@return_replyTickets');
Route::post('/close_ticket/{id}', 'TicketCommentController@return_closeTickets');

// Tickets Comment Reply

// Order Comments (Solved/Unsolve)
Route::get('/returnUnsolveComment', 'ReturnController@returnUnsolve');
Route::get('/solved_comments', 'ReturnController@solved_Comments')->name('solved_comments');
Route::get('/oc_detail/{id}', 'ReturnController@orderComment_Detail');
Route::post('/order_reply/{id}', 'ReturnController@orderCommentReply');
Route::post('/solved/{id}', 'ReturnController@solvedOrder');
Route::post('/unsolve/{id}', 'ReturnController@unsolveOrder');
Route::post('/edit_dept_order/{id}', 'ReturnController@orderDepartment');
Route::get('/rider/inside', 'ReturnController@riderInside')->name('inside.rider');
Route::get('/rider/outside', 'ReturnController@riderOutside')->name('outside.rider');
Route::get('/rider/return/remaining/{id}/{status}', 'ReturnController@returnRemaining')->name('rider.remaining');
Route::get('/riderSearch','ReturnController@searchRider');

Route::post('/getRiderStatusDetails/{status}/{id}','ReturnController@SearchRiderDetailOrder');

//exchange Order 
Route::Post('exchangeOrder','Resource\SortCenterTripResourceController@exchangeOrder');