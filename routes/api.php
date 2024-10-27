<?php

use App\Http\Controllers\CollegeControllerResource;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\GovernmentControllerResource;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubjectControllerResource;
use App\Http\Controllers\SubscriptionControllerResource;
use App\Http\Controllers\YearControllerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) { // auth default is web but in api we use sanctum
    return $request->user();
});

Route::group(['middleware' => 'changeLang'], function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::resources([
        'governments' => GovernmentControllerResource::class,
        'colleges' => CollegeControllerResource::class,
        'years' => YearControllerResource::class,
        'subjects' => SubjectControllerResource::class,
        'subscriptions' => SubscriptionControllerResource::class,
    ]);
    Route::post('/delete-item',DeleteController::class);
});

//Route::resources([
//    'governments' => GovernmentControllerResource::class
//]);
