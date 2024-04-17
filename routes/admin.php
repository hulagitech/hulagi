<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/


use App\Zones;
use App\Dispatcher;
use App\Http\Controllers\adminDispatchController;
Route::get('/createReferral','AdminController@createReferral');
// Route::get('/', 'AdminController@dashboard')->name('index');
Route::get('/notification', 'AdminController@notification')->name('notification');
Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
// Route::get('/searchingajax', 'AdminController@searchingajax');
// Route::get ('/ajaxforofflineprovider' , 'AdminController@ajaxforofflineprovider');

//for ringing sound
Route::get('/getTotalPosts', 'AdminController@getTotalPosts');


Route::get('/airport', 'AdminController@airport')->name('airport');
Route::get('/delivery', 'AdminController@delivery')->name('delivery');
Route::get('/ktm/delivery/remaining', 'AdminController@KtmDeliveryRemaining')->name('ktm.delivery.remaining');
Route::get('/rental', 'AdminController@rental')->name('rental');
Route::get('/surge', 'AdminController@dashboard')->name('surge');
Route::get('cabAllocation', 'AdminController@cabAllocation')->name('cabAllocation');
Route::get('cabAllocation_update', 'AdminController@cabAllocation_update')->name('cabAllocation_update');
Route::get('cabAllocation_edit/{id}', 'AdminController@cabAllocation_edit')->name('cabAllocation_edit');

Route::get('allocation_list', 'AdminController@allocation_list')->name('allocation_list');
Route::get('/translation',  'AdminController@translation')->name('translation');
Route::get('/heatmap', 'AdminController@heatmap')->name('heatmap');
Route::get('/translation',  'AdminController@translation')->name('translation');

Route::group(['as' => 'zonedispatch.' , 'prefix' => 'zonedispatch'], function () {
	Route::get('/','Resource\ZoneDispatchResource@index')->name('index');
	Route::post('/','Resource\ZoneDispatchResource@store')->name('dispatch');
	Route::get('/dispatchList','Resource\ZoneDispatchResource@view')->name('view');
	Route::post('/dispatchList','Resource\ZoneDispatchResource@updateDispatch')->name('updateDispatch');
	Route::get('/dispatchList/{id}','Resource\ZoneDispatchResource@show')->name('show');
});

Route::group(['as' => 'dispatcher.', 'prefix' => 'dispatcher'], function () {
	Route::get('/', 'DispatcherController@index')->name('index');
	Route::post('/', 'DispatcherController@store')->name('store');
	Route::get('/trips', 'DispatcherController@trips')->name('trips');
	Route::get('/trips/{trip}/{provider}', 'DispatcherController@assign')->name('assign');
	Route::get('/users', 'DispatcherController@users')->name('users');
	Route::get('/providers', 'DispatcherController@providers')->name('providers');
});

Route::get('/zone/getCountry','Resource\ZoneResource@getCountry')->name('getcountry');
Route::get('/zone/getState','Resource\ZoneResource@getState')->name('getstate');
Route::get('/zone/getCity','Resource\ZoneResource@getCity')->name('getcity');
Route::get('/pushnotification/testUrl', 'PushNotificationResource@getZoneId');
Route::get('/pushnotification/getZoneProviders/{id}/{typeid}', 'Resource\PushNotificationResource@getZonesProviders')->name('pushzoneproviders');
Route::get('/pushnotification/getProvidersAndUsers/{typeid}', 'Resource\PushNotificationResource@getProvidersAndUsers')->name('getProvidersAndUsers');

Route::get('/pushnotification/getZones', 'Resource\PushNotificationResource@getZones')->name('allzones');
Route::get('provider/active-drivers', 'Resource\ProviderResource@activeDrivers')->name('provider.active-driver');
//search routes
Route::get('/userSearch','Resource\UserResource@search');
Route::get('userChart/{id}','Resource\UserResource@userChart')->name('user.Chart');
Route::get('/providerSearch','Resource\ProviderResource@search');

