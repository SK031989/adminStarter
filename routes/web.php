<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MarketingController;

Route::get('/',           [MarketingController::class, 'index'])->name('marketing.index');
Route::get('/features',   [MarketingController::class, 'features'])->name('marketing.features');
Route::get('/pricing',    [MarketingController::class, 'pricing'])->name('marketing.pricing');
Route::get('/contact',    [MarketingController::class, 'contact'])->name('marketing.contact');
