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
// Phone routing
Route::post('/login','UserController@login');
Route::post('/register','UserController@register');
Route::post('/bindcard','UserController@bindcard');
Route::post('/unbindcard','UserController@unbindcard');
Route::post('/getMyCards','UserController@getMyCards');
Route::post('/getUserGarages','UserController@getUserGarages');
Route::post('/ChangePassword','UserController@ChangePassword');
Route::post('/ChangeUsername','UserController@ChangeUsername');
Route::post('/ChangeEmail','UserController@changeUserEmail');
Route::post('/ChangePhoneNumber','UserController@ChangePhoneNumber');
Route::post('/getGarages','UserController@getGarages');
Route::post('/userProfileData','UserController@userProfileData'); // fill user profile Activity with data
Route::post('/charge','UserController@charge'); // fill user profile Activity with data
Route::post('/feedback','UserController@feedback'); // send feedback




// test if Api working
Route::get('/work','UserController@work');


// Rasp Routing
Route::get('/getNewReservations/{garage_id}','UserController@getNewReservations'); // send feedback40
Route::get('/CarWentOut/{garage_id}/{RFID_card}','UserController@CarWentOut');

Route::get('/getGarageClients/{garage_id}','UserController@getGarageClients');



// Test
Route::get('/test/{slot?}','UserController@test');















Route::get('/test','UserController@test');



