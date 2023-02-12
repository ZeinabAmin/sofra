<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\RestaurantController;
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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

// Auth::routes([
//     "register" => false
// ]);


 //Route::group( ['middleware' => 'auth'], function () {

//    Route::get('/home', [HomeController::class, 'index'])->name('home');

   Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::resource('cities', CityController::class);
    Route::resource('regions', RegionController::class);

     Route::resource('categories', CategoryController::class);
   Route::resource('payment-methods', PaymentMethodController::class);
  Route::resource('settings', SettingController::class);


   Route::get('clients-activate/{id}', [ClientController::class, 'activate'])->name('clients.activate');
    Route::get('clients-deactivate/{id}', [ClientController::class, 'deactivate'])->name('clients.deactivate');
    Route::resource('clients', ClientController::class);


    Route::resource('contacts', ContactController::class);
    Route::resource('offers', OfferController::class);


    Route::get('restaurants-activate/{id}', [RestaurantController::class, 'activate'])->name('restaurants.activate');
    Route::get('restaurants-deactivate/{id}', [RestaurantController::class, 'deactivate'])->name('restaurants.deactivate');
    Route::resource('restaurants', RestaurantController::class);
   
// });
