<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/get/{context}/{method}', [RequestController::class, 'GetRequestApi']);
    Route::post('/post/{context}/{method}', [RequestController::class, 'PostRequestApi']);
 });
