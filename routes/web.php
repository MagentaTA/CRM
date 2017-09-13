<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Роутинг для исходящих запросов в базу UON
Route::group(['prefix' => 'api/uon/out'], function () {
    Route::get('all_clients', 'Api\uon\out\OutApiUonController@AllClients')->name('all_clients');
    Route::get('all_requests', 'Api\uon\out\OutApiUonController@AllRequests')->name('all_requests');
    Route::get('all_leads_requests', 'Api\uon\out\OutApiUonController@AllLeadsRequests')->name('all_leads_requests');
    Route::get('get_countries', 'Api\uon\out\OutApiUonController@GetCountries')->name('get_countries');
    Route::get('get_hotels', 'Api\uon\out\OutApiUonController@GetHotels')->name('get_hotels');
});
// Роутинг для входящих хуков из базы UON
Route::group(['prefix' => 'api/uon/in'], function () {
    Route::get('new_client', 'Api\uon\in\InApiUonController@NewClient');
    Route::get('change_client', 'Api\uon\in\InApiUonController@ChangeClient');
    Route::get('delete_client', 'Api\uon\in\InApiUonController@DeleteClient');
    Route::get('new_zayavka', 'Api\uon\in\InApiUonController@NewZayavka');
    Route::get('status_zayavka', 'Api\uon\in\InApiUonController@StatusZayavka');
    Route::get('new_tourist', 'Api\uon\in\InApiUonController@NewTourist');
    Route::get('delete_tourist', 'Api\uon\in\InApiUonController@DeleteTourist');
    Route::get('new_service', 'Api\uon\in\InApiUonController@NewService');
    Route::get('change_service', 'Api\uon\in\InApiUonController@ChangeService');
});
// Роутинг для админки
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\AdminController@index')->name('admin');
});

