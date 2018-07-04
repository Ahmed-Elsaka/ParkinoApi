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
Route::post('/ChangePassword','UserController@ChangePassword');
Route::post('/ChangeUsername','UserController@ChangeUsername');
Route::post('/ChangeEmail','UserController@changeUserEmail');
Route::post('/ChangePhoneNumber','UserController@ChangePhoneNumber');
Route::post('/getGarages','UserController@getGarages');
Route::post('/userProfileData','UserController@userProfileData'); // fill user profile Activity with data
Route::post('/getMyCards','UserController@getMyCards');
Route::post('/getUserGarages','UserController@getUserGarages');
Route::post('/charge','UserController@charge'); // fill user profile Activity with data
Route::post('/feedback','UserController@feedback'); // send feedback
Route::post('/reserveSlot','UserController@reserveSlot'); // send feedback
Route::post('/searchForGarage','UserController@searchForGarage'); // send feedback
Route::post('/phoneCancellation','UserController@phoneCancellation'); // cancel using phone



// test guzzle
Route::get('/testGuzzel','UserController@testGuzzel'); // cancel using phone







// test if Api working
Route::get('/work','UserController@work');


// Rasp Routing
Route::POST('/getNewReservations','UserController@getNewReservations'); // send feedback40
Route::POST('/raspCancellation','UserController@raspCancellation'); // send feedback40
Route::get('/CarWentOut/{garage_id}/{RFID_card}','UserController@CarWentOut');

Route::get('/getGarageClients/{garage_id}','UserController@getGarageClients');



// Test
Route::post('/test','UserController@test');
Route::post('/testGuzzel','UserController@testGuzzel');















Route::get('/test','UserController@test');



