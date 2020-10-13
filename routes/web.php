<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});

Route::get('push-notify', 'PushNotifyController@index');

// Route::get('noti', 'TestController@test_one_to_many');

Route::resource('lookups', 'LookupController');

Route::get('notifications/search', 'NotificationController@search')->name('search-notification');

Route::post('notifications/result', 'NotificationController@result')->name('result-notification');

Route::resource('notifications', 'NotificationController');



Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

