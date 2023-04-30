<?php

// Route::get('/home', 'Vendor\VendorController@dashboard')->name('home');

Route::group(['middleware' => 'vendorChecklist'], function () {
Route::match(['get', 'post'],'/home', 'Vendor\VendorController@dashboard2')->name('home');
});
