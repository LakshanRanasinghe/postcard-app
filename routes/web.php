<?php

use Illuminate\Support\Facades\Route;
use App\Mail\SimpleMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/postcard/{id}', function ($id) {
    return view('postcard-show-page', ['id' => $id]);
})->name('postcard.show');

Route::get('/export', function () {
    return view('postcard-export-page');
})->name('export');

Route::post('/send-mail', function (Request $request) {
    $request->validate([
        'email' => 'required|email'
    ]);

    Mail::to($request->email)->send(new SimpleMail());

    return back()->with('success', 'Email sent successfully!');
})->name('send.mail');

Route::get('/test-mail/{email}', function ($email) {
    Mail::to($email)->send(new SimpleMail());
    return "Mail sent successfully to " . $email;
});
