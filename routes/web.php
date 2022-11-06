<?php

use App\Http\Controllers\ActivationCodeController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\ManageContentBookController;
use App\Http\Controllers\Offline\ManageOfflineBookController;
use App\Http\Controllers\Offline\OfflineApiController;
use App\Http\Controllers\Offline\OfflineManagementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingController;
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

Route::post( "login", [ UserController::class, "login" ] );

Route::match( [ "get", "post" ], "logout", [ UserController::class, "logout" ] );

Route::group( [ "middleware" => "ensureUserLoggedIn", "prefix" => "dashboard" ] , function() {
 
    Route::get( "/", [ UserController::class, "dashboard" ] );
 
    Route::group( [ "prefix" => "discount-code" ], function() {
        Route::get( "/", [ DiscountCodeController::class, "index" ] );
        Route::post( "create", [ DiscountCodeController::class, "create" ] );
        Route::post( "load", [ DiscountCodeController::class, "load" ] );
        Route::post( "remove", [ DiscountCodeController::class, "remove" ] );
    } );

    Route::group( [ "prefix" => "manage-book-content" ], function() {
        Route::get( "/", [ ManageContentBookController::class, "index" ] );
        Route::get( "list-grade", [ ManageContentBookController::class, "listGrade" ] );
        Route::get( "list-book", [ ManageContentBookController::class, "listBook" ] );
        Route::get( "list-content", [ ManageContentBookController::class, "listContent" ] );

        Route::get( "list-all-book", [ ManageContentBookController::class, "listAllBooks" ] );

        Route::post( "content-remove", [ ManageContentBookController::class, "contentRemove" ] );
        Route::post( "content-update", [ ManageContentBookController::class, "contentUpdate" ] );
    } );

    Route::group( [ "prefix" => "generate-activation-code" ], function() {
        Route::get( "/", [ ActivationCodeController::class, "index" ] );

        Route::group( [ "prefix" => "api" ], function() {
            Route::post( "generate-code", [ ActivationCodeController::class, "generate" ] );
            Route::get( "list-code", [ ActivationCodeController::class, "list" ] );
            Route::get( "list-product", [ ProductController::class, "list" ] );
        } );
    } );

    Route::group( [ "prefix" => "user" ], function() {
        Route::group( [ "prefix" => "management" ], function() {
            Route::get( "/", [ UserController::class, "management" ] );
            Route::get( "list", [ UserController::class, "list" ] );
            Route::get( "user-registered-by-admin", [ UserController::class, "managementRegisteredUsersByAdmin" ] );
            Route::get( "user-list-by-admin", [ UserController::class, "listUsersRegisteredByAdmin" ] );
            Route::post( "remove", [ UserController::class, "remove" ] );
            Route::post( "update", [ UserController::class, "update" ] );
            Route::post( "reset-password", [ UserController::class, "resetPassword" ] );

            Route::get( "register-form", [ UserController::class, "registerPage" ] );
            Route::post( "register", [ UserController::class, "register" ] );
        } );
    } );

    Route::group( [ "prefix" => "offline" ], function() {
        Route::group( [ "prefix" => "management" ], function() {
            Route::get( "/", [ OfflineManagementController::class, "management" ] );
            Route::get( "list", [ OfflineManagementController::class, "list" ] );
            Route::post( "remove", [ OfflineManagementController::class, "remove" ] );
            Route::post( "update", [ OfflineManagementController::class, "update" ] );

            Route::get( "statistics", [ OfflineManagementController::class, "statistics" ] );
        } );
    } );

    Route::group( [ "prefix" => "shopping" ], function() {
        Route::get( "/", [ ShoppingController::class, "index" ] );
        Route::get( "list", [ ShoppingController::class, "list" ] );
    } );
} );

Route::group( [ "prefix" => "api/offline" ], function() {
    Route::get( "version", [ OfflineApiController::class, "getVersion" ] );

    Route::group( [ "prefix" => "list" ], function() {
        Route::get( "book", [ OfflineApiController::class, "getListBooks" ] );
        Route::get( "video", [ OfflineApiController::class, "getListVideos" ] );
    } );

    Route::group( [ "prefix" => "activation" ], function() {
        Route::post( "generate-code-page", [ ManageOfflineBookController::class, "generateActivationCodePage" ] );
        Route::post( "recaptcha", [ ManageOfflineBookController::class, "refreshCaptcha" ] );

        // Route::get( "add-codes-to-db", [ ManageOfflineBookController::class, "addCodesFromExcelToDB" ] );
        // Route::get( "update-codes-for-shopping", [ ManageOfflineBookController::class, "updateSiteCodesFromExcelToDB" ] );
    } );
} );

Route::get( "/sms/get.php", [ ManageOfflineBookController::class, "generateActivationCode" ] );
Route::get( "activation", [ ManageOfflineBookController::class, "page" ] );