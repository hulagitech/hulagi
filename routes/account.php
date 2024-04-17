<?php

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', 'AccountController@dashboard')->name('index');
Route::get('/dashboard', 'AccountController@dashboard')->name('dashboard');
Route::get('/completed/order', 'AccountController@completedOrder')->name('completed.order');
Route::get('/rejected/order', 'AccountController@rejectedOrder')->name('rejected.order');
Route::get('/rider/completed', 'AccountController@riderCompletedOrder')->name('rider.completed');
Route::get('/vendor/completed', 'AccountController@vendorCompletedOrder')->name('vendor.completed');




Route::resource('provider', 'Resource\ProviderResource');
Route::get('requests/{id}', 'Resource\TripResource@Accountshow')->name('requests.show');
Route::put('requests/{id}', 'Resource\TripResource@update');
Route::get('activeProvider', 'Resource\ProviderResource@activeProvider')->name('activeProvider');
Route::group(['as' => 'provider.'], function () {
     Route::get('provider/{id}/approve', 'Resource\ProviderResource@approve')->name('approve');
    Route::get('provider/{id}/disapprove', 'Resource\ProviderResource@disapprove')->name('disapprove');
    Route::get('provider/{id}/statement', 'Resource\ProviderResource@Accountstatement')->name('statement');
    Route::get('provider/{id}/logs', 'Resource\ProviderResource@log')->name('logs');
    Route::post('provider/log', 'Resource\ProviderResource@updateLog')->name('update.log');
    Route::get('provider/payment-slip/{id}', 'Resource\ProviderResource@invoiceSlip')->name('riderPaymentslip');

});

Route::get('profile', 'AccountController@profile')->name('profile');
Route::post('profile', 'AccountController@profile_update')->name('profile.update');

Route::get('password', 'AccountController@password')->name('password');
Route::post('password', 'AccountController@password_update')->name('password.update');

//Accounts

Route::resource('bank', 'Resource\AccountBankResource');
Route::resource('new_account', 'Resource\AccountBankResource@new_account');
Route::get('approved_account', 'Resource\AccountBankResource@approved_account');
Route::get('new_withdraw', 'Resource\AccountBankResource@new_withdraw');
Route::get('approved_withdraw', 'Resource\AccountBankResource@approved_withdraw');
Route::get('disapproved_withdraw', 'Resource\AccountBankResource@disapproved_withdraw');

// Rider Statements
Route::get('/{id}/statement', 'Resource\ProviderResource@statement')->name('statement');
Route::get('/statement', 'AccountController@statement')->name('ride.statement');
//settle rider
Route::get('rider/settled','AccountController@settledRider');
Route::get('statement/rider/settle/{id}', 'AccountController@riderSettleStatement')->name('rider.settle.statement');
Route::post('statement/rider/settlement/{id}', 'AccountController@settleRiderStatement');
// Route::get('unsettle/rider/{id}','AccountController@unsettleRider');

//settle User

Route::get('user/settle/{id}', 'AccountController@settleUserStatement')->name('user.settle.statement');
Route::post('user/settlement/{id}', 'AccountController@settleUsersStatement');

