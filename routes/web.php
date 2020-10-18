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

Route::get('oauth2-callback', 'ClientController@oauth2_callback');
Route::get('gmail-auth', 'ClientController@index')->name('gmail-auth.index');
Route::get('gmail-revoke', 'ClientController@revoke')->name('gmail-revoke');

// Route::get('push-notify', 'PushNotifyController@index');
Route::get('push-notify', 'ClientController@push_notify');

// Route::get('noti', 'TestController@test_one_to_many');

// Route::resource('lookups', 'LookupController');

// Route::get('notifications/search', 'NotificationController@search')->name('search-notification');

// Route::post('notifications/result', 'NotificationController@result')->name('result-notification');

// Route::resource('notifications', 'NotificationController');

Route::resource('groups', 'GroupController');

Route::resource('mappings', 'MappingController');

Route::get('reports', 'ReportController@index')->name('reports.index');
Route::get('reports/search', 'ReportController@search')->name('reports.search');
Route::post('reports/result', 'ReportController@result')->name('reports.result');
Route::get('reports/show/{date}/{mapping_id}', 'ReportController@show')->name('reports.show');

Route::resource('users', 'UserController');
Route::get('users/{user}/change-password', 'UserController@change_password')->name('user-change-password');

Route::get('auth-gmail', 'PushNotifyController@index');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

