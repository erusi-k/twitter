<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\controllers\ShareController;
use App\Http\controllers\CommentController;
use App\Http\controllers\LikeController;

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

    Route::apiResource("/user",UserController::class);
    Route::apiResource('/share',ShareController::class);
    Route::apiResource('/comment',CommentController::class);
    Route::apiResource('/like',LikeController::class);