<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::post('shorten', 'UrlController@shorten');
Route::get('{shortcode}', 'UrlController@redirect')->name('shortened');
