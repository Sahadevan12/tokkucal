<?php

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Money tools
Route::get('/gst-calculator', [CalculatorController::class, 'gst'])->name('gst-calculator');
Route::post('/gst-calculator/calculate', [CalculatorController::class, 'gstCalculate'])
    ->name('gst-calculator.calculate')->middleware('throttle:60,1');

Route::get('/emi-calculator', [CalculatorController::class, 'emi'])->name('emi-calculator');
Route::post('/emi-calculator/calculate', [CalculatorController::class, 'emiCalculate'])
    ->name('emi-calculator.calculate')->middleware('throttle:60,1');

Route::get('/salary-calculator', [CalculatorController::class, 'salary'])->name('salary-calculator');
Route::post('/salary-calculator/calculate', [CalculatorController::class, 'salaryCalculate'])
    ->name('salary-calculator.calculate')->middleware('throttle:60,1');

Route::get('/discount-calculator', [CalculatorController::class, 'discount'])->name('discount-calculator');
Route::post('/discount-calculator/calculate', [CalculatorController::class, 'discountCalculate'])
    ->name('discount-calculator.calculate')->middleware('throttle:60,1');

// Student tools
Route::get('/percentage-calculator', [CalculatorController::class, 'percentage'])->name('percentage-calculator');
Route::post('/percentage-calculator/calculate', [CalculatorController::class, 'percentageCalculate'])
    ->name('percentage-calculator.calculate')->middleware('throttle:60,1');

Route::get('/age-calculator', [CalculatorController::class, 'age'])->name('age-calculator');
Route::post('/age-calculator/calculate', [CalculatorController::class, 'ageCalculate'])
    ->name('age-calculator.calculate')->middleware('throttle:60,1');

Route::get('/attendance-calculator', [CalculatorController::class, 'attendance'])->name('attendance-calculator');
Route::post('/attendance-calculator/calculate', [CalculatorController::class, 'attendanceCalculate'])
    ->name('attendance-calculator.calculate')->middleware('throttle:60,1');

// Image tools
Route::get('/image-compressor', [ImageController::class, 'compressor'])->name('image-compressor');
Route::post('/image-compressor/process', [ImageController::class, 'compress'])
    ->name('image-compressor.process')->middleware('throttle:20,1');

Route::get('/image-resizer', [ImageController::class, 'resizer'])->name('image-resizer');
Route::post('/image-resizer/process', [ImageController::class, 'resize'])
    ->name('image-resizer.process')->middleware('throttle:20,1');

// Utility tools
Route::get('/qr-generator', [QRCodeController::class, 'index'])->name('qr-generator');

// Company / legal
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])
    ->name('contact.send')->middleware('throttle:10,1');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');

// SEO
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