// Route::get('/cleardata', 'AccountController@clearData')->name('cleardata');
Route::get('/statement/provider', 'AccountController@statement_provider')->name('ride.statement.provider');
Route::post('/statement/provider', 'AccountController@statement_provider');
Route::post('/statement/provider/{id}', 'AccountController@provider_update');
Route::get('/statement/provider/{id}/request', 'AccountController@provider_statement');
Route::get('/statement/provider/{id}/log', 'AccountController@provider_payment_logs')->name('providers.log.update');
Route::get('/statement/user', 'AccountController@statement_user')->name('ride.statement.user');
Route::get('/statement/negative', 'AccountController@negative_wallet')->name('ride.negative.wallet');
Route::post('/statement/user', 'AccountController@statement_user');
Route::get('/statement/user/{id}', 'AccountController@user_payments')->name('statement.log');
Route::get('destroy/paymenthistory/{id}','AccountController@destroyPaymentHistory');
Route::get('/statement/user/{id}/request', 'AccountController@user_statement');
Route::get('/statement/user/details/{id}','AccountController@stament_details');
Route::get('/statement/user/{id}/orderlog', 'AccountController@UserOrderLog')->name('statement.log.order');
Route::get('/statement/user/payment/{id}','AccountController@get_payment')->name('statement.payment');
//Rider bill update
Route::get('bill', 'AccountController@bill')->name('ride.bill');
Route::post('/bill/provider', 'AccountController@billSearch');
Route::get('verify/bill/{id}','AccountController@billPaymenyVefify')->name('bill.provider.verify');
Route::get('/bill/payment/provider/{id}', 'AccountController@RiderPaymentDone')->name('bill.provider.payment');
Route::post('/bill/payment/provider/{id}', 'AccountController@RiderPaymentBillEdit');
Route::get('bill/destroy/{id}', 'AccountController@billDestroy')->name('bill.destroy');
Route::get('bill/unverified','AccountController@billUnverified')->name('ride.bill.unverified');
Route::post('/riderSearchPayment/billSearch', 'AccountController@riderSearchPaymentBill');

//Searching user_statement detail.
Route::post('/userStatementDetailSearch/{id}','AccountController@searchUserStatementDetail')->name('user');
//................
Route::post('/exl_report', 'AccountController@saveExl_report');

Route::get('/statement/range', 'AccountController@statement_range')->name('ride.statement.range');
Route::get('/statement/today', 'AccountController@statement_today')->name('ride.statement.today');
Route::get('/statement/monthly', 'AccountController@statement_monthly')->name('ride.statement.monthly');
Route::get('/statement/yearly', 'AccountController@statement_yearly')->name('ride.statement.yearly');
Route::get('/openTicket/{type?}', 'AccountController@openTicket')->name('openTicket');
Route::get('/closeTicket', 'AccountController@closeTicket')->name('closeTicket');
Route::get('/openTicketDetail/{id}', 'AccountController@openTicketDetail')->name('openTicketDetail');
Route::patch('/transfer/{id}', 'AccountController@transfer')->name('transfer');

Route::post('/statement/update/{id}', 'AccountController@update_paid')->name('update.statement');
Route::post('/statement/payment/{id}', 'AccountController@makePayment')->name('payment.statement');

Route::get('statement/payment-slip/{id}','AccountController@payment_slip')->name('paymentslip');

// Tickets and its comments
Route::get('/todaytickets', 'TicketCommentController@todayTickets')->name('todaytickets');
Route::get('/today_ticket_detail/{id}', 'TicketCommentController@today_detailTickets');
Route::post('/today_close_ticket/{id}', 'TicketCommentController@today_close_Tickets');

Route::get('/opentickets', 'TicketCommentController@openTickets')->name('opentickets');
Route::get('/ticket_detail/{id}', 'TicketCommentController@detailTickets');
Route::post('/close_ticket/{id}', 'TicketCommentController@close_Tickets');

// Tickets Comment Reply
Route::post('/ticket_reply/{id}', 'TicketCommentController@account_replyTickets');

Route::get('/bannedStatement', 'AccountController@banned_statement')->name('bannedStatement');
Route::post('/bannedStatement', 'AccountController@banned_statement');


// Order Comments (Solved/Unsolve)
Route::get('/unsolve_comments', 'AccountNewController@unsolve_Comments')->name('unsolve_comments');
Route::get('/solved_comments', 'AccountNewController@solved_Comments')->name('solved_comments');
Route::get('/oc_detail/{id}', 'AccountNewController@orderComment_Detail');
Route::post('/order_reply/{id}', 'AccountNewController@orderCommentReply');
Route::post('/solved/{id}', 'AccountNewController@solvedOrder');
Route::post('/unsolve/{id}', 'AccountNewController@unsolveOrder');
Route::post('/edit_dept_order/{id}', 'AccountNewController@orderDepartment');