//added code
Route::match(array('GET','POST'),'/minizone/track','Resource\MiniZoneResource@track')->name('minizone.track');
Route::resource('minizone', 'Resource\MiniZoneResource');

Route::get('zone/showAll', 'Resource\ZoneResource@showAll')->name('zone.showAll');
Route::resource('zone', 'Resource\ZoneResource');
Route::resource('pushnotification', 'Resource\PushNotificationResource');
Route::resource('country', 'Resource\CountryResource');
Route::resource('state', 'Resource\StateResource');
Route::resource('city', 'Resource\CityResource');
Route::resource('location', 'Resource\LocationResource');
Route::resource('user', 'Resource\UserResource');
Route::resource('dispatch-manager', 'Resource\DispatcherResource');
Route::resource('account-manager', 'Resource\AccountResource');
Route::resource('fleet', 'Resource\FleetResource');
Route::resource('provider', 'Resource\ProviderResource');
Route::resource('document', 'Resource\DocumentResource');
Route::resource('service', 'Resource\ServiceResource');
Route::resource('blog', 'Resource\BlogAdminResource');
Route::resource('allocation', 'Resource\ServiceResource@allocation');
Route::post('service_update/{id}', 'AdminController@service_update')->name('update');
Route::post('is_read','AdminController@is_read_post');
Route::get('faresettings', 'AdminController@fare_settings')->name('fare_settings');
Route::post('faresettings/store', 'AdminController@fare_settings_store')->name('fare.settings.store');
Route::get('settings/create', 'AdminController@fare_settings_create')->name('fare.settings.create');
Route::post('destory_fare', 'AdminController@destory_fare')->name('destory_fare');
Route::delete('delete_fare', 'AdminController@deleteFare')->name('fare.settings.destroy');
Route::delete('destory_pkg', 'AdminController@deletePKG')->name('fare.settings.deletePKG');
Route::get('edit_fare/{id}', 'AdminController@editFare')->name('fare.settings.edit');
Route::post('edit_fare_action', 'AdminController@editFareAction');
Route::post('addpeakAnight', 'AdminController@addpeakAnight')->name('peakNight');
Route::post('settings/addpeakAnight', 'AdminController@addpeakAnight');

Route::resource('fare','FareController');
Route::resource('bank', 'Resource\BankResource');
Route::resource('new_account', 'Resource\BankResource@new_account');
Route::get('approved_account', 'Resource\BankResource@approved_account');
Route::get('new_withdraw', 'Resource\BankResource@new_withdraw');
Route::get('approved_withdraw', 'Resource\BankResource@approved_withdraw');
Route::get('disapproved_withdraw', 'Resource\BankResource@disapproved_withdraw');

Route::resource('faqs', 'Resource\AdminFaqResource');    
Route::resource('how-it-work', 'Resource\AdminHowitWorkResource');    
Route::resource('page', 'Resource\PageAdminResource');
Route::resource('cms-manager', 'Resource\CmsResource');
Route::resource('support-manager', 'Resource\SupportResource');
Route::get('/support/open-ticket', 'Resource\SupportResource@openTicket')->name('openTicket');
Route::get('/support/close-ticket', 'Resource\SupportResource@closeTicket')->name('closeTicket');
Route::get('/support/open-ticket-details/{id}', 'Resource\SupportResource@openTicketDetails')->name('openTicketDetails');
Route::patch('/support/transfer/{id}', 'Resource\SupportResource@transfer')->name('transfer');
Route::resource('crm-manager', 'Resource\CrmResource');
Route::get('/lost-management', 'AdminController@lost_management')->name('lost-management');
Route::get('/lost-edit/{id}', 'AdminController@lost_edit')->name('lost-edit');
Route::PATCH('/lost-update/{id}', 'AdminController@lost_update')->name('lost-update');
Route::get('/crm/open-ticket/{type?}', 'Resource\CrmResource@openTicket')->name('openTicket');
Route::get('/crm/open-ticket-details/{id}', 'Resource\CrmResource@openTicketDetails')->name('openTicketDetails');
Route::patch('/crm/transfer/{id}', 'Resource\CrmResource@transfer')->name('transfer');
Route::get('/crm/close-ticket', 'Resource\CrmResource@closeTicket')->name('closeTicket');

