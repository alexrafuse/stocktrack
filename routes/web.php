<?php

use App\Models\Product;
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

Route::get('/products', function () {
    return Product::all();
});
Route::get('/retailers', function () {
    return Product::all();
});Route::get('/stock', function () {
    return Product::all();
});Route::get('/history', function () {
    return Product::all();
});Route::get('/', function () {
    return ['Welcome to stocktrack!'];
});

Route::get('/', function () {
    Product::all()->each->track();

});
