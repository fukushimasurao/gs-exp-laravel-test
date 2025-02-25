<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/hello', function () {
//     return '<h1>HELLO WORLD</h1>';
// });

// Route::get('/hello', 'HelloController@hello');

Route::get('/hello', [HelloController::class, 'hello']);

Route::get('/members', [MemberController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);