Route::get('promocode/user', 'Resource\PromocodeResource@userPromoCode')->name('promocode.users');
Route::get('promocode/promocodes', 'Resource\PromocodeResource@getPromoCodes')->name('promocodes');
Route::get('promocode/promocodeusage', 'Resource\PromocodeResource@getPromocodeUser')->name('promocodeusage');

Route::get('reward', 'Resource\PromocodeResource@rewardRuleIndex')->name('reward.index');
Route::get('reward/create', 'Resource\PromocodeResource@rewardRuleCreate')->name('reward.create');
Route::post('reward', 'Resource\PromocodeResource@rewardRuleUpdate')->name('reward.updated');
Route::get('referral', 'Resource\PromocodeResource@referralRuleIndex')->name('referral.index');
Route::get('referral/create', 'Resource\PromocodeResource@referralRuleCreate')->name('referral.create');
Route::post('referral', 'Resource\PromocodeResource@referralRuleUpdate')->name('referral.updated');


Route::resource('promocode', 'Resource\PromocodeResource');
Route::resource('testimonial', 'Resource\TestimonialResource');

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
	Route::get('provider/{id}/log', 'Resource\ProviderResource@log')->name('log');
	Route::post('provider/log/{id}', 'Resource\ProviderResource@updateLog');
    Route::resource('provider/{provider}/document', 'Resource\ProviderDocumentResource');
    Route::delete('provider/{provider}/service/{document}', 'Resource\ProviderDocumentResource@service_destroy')->name('document.service');
    Route::get('provider/{provider}/document/{document}/upload', 'Resource\ProviderDocumentResource@get_provider_document_upload');
	Route::post('provider/{provider}/document/{document}/upload', 'Resource\ProviderDocumentResource@provider_document_upload');
	Route::get('provider/{provider}/document/{document}/update', 'Resource\ProviderDocumentResource@edit_provider_document_upload');
	Route::post('provider/{provider}/document/{document}/update', 'Resource\ProviderDocumentResource@update_provider_document_upload');

	Route::get('outerprovider', 'Resource\ProviderResource@outer_provider')->name('outerprovider');
	Route::get('outeredit/{id}', 'Resource\ProviderResource@outer_edit')->name('outeredit');
	Route::post('outerupdate/{id}', 'Resource\ProviderResource@outer_update')->name('outerupdate');
});


Route::get('/allZones',function(){
	$zones=Zones::all()->pluck('zone_name')->toArray();
	return response($zones);
});

Route::get('/allDispatcher',function(){
	$Disptcher=Dispatcher::all()->pluck('name')->toArray();
	return response($Disptcher);
});

Route::resource('subzone', 'SubZoneController');
Route::get('review/user', 'AdminController@user_review')->name('user.review');
Route::get('user/{id}/request', 'Resource\UserResource@request')->name('user.request');
// Searching inside User Detail Information.
Route::post('/userdetailSearch/{id}','Resource\UserResource@searchDetail');


Route::get('map', 'AdminController@map_index')->name('map.index');
Route::get('map/ajax', 'AdminController@map_ajax')->name('map.ajax');

Route::get('settings', 'AdminController@settings')->name('settings');
Route::post('settings/store', 'AdminController@settings_store')->name('settings.store');
Route::get('settings/payment', 'AdminController@settings_payment')->name('settings.payment');
Route::post('settings/payment', 'AdminController@settings_payment_store')->name('settings.payment.store');

Route::get('profile', 'AdminController@profile')->name('profile');
Route::post('profile', 'AdminController@profile_update')->name('profile.update');
Route::get('/contact', 'AdminController@contact')->name('contact');
Route::delete('/destroy/{id}', 'AdminController@destroy')->name('destroy');

