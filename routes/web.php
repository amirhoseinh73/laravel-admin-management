<?php

use App\Http\Controllers\UserController;
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

Route::get( "/", [ UserController::class, "index" ] )->middleware( "ensureUserNotLoggedIn" );

Route::post( "login-submit", [ UserController::class, "login" ] );

Route::match( [ "get", "post" ], "logout", [ UserController::class, "logout" ] );

Route::group( [ "middleware" => "ensureUserLoggedIn", "prefix" => "dashboard" ] , function() {
 
    Route::get( "/", [ UserController::class, "dashboard" ] );
 
} );
