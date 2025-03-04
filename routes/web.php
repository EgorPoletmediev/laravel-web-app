<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Link;


//Route::view('/', 'files.index')->name('home')->middleware('auth:sanctum');
Route::redirect('/', '/files')->middleware('auth:sanctum');

Route::resource('files', FileController::class)->middleware('auth:sanctum'); //операции с файлами
//::get('files', [FileController::class, 'index'])->name('files.index')->middleware('auth:sanctum');
//Route::post('files', [FileController::class, 'store'])->middleware('auth:sanctum');
//Route::delete('files/{file}', [FileController::class, 'destroy'])->name('files.destroy')->middleware('auth:sanctum');

Route::view('/register','auth.register')->name('register'); //регистрация
Route::post('/register', [AuthController::class, 'register']);

Route::view('/login','auth.login')->name('login'); //логин
Route::post('/login', [AuthController::class, 'login']);

Route::post('/file', [FileController::class, 'store'])->name('store')->middleware('auth:sanctum'); //добавление файла

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum'); //выход из аккаунта

Route::resource('files/{file}/links',LinkController::class);//операции с ссылками
Route::post('/link', [LinkController::class, 'store'])->name('storeLink'); //создание новой ссылки


//Route::view('/download','down.download')->name('download'); //страница со скачиваниями

Route::get('/download/{link:link}', [LinkController::class, 'check_valid'])->name('download.link'); //проверка на существование ссылки

//Route::view('/download/{link:link}','down.download');
Route::post('/download/{link:link}', [LinkController::class, 'download'])->name('downloadLink'); //установка файла по ссылке
