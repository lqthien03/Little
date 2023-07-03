<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::controller(TicketController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/cancel', 'cancel')->name('checkout.cancel');
    Route::get('/success', 'success')->name('checkout.success');
    Route::post('/beforepay', 'beforepay')->name('beforepay');
    Route::post('/checkout', 'checkout')->name('checkout');
    Route::post('/save', 'save')->name('save');
    Route::post('/webhook', 'webhook')->name('webhook');
});

Route::get('/event', function () {
    return view('event');
});
Route::get('/contact', function () {
    return view('contact');
});
