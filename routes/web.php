<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/postcard/{id}', function ($id) {
    return view('postcard-show-page', ['id' => $id]);
})->name('postcard.show');

Route::get('/export', function () {
    return view('postcard-export-page');
})->name('export');
