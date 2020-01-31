<?php
declare(strict_types=1);

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

Route::post('auth/login', 'AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('auth/logout', 'AuthController@logout');
    Route::get('auth/refresh', 'AuthController@refresh');
    Route::get('auth/me', 'AuthController@me');

    Route::apiResource('projects', 'ProjectsController')
        ->only(['index','store']);
    Route::apiResource('projects.icons', 'ProjectsIconsController')
        ->only(['store','destroy']);
});
