<?php

Route::match(['get', 'post'],'/home', 'Admin\AdminController@dashboard')->name('home');

