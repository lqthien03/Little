<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Mail\ThankYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;    
use App\Mail\ContactEmail;
use Barryvdh\DomPDF\Facade as PDF;
// use PDF;


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
    Route::post('/webhook', 'webhook')->name('webhook');
    Route::post('/save', 'save')->name('save');
});


Route::controller(EventController::class)->group(function () {
    Route::get('/event', 'event')->name('events.event');
    Route::get('/event-detail/{id}', 'eventDetail')->name('events.event_detail');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/send-contact', [ContactController::class, 'contact'])->name('send-contact');
Route::post('/send-contact', [ContactController::class, 'sendContact'])->name('send-contact');

