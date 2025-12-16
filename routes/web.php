<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenelitianFileController;
use App\Http\Controllers\PenelitianImportController;

Route::post('/admin/penelitian/import', [PenelitianImportController::class, 'import'])
    ->name('penelitian.import');

Route::post('/penelitian/{penelitian}/upload', [PenelitianFileController::class, 'store'])
    ->name('penelitian.upload');

Route::get('/', function () {
    return view('welcome');
});
