<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tracking_status/add', 'Controller@tracking_status_add');
Route::post('/tracking_status/add_bulk', 'Controller@tracking_status_add_bulk');

Route::post('/orders/delete_bulk', 'Controller@delete_bulk');


Route::post('/form/submit', 'FormsController@viewFormPost');
Route::post('/contact-form/submit', 'ContactsController@viewFormPost');
Route::any('/sendBulkMessage', 'Controller@sendBulkMessage');

Route::any('/checkBusinessEmail', 'Controller@checkBusinessEmail');
Route::any('/shareOrderDelivered', 'Controller@shareOrderDelivered');

Route::any('/delNotification', 'Controller@delNotification');
Route::any('/clearNotifications/{id}', 'Controller@clearNotifications');
