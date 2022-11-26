<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



route::view('/operator-index', 'operator.index');

Route::get('/operator/all',['uses' => 'operatorController@getoperatorAll','as' => 'operator.getoperatorall'] );

Route::resource('operator', 'operatorController');

Route::resource('service', 'serviceController');

route::view('/service-index', 'service.index');


