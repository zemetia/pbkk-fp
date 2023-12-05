<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/page/{page}', function () {
    return view('index');
});

Route::get('/u/{username}', function () {
    return view('dashboard.index');
});

Route::get('/u/{username}/articles', function () {
    return view('dashboard.articles');
});

Route::get('/q', function () {
    return view('search');
});

Route::get('/{username}/{slug}/edit', function () {
    return view('dashboard.edit');
});

Route::get('/write', function () {
    return view('dashboard.write');
});

Route::get('/{username}/{slug}', function () {
    return view('detail');
});

Route::get('/404', function () {
    return response()->json([
        "error" => true,
        "message" => "Halaman tidak ditemukan"
    ]);
});

Route::get('/403', function () {
    return response()->json([
        "error" => true,
        "message" => "Halaman tidak bisa diakses"
    ]);
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});