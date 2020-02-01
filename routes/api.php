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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Api\UserController@logout')->name('logout');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function(){
Route::get('details', 'API\UserController@details');

//master letter
Route::get('master/letter/alldata', 'API\MasterLetterController@allData');
Route::get('master/letter/getdata/{id}', 'API\MasterLetterController@getData');
Route::post('master/letter/insert', 'API\MasterLetterController@insertData');
Route::put('master/letter/update/{id}', 'API\MasterLetterController@updateData');
Route::delete('master/letter/delete/{id}', 'API\MasterLetterController@deleteData');

//management
Route::get('management/alldata', 'API\ManagementController@allData');
Route::get('management/getdata/{id}', 'API\ManagementController@getData');
Route::post('management/insert', 'API\ManagementController@insertData');
Route::post('management/update/{id}', 'API\ManagementController@updateData');
Route::delete('management/delete/{id}', 'API\ManagementController@deleteData');

Route::get('management/pagination/alldata/{show_data},{page}', 'API\ManagementController@paginationAlldata');
});