<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Link;


//Route::view('/', 'files.index')->name('home')->middleware('auth:sanctum');
Route::redirect('/', '/files')->middleware('auth:sanctum');

Route::resource('files', FileController::class)->middleware('auth:sanctum');

Route::view('/register','auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::view('/login','auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/file', [FileController::class, 'store'])->name('store')->middleware('auth:sanctum');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::resource('files/{file}/links',LinkController::class)->middleware('auth:sanctum');
Route::post('/link', [LinkController::class, 'store'])->name('storeLink')->middleware('auth:sanctum');


Route::view('/download','down.download')->name('download');

Route::get('/download/{link:link}', function ($link) {
    $link = Link::where('link', $link)->first();
    if (!$link) {
        return redirect()->route('download')->withErrors([
            'link' => 'The provided link is invalid.',
        ]);
    }
    return view('down.download', ['link' => $link]);
})->name('download.link');

//Route::view('/download/{link:link}','down.download');
Route::post('/download/{link:link}', [LinkController::class, 'download'])->name('downloadLink');
