<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('stripe', [StripeController::class, 'Stripe'])->name('stripe');
Route::get('success/stripe', [StripeController::class, 'Success'])->name('success.stripe');
Route::get('cancle/stripe', [StripeController::class, 'Cancle'])->name('cancle.stripe');
