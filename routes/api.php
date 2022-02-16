<?php

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

Route::post('register','UserController@register');
Route::post('login','UserController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::group(
        ['prefix' => 'references', 'as' => 'references.', 'namespace' => 'References'],
        base_path('routes/api/references.php')
    );

    Route::get('user','UserController@getAuthenticatedUser');
    Route::get('owners/{owner}/patients','OwnerController@patients');
    Route::post('logout','UserController@logout');
    Route::get('user-columns','UserController@columns');
    Route::apiResource('users', 'UserController')
        ->only('index', 'store', 'destroy');
    Route::apiResource('owners', 'OwnerController')
        ->only('index', 'store', 'destroy');
    Route::apiResource('patients', 'PatientController')
        ->only('index', 'store', 'destroy');
});
