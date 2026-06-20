<?php

use App\Http\Controllers\BackgroundRemovalController;
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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/download/{jobId}/{quality?}', [BackgroundRemovalController::class, 'download'])
    ->whereIn('quality', ['standard', 'hd'])
    ->name('bgify.download');

Route::get('/result/{jobId}', [BackgroundRemovalController::class, 'show'])
    ->name('bgify.result');
