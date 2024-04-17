<?php

Route::get('profile', 'FulfillmentController@profile')->name('profile');
Route::post('profile', 'FulfillmentController@profile_update')->name('profile.update');

Route::get('password', 'FulfillmentController@password')->name('password');
Route::post('password', 'FulfillmentController@password_update')->name('password.update');

Route::resource('/', 'FulfillmentController');