Route::get('password', 'AdminController@password')->name('password');
Route::post('changeprovidorpassword', 'AdminController@changeprovidorpassword')->name('changeprovidorpassword');
Route::post('changeaccountpassword', 'AdminController@changeAccountPassword')->name('changeAccountPassword');
Route::post('changereturnpassword', 'AdminController@changeReturnPassword')->name('changeReturnPassword');
Route::post('changeuserpassword', 'AdminController@changeuserpassword')->name('changeuserpassword');
Route::post('changesupportpassword', 'AdminController@changeSupportPassword')->name('changeSupportPassword');
Route::post('changesortcenterpassword', 'AdminController@changeSortcenterPassword')->name('changeSortcenterPassword');
Route::post('changepickuppassword', 'AdminController@changePickupPassword')->name('changePickupPassword');

Route::post('password', 'AdminController@password_update')->name('password.update');
Route::get('payment/{type}', 'AdminController@payment')->name('payment');
// statements
Route::get('/statement', 'AdminController@statement')->name('ride.statement');
Route::get('/statement/provider', 'AdminController@statement_provider')->name('ride.statement.provider');
Route::get('/statement/today', 'AdminController@statement_today')->name('ride.statement.today');
Route::get('/statement/monthly', 'AdminController@statement_monthly')->name('ride.statement.monthly');
Route::get('/statement/yearly', 'AdminController@statement_yearly')->name('ride.statement.yearly');

// Static Pages - Post updates to pages.update when adding new static pages.

//Route::get('/help', 'AdminController@help')->name('help');
Route::get('/privacy', 'AdminController@privacy')->name('privacy');
Route::post('/pages', 'AdminController@pages')->name('pages.update');

Route::get('/faq', 'Resource\FAQController@faqs');
Route::post('/faq', 'Resource\FAQController@create');

Route::get('/terms', 'Resource\TermsConditionController@terms');
Route::post('/terms', 'Resource\TermsConditionController@create');

Route::resource('requests', 'Resource\TripResource');
Route::get('requests/{id}/logs', 'AdminController@logs');

Route::match(array('GET','POST'),'dateSearch', 'Resource\TripResource@dateSearch')->name('requests.dateSearch');
Route::match(array('GET','POST'),'dateSearchSettle', 'Resource\TripResource@dateSearchSettle')->name('requests.dateSearchSettle');
Route::match(array('GET','POST'),'delaySearch', 'Resource\TripResource@delaySearch')->name('requests.delaySearch');
Route::get('allRequests', 'Resource\TripResource@allRequests')->name('requests.allRequests');
Route::get('pending', 'Resource\TripResource@pending')->name('requests.pending');
Route::get('pending/map','Resource\TripResource@pendingMap')->name('pending.map');
Route::get('bulkAssign', 'Resource\TripResource@bulkAssignUI')->name('requests.bulkAssign');
Route::post('bulkAssign/{id}', 'Resource\TripResource@bulkAssign');
Route::get('accepted', 'Resource\TripResource@accepted')->name('requests.accepted');
Route::get('scheduled', 'Resource\TripResource@scheduled')->name('requests.scheduled');
Route::get('cancelTrip', 'Resource\TripResource@cancelTrip')->name('requests.cancel');
Route::get('completedTrip', 'Resource\TripResource@completedTrip')->name('requests.completed');
Route::match(array('GET','POST'),'insidevalley', 'AdminController@insidevalley')->name('requests.insidevalley');
Route::match(array('GET','POST'),'outsidevalley', 'AdminController@outsidevalley')->name('requests.outsidevalley');

Route::get('push', 'AdminController@push_index')->name('push.index');
Route::post('push', 'AdminController@push_store')->name('push.store');

Route::get('get-locations/{type?}', 'LiveTrip@index')->name('live.index');
Route::get('get-details/{type}/{id}', 'LiveTrip@getDetails')->name('live.details');

