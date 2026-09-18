<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::post('/contact', [PortfolioController::class, 'sendMessage'])->name('portfolio.contact');

Route::post('/comments', [CommentController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('comments.store');
