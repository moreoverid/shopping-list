<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ShoppingListsController;
use App\Http\Controllers\Api\V1\UsersController;

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

// SPA start page
Route::get('/', function () {
    return view('index');
});

// Session based API
Route::middleware([])->group(function() {
    Route::group(['prefix' => 'api/v1'], function () {
        Route::delete('shopping-list/remove-all', [ShoppingListsController::class, 'removeAll']);
        Route::apiResource('shopping-list', ShoppingListsController::class);
    });
});
