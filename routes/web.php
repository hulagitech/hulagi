<?php

/*

|--------------------------------------------------------------------------

| User Authentication Routes

|--------------------------------------------------------------------------

*/

use App\Http\Controllers\HomeController;
use App\Page;

use App\ServiceType;

use App\Testimonial;
Route::post('/store-token','Invoice\InvoiceController@storeToken')->name('store.token');
Route::post('/get-notification','Invoice\InvoiceController@getNotification')->name('store.token');

// Get Route For Show Payment Form

Route::get('paywithrazorpay', 'RazorpayController@payWithRazorpay')->name('paywithrazorpay');

Route::get('payThankYou', 'RazorpayController@payThankYou')->name('payThankYou');

Route::get('/whoami101', function () {return view('my-page');});

// Post Route For Makw Payment Request

Route::post('razorpay_payment', 'RazorpayController@payment')->name('payment');

Auth::routes();

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');


Route::get('auth/facebook', 'Auth\SocialLoginController@redirectToFaceBook');
Route::get('/new_trips', 'HomeController@remove_session_trips');
// Route::get('charts/api', 'HomeController@getApi');

Route::get('/multiTrips', 'HomeController@multi_trips');
Route::get('auth/facebook/callback', 'Auth\SocialLoginController@handleFacebookCallback');
Route::get('trip/{status}','TripsController@index');

Route::get('auth/google', 'Auth\SocialLoginController@redirectToGoogle');

Route::get('auth/google/callback', 'Auth\SocialLoginController@handleGoogleCallback');

Route::post('account/kit', 'Auth\SocialLoginController@account_kit')->name('account.kit');

//Route::get('/searchingajax', 'AdminController@searchingajax');

/*

|--------------------------------------------------------------------------

| Provider Authentication Routes

|--------------------------------------------------------------------------

*/