// Wallet
// Route::get('/wallet', 'WalletController@index')->name('wallet');
// Route::get('/add_ac', 'WalletController@create')->name('add_ac');
// Route::post('/user_ac', 'WalletController@store')->name('user_ac');

// Bank Details
Route::get('/bank_infos', 'AccountNewController@index')->name('bank_infos');
Route::get('/add_bank_info', 'AccountNewController@create')->name('add_bank_info');
Route::post('/add_bankDetail', 'AccountNewController@store')->name('add_bankDetail');
Route::get('/edit_bank_info/{id}', 'AccountNewController@edit')->name('edit_bank_info');
Route::post('/edit_bankDetail/{id}', 'AccountNewController@update')->name('edit_bankDetail');

// Khalti Details
Route::get('/khalti_infos', 'WalletController@index')->name('khalti_infos');
Route::get('/add_khalti_info', 'WalletController@create')->name('add_khalti_info');
Route::post('/add_khaltiDetail', 'WalletController@store')->name('add_khaltiDetail');
Route::get('/edit_khalti_info/{id}', 'WalletController@edit')->name('edit_khalti_info');
Route::post('/edit_khaltiDetail/{id}', 'WalletController@update')->name('edit_khaltiDetail');
//order tracking
// Route::match(array('GET','POST'),'/minizone/track','AccountController@track')->name('minizone.track');
Route::match(array('GET','POST'),'/minizone/track','Resource\MiniZoneResource@track')->name('minizone.track');
//invoice
Route::get('/user-invoice', 'AccountNewController@userInvoice')->name('userInvoice');
Route::get('invoice-details/{id}', 'AccountNewController@invoiceDetails');

Route::get('/rider-invoice', 'AccountNewController@riderInvoice')->name('riderInvoice');
Route::get('rider-invoice-details/{id}', 'AccountNewController@riderInvoiceDetails');


// all order by date
Route::match(array('GET','POST'),'dateSearch', 'AccountController@dateSearch')->name('dateSearch');
Route::get('show/{id}', 'AccountController@show')->name('order_details');
Route::post('/comments/{id}', 'AccountController@commentAccount');

// to show user wallet
Route::get('user','AccountController@user')->name('user.user');
Route::get('provider','AccountController@provider')->name('providers.providerwallet');
Route::get('/Order31', 'AccountController@Order31')->name('order');
Route::post('/changePassword','AccountController@Order31')->name('changePassword');

//Rider Payment Log edit
Route::get('provider/payment-edit/{id}','RiderPaymentLogController@edit')->name('providers.edit');
Route::post('provider/payment-update/{id}','RiderPaymentLogController@update')->name('providers.update');
Route::get('provider/payment-delete/{id}/{provider_id}','RiderPaymentLogController@destroy')->name('providers.delete');

//to get notification sound if payment request is done

Route::get('/gettotalrequest', 'AccountNewController@getTotalRequest');

Route::get('/esewapayment', 'AccountNewController@getEsewaPayment')->name('esewa');

Route::get('today-payable-history', 'AccountNewController@todayPaymentHistory')->name('today-history');

Route::get('today-rider-history', 'AccountNewController@todayriderHistory')->name('today-rider-history');

Route::post('userSearchPayment', 'AccountNewController@payementdate')->name('userSearchPayment');

Route::post('riderSearchPayment', 'AccountNewController@riderpayementdate')->name('userSearchRiderPayment');

Route::get('/allRequest','AccountNewController@totalRequest')->name('ride.allrequested');

Route::get('/allNagative','AccountNewController@totalNegativeUser')->name('ride.allNagative');

Route::get('allRider','AccountNewController@totalRider');

Route::get('payableUserAndVendor','AccountNewController@totalPayableUserAndVendor');

//this is used to flush the cache

Route::get('cacheFlush','AccountNewController@cacheFlush');
Route::get('new-user-request','AccountController@newUserRequest');