Route::resource('ridetype', 'Resource\RideTypeResource');

// Admin can reply on comment.
Route::post('/comments/{id}', 'Resource\TripResource@adminComment');

// Invoice Print 
Route::get('printInvoice/{id}', 'InvoiceController@print_invoice');

// Tickets and its comments
Route::get('/todaytickets', 'AdminTicketController@todayTickets')->name('todaytickets');
Route::get('/today_ticket_comment/{id}', 'AdminTicketController@today_commentTickets');
Route::post('/today_close_ticket/{id}', 'AdminTicketController@today_close_Tickets');

Route::post('/ticket_reply/{id}', 'AdminTicketController@replyTickets');

Route::get('/opentickets', 'AdminTicketController@openTickets')->name('opentickets');
Route::get('/ticket_detail/{id}', 'AdminTicketController@detailTickets');
Route::post('/close_ticket/{id}', 'AdminTicketController@close_Tickets');

// Inbound Order
Route::get('allinbound', 'Resource\TripResource@all_inbound')->name('requests.allinbound');
Route::post('/inbound_order/{id}', 'Resource\TripResource@inboundOrder')->name('requests.inbound_order');

// Return Order
Route::get('tobereturn', 'Resource\TripResource@tobe_return')->name('requests.tobereturn');
Route::post('/order_inhub/{id}', 'Resource\TripResource@orderIn_hub')->name('requests.order_inhub');
Route::get('allOrder_inHub', 'Resource\TripResource@allorder_inhub')->name('requests.allOrder_inHub');
Route::post('/returnRider/{id}', 'Resource\TripResource@return_Rider');
Route::post('/returnCompleted/{id}', 'Resource\TripResource@return_completed')->name('requests.returnCompleted');
Route::get('returnedOrder', 'Resource\TripResource@returned_order')->name('requests.returnedOrder');

// Return Manager Information
Route::resource('return-manager', 'Resource\ReturnResource');
Route::post('return_email', 'Resource\ReturnResource@checkEmail');

//next User Dashboard

Route::resource('nextDashboardUser', 'NextUserDashobards');

//Admin

Route::resource('admin', 'AdminResourceController');


// Dept Setting
Route::resource('dept','DeptController');

// Branch Manager Information
Route::resource('branch-manager', 'Resource\BmResource');
Route::post('bm_email', 'Resource\BmResource@checkEmail');

// Department Admin Information
Route::resource('admin-dept', 'Resource\AdminDeptResource');
Route::post('check_email', 'Resource\AdminDeptResource@checkEmail');


Route::post('/changeCargo/{id}', 'Resource\TripResource@change_cargo');

// Sort center user 
Route::resource('sortcenter-user', 'Resource\SortCenterUserController');
//pickup user route
Route::resource('pickup-user','Resource\PickupUserController');

//  Routes for notice
Route::resource('notices', NoticeController::class);
//dispatcher password chaneg
Route::post('changeDispacherPassword', 'Resource\DispatcherResource@changeDispatcherassword')->name('changeDispacherPassword');
Route::get('track', 'AdminController@track')->name('requests.track');
Route::post('trackPost', 'AdminController@trackPost')->name('requests.trackPost');
Route::get('Ndispatch','AdminController@ReceivedRemainingDispatch')->name('dispatcher.page');

Route::get('Quotes','AdminController@quotes');

//wallet user

Route::get('wallet','AdminController@wallet')->name('user.wallet');

Route::get('InactiveOrder','AdminController@InactiveOrder')->name('requests.InactiveOrder');
Route::post('/getOrderDetails/{id}', 'AdminController@getOrderDetails')->name('getOrderDetails');
Route::get('AllUser','AdminController@AllUser')->name('user.AllUser');

Route::get('/sendmail','AdminController@send_mail');

// Route::get('unsettle/rider/{id}','AccountController@unsettleRider');