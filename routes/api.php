<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Clients\AuthController as AuthClient;
use App\Http\Controllers\Api\Clients\OrderController;
use App\Http\Controllers\Api\Restaurants\AuthController as AuthRestaurant;
use App\Http\Controllers\Api\Restaurants\MealController;
use App\Http\Controllers\Api\Restaurants\OfferController;
use App\Http\Controllers\Api\MainController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' =>'v1','namespace' => 'Api',],function(){


    Route::get('/cities',[MainController::class,'cities']);
    Route::get('/regions',[MainController::class,'regions']);
    Route::get('/settings',[MainController::class,'settings']);
    Route::get('/categories',[MainController::class,'categories']);
    Route::get('/payment-methods',[MainController::class,'paymentMethods']);
    Route::post('/contact',[MainController::class,'contact']);

    Route::get('/meal',[MainController::class,'meal']);
    Route::get('/meals',[MainController::class,'meals']);
    Route::get('/offer',[MainController::class,'offer']);
    Route::get('/all-offers',[MainController::class,'allOffers']);
    Route::get('/offers-by-restaurant',[MainController::class,'offersByRestaurant']);
   



    Route::group(['prefix' =>'client','namespace' => 'Clients'],function(){
        Route::post('/register',[AuthClient::class,'register']);
        Route::post('/login',[AuthClient::class,'login']);

        Route::post('/reset-password',[AuthClient::class,'resetPassword']);
        Route::post('/new-password',[AuthClient::class,'newPassword']);

        Route::post('/rates',[OrderController::class,'rates']);


        Route::group(['middleware'=>'auth:clients-api'],function(){

            Route::post('/profile',[AuthClient::class,'profile']);
            Route::post('register-token',[AuthClient::class,'registerToken']);
            Route::post('remove-token',[AuthClient::class,'removeToken']);
            Route::get('/notifications',[AuthClient::class,'notifications']);
            Route::get('/new-order',[OrderController::class,'newOrder']);

        

        });
    });

    Route::group(['prefix' =>'restaurant','namespace' => 'Restaurants'],function(){

        Route::post('/register',[AuthRestaurant::class,'register']);
        Route::post('/login',[AuthRestaurant::class,'login']);
        Route::post('/reset-password',[AuthRestaurant::class,'resetPassword']);
        Route::post('/new-password',[AuthRestaurant::class,'newPassword']);


        Route::group(['middleware'=>'auth:restaurants-api'],function(){
            Route::post('/profile',[AuthRestaurant::class,'profile']);
            Route::post('register-token',[AuthRestaurant::class,'registerToken']);
            Route::post('remove-token',[AuthRestaurant::class,'removeToken']);

            Route::post('new-meal',[MealController::class,'newMeal']);
            Route::post('update-meal',[MealController::class,'updateMeal']);
           Route::post('delete-meal',[MealController::class,'deleteMeal']);

           Route::post('new-offer',[OfferController::class,'newOffer']);
           Route::post('update-offer',[OfferController::class,'updateOffer']);
           Route::post('delete-offer',[OfferController::class,'deleteOffer']);

        });
    });
});

?>
