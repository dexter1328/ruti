<?php

Route::match(['get', 'post'],'/home', 'Admin\AdminController@dashboard2')->name('home');