Route::group(['prefix' => 'provider'], function () {



    Route::get('auth/facebook', 'Auth\SocialLoginController@providerToFaceBook');

    Route::get('auth/google', 'Auth\SocialLoginController@providerToGoogle');



    // Route::get('/login', 'ProviderAuth\LoginController@showLoginForm')->middleware('accesspage');

    Route::get('/login', 'ProviderAuth\LoginController@showLoginForm');

    // Route::get('/login', 'ProviderAuth\LoginController@showLoginForm');

    // Route::get('/login', 'ProviderAuth\LoginController@login');

    Route::post('/login', 'ProviderAuth\LoginController@login');

    Route::post('/logout', 'ProviderAuth\LoginController@logout');



    // Route::get('/register', 'ProviderAuth\RegisterController@showRegistrationForm')->middleware('accesspage');



    Route::get('/register', 'ProviderAuth\RegisterController@showRegistrationForm');

    Route::post('/register', 'ProviderAuth\RegisterController@register');



    Route::post('/password/email', 'ProviderAuth\ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'ProviderAuth\ResetPasswordController@reset');

    Route::get('/password/reset', 'ProviderAuth\ForgotPasswordController@showLinkRequestForm');

    Route::get('/password/reset/{token}', 'ProviderAuth\ResetPasswordController@showResetForm');

    Route::post('/password/update', 'CommonController@provider_password_update');

});





/*

|--------------------------------------------------------------------------

| Admin Authentication Routes

|--------------------------------------------------------------------------

*/



Route::group(['prefix' => 'admin'], function () {

  Route::get('/',function(){

   return redirect()->route('admin.login');

     });

    Route::get('/searchingajax', 'CommonController@searchingajax');

    Route::get ('/ajaxforofflineprovider' , 'CommonController@ajaxforofflineprovider');

    Route::get ('/offnotificationtoprovider' , 'SendPushNotification@offnotificationtoprovider');

    

    Route::get ('/provider-document-expiry-notification' , 'CommonController@providerDocumentExpiryNotification');

    // Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->middleware('accesspage');

    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');

    Route::post('/login', 'AdminAuth\LoginController@login');

    Route::post('/logout', 'AdminAuth\LoginController@logout');



    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');

    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');

    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

});



/*

|--------------------------------------------------------------------------

| Dispatcher Authentication Routes

|--------------------------------------------------------------------------

*/



Route::group(['prefix' => 'dispatcher'], function () { 

  Route::get('/',function(){

   return redirect()->route('dispatcher.login');

  });  

  Route::get('/login', 'DispatcherAuth\LoginController@showLoginForm')->name('dispatcher.login');

  Route::post('/login', 'DispatcherAuth\LoginController@login');

  Route::post('/logout', 'DispatcherAuth\LoginController@logout');



  Route::post('/password/email', 'DispatcherAuth\ForgotPasswordController@sendResetLinkEmail');

  Route::post('/password/reset', 'DispatcherAuth\ResetPasswordController@reset');

  Route::get('/password/reset', 'DispatcherAuth\ForgotPasswordController@showLinkRequestForm');

  Route::get('/password/reset/{token}', 'DispatcherAuth\ResetPasswordController@showResetForm');

});



/*

|--------------------------------------------------------------------------

| Fleet Authentication Routes

|--------------------------------------------------------------------------

*/





Route::group(['prefix' => 'fleet'], function () {

  Route::get('/',function(){

   return redirect()->route('fleet.login');

  });

  Route::get('/login', 'FleetAuth\LoginController@showLoginForm')->name('fleet.login');

  Route::post('/login', 'FleetAuth\LoginController@login');

  Route::post('/logout', 'FleetAuth\LoginController@logout');



  Route::post('/password/email', 'FleetAuth\ForgotPasswordController@sendResetLinkEmail');

  Route::post('/password/reset', 'FleetAuth\ResetPasswordController@reset');

  Route::get('/password/reset', 'FleetAuth\ForgotPasswordController@showLinkRequestForm');

  Route::get('/password/reset/{token}', 'FleetAuth\ResetPasswordController@showResetForm');

});



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

*/

Route::get('lang/{locale}', 'LocalizationController@index');

Route::get('/', function () {
    $services   = ServiceType::all();  
    $index   = Page::where('en_meta_keys','index')->get();  

    // $testimonials = Testimonial::all();

    return view('index', compact(['services','index']) );

})->middleware('accesspage');

Route::post('/get_fare', 'AjaxHandlerController@estimated_fare')->name('getfare');
Route::post('/saveLocationTemp', 'AjaxHandlerController@saveLocationTemp');

Route::post('/locale', 'CommonController@locale' );
Route::get("/rates",'CommonController@rates');
Route::get('/fare_estimate', 'CommonController@fare_estimate');
Route::get('/helppage', 'CommonController@helpPage');
Route::get('/trackMyOrder','CommonController@trackMyOrder');
Route::get('/internationalquote','CommonController@internationalQuote');



/*

|--------------------------------------------------------------------------

| User Routes

|--------------------------------------------------------------------------

*/



/*

|--------------------------------------------------------------------------

| My Files

|--------------------------------------------------------------------------

*/

//User sign in
Route::get('/login', 'SignInControlller@passengerSignin')->middleware('accesspage');
// Route::get('/PassengerSignin', 'SignInControlller@passengerSignin')->middleware('accesspage');
Route::get('/UserSignin', 'SignInControlller@passengerSignin');
Route::get('/faq', 'HomeController@faqs');
Route::get('/terms', 'HomeController@terms');
Route::get('/help', 'HomeController@helps');
Route::get('/resource', function () {return view('user.resource');})->name('user.resource');
Route::get('/office', function () {return view('user.office');})->name('user.office');
Route::get('/national', function () {return view('user.national');})->name('user.national');

Route::get('/dashboard', 'HomeController@index')->name('user.dashboard');
Route::get('/mytrips', 'HomeController@mytrips');
Route::get('/searchOrder', 'HomeController@searchOrder');
Route::post('/mytrips/{id}', 'HomeController@mytrips_update');
Route::get('/mytrips/detail', 'HomeController@mytrips_details');
Route::post('/mytrips/detail/rating/{provider_id}/{order_id}','HomeController@mytrips_rating')->name('trips_provider_rating');


Route::get('/notice','HomeController@notice');


// user profiles
Route::get('/profile', 'HomeController@profile');
Route::get('/edit/profile', 'HomeController@edit_profile');
Route::post('/profile', 'HomeController@update_profile');

// update password
Route::get('/change/password', 'HomeController@change_password');
Route::post('/change/password', 'HomeController@update_password');
Route::post('/password/update', 'CommonController@password_update'); 

// ride 
Route::post('/create/item', 'HomeController@create_item');
Route::get('/confirm/ride', 'RideController@confirm_ride');
Route::post('/create/ride', 'RideController@create_ride');

Route::post('/cancel/ride', 'RideController@cancel_ride');
Route::get('/onride', 'RideController@onride');
Route::post('/payment', 'PaymentController@payment');
Route::get('/payment/paypal/status', ['middleware' => 'auth', 'uses' => 'PaymentController@getPaymentStatus'])->name('paypalbookingstatus');
Route::get('/payment/paypal/denied', ['middleware' => 'auth', 'uses' => 'PaymentController@payWithpaypalReject'])->name('paypalbookingreject');
Route::post('/rate', 'RideController@rate');





// PromoCodes
Route::post('/apply_promo_code', 'AjaxHandlerController@applyPromoCodeOnEstimatedFare');
Route::get('/service_types', 'Resource\ServiceResource@index');
Route::post('/get_fare', 'AjaxHandlerController@estimated_fare');

// status check
Route::get('/status', 'RideController@status');

// trips 
Route::get('/trips', 'HomeController@trips');
Route::get('/upcoming/trips', 'HomeController@upcoming_trips');
Route::get('/upcoming/trips/detail', 'HomeController@upcoming_trips_details');
Route::get('/trips/map', 'HomeController@trips_map');

Route::get('/get-locations/{type?}', 'HomeController@get_locations');
Route::get('/get-locations/{type?}/{id?}', 'HomeController@get_location_details');



// wallet
Route::get('/wallet', 'HomeController@wallet')->name('wallet');
Route::post('/add/money', 'PaymentController@add_money');
Route::post('/request/money', 'PaymentController@request_money');

// payment
Route::get('/payment', 'HomeController@payment');
Route::get('payment-verify','HomeController@verify');
Route::get('loadPayment','HomeController@load');
Route::get('esewa','Invoice\InvoiceController@esewa');
Route::post('khalti/verify','HomeController@khaltiVerify')->name('khalti-verify');
Route::get('khalti','Invoice\InvoiceController@Khalti');


//stricker

Route::get('/stricker', 'HomeController@stricker');
Route::post('printInvoice', 'HomeController@invoice')->name('bulkinvocie');
Route::post('printInvoice/{id}', 'HomeController@singleSortCenterInvoice')->name('singleinvoice');


// card
Route::resource('card', 'Resource\CardResource');
Route::resource('paypal', 'Resource\PaypalResource');

// promotions
Route::get('/promotions', 'HomeController@promotions_index')->name('promocodes.index');
Route::post('/promotions', 'HomeController@promotions_store')->name('promocodes.store');
Route::group(['prefix' => 'fulfillment'], function () {

  Route::get('/',function(){
      return redirect()->route('fulfillment.login');
  });

  Route::get('/login', 'FulfillmentAuth\LoginController@showLoginForm')->name('fulfillment.login');

  Route::post('/login', 'FulfillmentAuth\LoginController@login');

  Route::post('/logout', 'FulfillmentAuth\LoginController@logout');
});


Route::group(['prefix' => 'account'], function () {

  Route::get('/',function(){

   return redirect()->route('account.login');

  });

    Route::get('/login', 'AccountAuth\LoginController@showLoginForm')->name('account.login');

    Route::post('/login', 'AccountAuth\LoginController@login');

    Route::post('/logout', 'AccountAuth\LoginController@logout');



    Route::get('/register', 'AccountAuth\RegisterController@showRegistrationForm');

    Route::post('/register', 'AccountAuth\RegisterController@register');



    Route::post('/password/email', 'AccountAuth\ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'AccountAuth\ResetPasswordController@reset');

    Route::get('/password/reset', 'AccountAuth\ForgotPasswordController@showLinkRequestForm');

    Route::get('/password/reset/{token}', 'AccountAuth\ResetPasswordController@showResetForm');

});

Route::get('reload-captcha', 'CommonController@reloadCaptcha');
Route::get('/terms-conditions', 'CommonController@terms_condition');



Route::group(['prefix' => 'cms'], function () { 

   Route::get('/',function(){

   return redirect()->route('cms.login');

  });

    Route::get('/login', 'CmsAuth\LoginController@showLoginForm')->name('cms.login');

    Route::post('/login', 'CmsAuth\LoginController@login');

    Route::post('/logout', 'CmsAuth\LoginController@logout');



    Route::post('/password/email', 'CmsAuth\ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'CmsAuth\ResetPasswordController@reset');

    Route::get('/password/reset', 'CmsAuth\ForgotPasswordController@showLinkRequestForm');

    Route::get('/password/reset/{token}', 'CmsAuth\ResetPasswordController@showResetForm');

});

/*

|--------------------------------------------------------------------------

| Crm Authentication Routes

|--------------------------------------------------------------------------

*/



Route::group(['prefix' => 'crm'], function () {

  Route::get('/',function(){

   return redirect()->route('crm.login');

  });

    Route::get('/login', 'CrmAuth\LoginController@showLoginForm')->name('crm.login');

    Route::post('/login', 'CrmAuth\LoginController@login');

    Route::post('/logout', 'CrmAuth\LoginController@logout');



    Route::post('/password/email', 'CrmAuth\ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'CrmAuth\ResetPasswordController@reset');

    Route::get('/password/reset', 'CrmAuth\ForgotPasswordController@showLinkRequestForm');

    Route::get('/password/reset/{token}', 'CrmAuth\ResetPasswordController@showResetForm');

});



Route::group(['prefix' => 'support'], function () {

  Route::get('/',function(){

   return redirect()->route('support.login');

  });

    Route::get('/login', 'SupportAuth\LoginController@showLoginForm')->name('support.login');

    Route::post('/login', 'SupportAuth\LoginController@login');

    Route::post('/logout', 'SupportAuth\LoginController@logout');



    Route::post('/password/email', 'SupportAuth\ForgotPasswordController@sendResetLinkEmail');

    Route::post('/password/reset', 'SupportAuth\ResetPasswordController@reset');

    Route::get('/password/reset', 'SupportAuth\ForgotPasswordController@showLinkRequestForm');

    Route::get('/password/reset/{token}', 'SupportAuth\ResetPasswordController@showResetForm');

});

// Route::group(['prefix' => 'return'], function () {
//   Route::get('/',function(){
//    return redirect()->route('return.login');
//   });

//     Route::get('/login', 'ReturnAuth\LoginController@showLoginForm')->name('return.login');
//     Route::post('/login', 'ReturnAuth\LoginController@login');
//     Route::post('/logout', 'ReturnAuth\LoginController@logout');


//     Route::post('/password/email', 'ReturnAuth\ForgotPasswordController@sendResetLinkEmail');
//     Route::post('/password/reset', 'ReturnAuth\ResetPasswordController@reset');
//     Route::get('/password/reset', 'ReturnAuth\ForgotPasswordController@showLinkRequestForm');
//     Route::get('/password/reset/{token}', 'ReturnAuth\ResetPasswordController@showResetForm');

// });


// Return Login
Route::group(['prefix' => 'return'], function () {
  Route::get('/',function(){
    return redirect()->route('return.login');
  });
    Route::get('/login', 'ReturnAuth\LoginController@showLoginForm')->name('return.login');
    Route::post('/login', 'ReturnAuth\LoginController@login');
    Route::post('/logout', 'ReturnAuth\LoginController@logout');

    Route::post('/password/email', 'ReturnAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ReturnAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'ReturnAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'ReturnAuth\ResetPasswordController@showResetForm');
});
// Return Login
Route::group(['prefix' => 'sortcenter'], function () {
  Route::get('/',function(){
    return redirect()->route('sortcenter.login');
  });
    Route::get('/login', 'SortCenterAuth\LoginController@showLoginForm')->name('sortcenter.login');
     Route::post('/login', 'SortCenterAuth\LoginController@login');
     Route::post('/logout', 'SortCenterAuth\LoginController@logout');

    // Route::post('/password/email', 'SortCenterAuth\ForgotPasswordController@sendResetLinkEmail');
    // Route::post('/password/reset', 'SortCenterAuth\ResetPasswordController@reset');
    // Route::get('/password/reset', 'SortCenterAuth\ForgotPasswordController@showLinkRequestForm');
    // Route::get('/password/reset/{token}', 'SortCenterAuth\ResetPasswordController@showResetForm');
});
Route::group(['prefix' => 'pickup'], function () {
  Route::get('/',function(){
    return redirect()->route('pickup.login');
  });
    Route::get('/login', 'PickupAuth\LoginController@showLoginForm')->name('pickup.login');
    Route::post('/login', 'PickupAuth\LoginController@login');
    Route::post('/logout', 'PickupAuth\LoginController@logout');

    // Route::post('/password/email', 'PickupAuth\ForgotPasswordController@sendResetLinkEmail');
    // Route::post('/password/reset', 'PickupAuth\ResetPasswordController@reset');
    // Route::get('/password/reset', 'PickupAuth\ForgotPasswordController@showLinkRequestForm');
    // Route::get('/password/reset/{token}', 'PickupAuth\ResetPasswordController@showResetForm');
});



// Branch Manager Login
Route::group(['prefix' => 'bm'], function () {
  Route::get('/',function(){
    return redirect()->route('bm.login');
  });
    Route::get('/login', 'BmAuth\LoginController@showLoginForm')->name('bm.login');
    Route::post('/login', 'BmAuth\LoginController@login');
    Route::post('/logout', 'BmAuth\LoginController@logout');

    Route::post('/password/email', 'BmAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'BmAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'BmAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'BmAuth\ResetPasswordController@showResetForm');
});



//common pages

// Route::get('/reset', 'CommonController@reset')->name('reset');



Route::get('/support/complaint', 'CommonController@complaint')->name('complaints');

Route::post('/contact-us', 'CommonController@contact')->name('contact.us');

Route::post('/ajax-handler/contact', 'CommonController@sendMessage')->name('contact');

Route::post('/ajax-handler/complaint', 'CommonController@complaint_form')->name('complaint');

Route::get('/contact_us', 'CommonController@contact_us')->name('contact_us');

Route::get('/blogs', 'CommonController@blogs')->name('blog.all');

Route::get('/blog/{id}','CommonController@blog_detail')->name('blogdetail');

Route::get('/lost-item', 'CommonController@lost_item')->name('lost_item');

Route::post('/ajax-handler/lost-item', 'CommonController@lostItemForm')->name('lost_item_form');



Route::get('/user', 'CommonController@user');

Route::get('/driver', 'CommonController@driver');

Route::get('/cities', 'CommonController@cities');

Route::get('/country/{type}', 'CommonController@getCountry');

Route::PATCH('/paymentmode', 'HomeController@save_payment_mode' );

Route::get('/how_it_works', 'CommonController@how_it_works');


Route::get('/help', 'CommonController@help');

//User Payment Information Detail.
Route::resource('/payment_info','Resource\UserPaymentDetailResource');

Route::get('/create_khalti', 'Resource\UserPaymentDetailResource@createKhalti');
Route::get('/create_bank', 'Resource\UserPaymentDetailResource@createBank');

Route::post('/payment_khalti', 'Resource\UserPaymentDetailResource@storeKhalti');
Route::post('/payment_bank', 'Resource\UserPaymentDetailResource@storeBank');

Route::post('/editKhalti', 'Resource\UserPaymentDetailResource@editKhaltiDetail');
Route::post('/editBank', 'Resource\UserPaymentDetailResource@editBankDetail');
//...............

//User Comments

Route::post('/comment/{id}', 'HomeController@userComment');
Route::get('/comments', 'HomeController@openComment');
Route::get('/all_comments', 'HomeController@allComment');
//fare plan list
Route::get('fare','HomeController@fare');
// QR-Code Testing
// Route::get('qrcode', function () {
//   return QrCode::size(500)
//       ->backgroundColor(245, 245, 245)
//       ->generate('IL961723');
// });

// Ticket
Route::resource('/ticket', 'Resource\TicketResource');
Route::get('/ticket/comment/{id}', 'Resource\TicketResource@ticket_comment');
Route::post('/comment/ticket/{id}', 'Resource\TicketResource@saveTicketComment');


///invoice route
Route::get('/payment_history', 'Invoice\InvoiceController@userInvoice');
Route::get('/pay_details/{id}', 'Invoice\InvoiceController@userInvoiceDetail');

Route::get('/driver_story', 'CommonController@driver_story');

Route::get('/calculate_price', 'CommonController@calculate_price');

Route::get('/download_page', 'CommonController@download_page');

Route::get('/stories', 'CommonController@stories');

Route::get('/review', 'CommonController@review');


Route::get('/ride_overview', 'CommonController@ride_overview');

Route::get('/ride_safety', 'CommonController@ride_safety');

Route::get('/airports', 'CommonController@airports');

Route::get('/drive_overview', 'CommonController@drive_overview');

Route::get('/requirements', 'CommonController@requirements');

Route::get('/driver_app', 'CommonController@driver_app');

Route::get('/vehicle_solutions', 'CommonController@vehicle_solutions');

Route::get('/drive_safety', 'CommonController@drive_safety');

Route::get('/local', 'CommonController@local');

Route::get('/{type}', 'CommonController@mylift');

// Route::get('/myliftxl', 'CommonController@myliftxl');

// Route::get('/myliftxll', 'CommonController@myliftxll');

// Route::get('/myliftgox', 'CommonController@myliftgox');

// Route::get('/terms_condition', 'CommonController@terms');

Route::post('/getAQuote','CommonController@getAQuote');

Route::get('/about-us', 'CommonController@about_us');

Route::get('/why-us', 'CommonController@why_us');

Route::get('/privacy-policy', 'CommonController@privacy');

Route::get('/refund-policy', 'CommonController@refund_policy');
Route::get('/rider-terms-and-conditions', 'CommonController@riderterms');
Route::get('/vendor-terms-and-conditions', 'CommonController@vendorterms');

Route::get('/flush-file', 'flushcontroller@index');

Route::get('/flush-db', 'flushcontroller@dropDB');

Route::get('/check-phone/{number}','HomeController@checkPhone');

//mail Esewa Payment
Route::get('esewa/pay/{token}','EmailEsewa@index');
Route::get('esewa/payment-verify/{id}','EmailEsewa@Pay');







// Route::get('/fee_estimation', 'CommonController@fee_estimation');

// Route::get('/help', 'CommonController@help');


// date search
// Route::match(array('GET','POST'),'dateSearch', 'Resource\SortCenterTripResourceController@dateSearch')->name('dateSearch');
