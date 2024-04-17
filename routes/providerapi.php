<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Authentication
Route::post('/register' , 'ProviderAuth\TokenController@register');
Route::post('/check-email' , 'ProviderAuth\TokenController@checkEmail');
Route::post('/check-mobile' , 'ProviderAuth\TokenController@checkMobile');
Route::post('/oauth/token' , 'ProviderAuth\TokenController@authenticate');
Route::post('/logout' , 'ProviderAuth\TokenController@logout');

Route::post('/auth/facebook', 'ProviderAuth\TokenController@facebookViaAPI');
Route::post('/auth/google', 'ProviderAuth\TokenController@googleViaAPI');

Route::post('/forgot/password',     'ProviderAuth\TokenController@forgot_password');
Route::post('/reset/password',      'ProviderAuth\TokenController@reset_password');

//Route::post('invoicebackupdata', 'ProviderResources\TripController@invoicebackup');
 Route::get('/services' , 'ProviderResources\TripController@services');

Route::group(['middleware' => ['provider.api']], function () {
    /*Route::post('/invoicebackupdata', 'ProviderResources\TripController@invoicebackup');*/
    Route::post('/upload-signature' , 'ProviderResources\TripController@signatureUpload');

    Route::post('/review' , 'ProviderResources\TripController@review');
    //Get Notification
    Route::post('document/upload','ProviderResources\DocumentController@updateDocuments');
    Route::post('document/new','ProviderResources\DocumentController@store');

    Route::post('/addNotification' , 'ProviderResources\TripController@addNotification');
    Route::get('/notification' , 'ProviderResources\TripController@notification');
    Route::get('document/checkDocument', 'ProviderResources\DocumentController@checkDocument');
    Route::get('document/status', 'ProviderResources\DocumentController@document_status');

    Route::post('/refresh/token' , 'ProviderAuth\TokenController@refresh_token');

    Route::group(['prefix' => 'comment'], function () {

        //get the comment which are unread
        Route::get('/','ProviderResources\CommentController@unread');

        //add new comment
        Route::post('/','ProviderResources\CommentController@store');

        //set all comments to read
        Route::post('/{id}/read','ProviderResources\CommentController@allRead');

        //get the comment of certain order
        Route::get('/{id}','ProviderResources\CommentController@show');

    });

    Route::group(['prefix' => 'profile'], function () {

        Route::get ('/' , 'ProviderResources\ProfileController@index');
        Route::post('/' , 'ProviderResources\ProfileController@update');
        Route::post('/password' , 'ProviderResources\ProfileController@password');
        Route::post('/location' , 'ProviderResources\ProfileController@location');
        Route::post('/available' , 'ProviderResources\ProfileController@available');

    });

    Route::get('/target' , 'ProviderResources\ProfileController@target');
  
    Route::post('cancel', 'ProviderResources\TripController@cancel');
    Route::post('summary', 'ProviderResources\TripController@summary');
    Route::get('help', 'ProviderResources\TripController@help_details');
    Route::post('verifyotp' , 'ProviderResources\TripController@verifyOtp');

    Route::group(['prefix' => 'trip'], function () {

        Route::post('{id}', 'ProviderResources\TripController@accept');
        Route::post('{id}/rate', 'ProviderResources\TripController@rate');
        Route::post('{id}/message' , 'ProviderResources\TripController@message');
        Route::post('{id}/update', 'ProviderResources\TripController@updateStatus');
        Route::get('userOrder/{status}/{id}', 'ProviderResources\TripController@userOrder');
        Route::get('Order/{id}','ProviderResources\TripController@OrderDetails'); //this is uesd to get the order details
        Route::post('pending/{id}','ProviderResources\TripController@storeallPendingOrder');
        Route::post('accepted/{id}','ProviderResources\TripController@storeAcceptOrder');
        Route::post('notpickedup/{id}','ProviderResources\TripController@notPickedupOrder');
        Route::get('booking/{id}','ProviderResources\TripController@Booking_id'); //this is used to pickup the request id



    });
  Route::resource('trip', 'ProviderResources\TripController');
  Route::get('remaining', 'ProviderResources\TripController@remainingPayment');
  Route::get('sortcenter', 'ProviderResources\TripController@sortcenter');
  Route::get('finished', 'ProviderResources\TripController@finishedOrders');
    Route::group(['prefix' => 'requests'], function () {

        Route::get('/upcoming' , 'ProviderResources\TripController@scheduled');
        Route::get('/history', 'ProviderResources\TripController@history');
        Route::get('/history/details', 'ProviderResources\TripController@history_details');
        Route::post('/history/details', 'ProviderResources\TripController@history_details');

        Route::get('/upcoming/details', 'ProviderResources\TripController@upcoming_details');

    });
    Route::get('/addBank' , 'PaymentController@addBankAccount');
    Route::post('/addBank' , 'PaymentController@addBankAccount');
    Route::get('/withdrawaList' , 'ProviderResources\TripController@withdrawRequestList');
    Route::get('/withdrawalRequest' , 'ProviderResources\TripController@withdrawalRequest');
    Route::post('/withdrawalRequest' , 'ProviderResources\TripController@withdrawalRequest');
    Route::get('/BankList' , 'PaymentController@BankList');
    //chat
    Route::get('/firebase/getChat' , 'ProviderResources\TripController@getChat');
    Route::get('/firebase/chatHistory' , 'FirebaseController@chatHistoryProvider');
    Route::get('/firebase/dumy-notify' , 'ProviderResources\TripController@dummyNotify');
    Route::get('document/status', 'ProviderResources\DocumentController@document_status');
    Route::get('document/types', 'ProviderResources\DocumentController@getDocumentTypes');
    Route::get('document/applied', 'ProviderResources\DocumentController@documentDone');
	Route::get('/test', 'ProviderResources\TripController@test');

    //bill upddate

    Route::post('updateBill','PaymentController@addBill');
    Route::get('getBill','PaymentController@getBill');
	
});
