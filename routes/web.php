<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\welcomeController;
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

// Using controller

// To welcome page
Route::get('/',[welcomeController::class,'index'])->name('index');

// To blog page
Route::get('/blog',[BlogController::class,'index'])->name('blog');

// To create blog post
Route::get('/blog/create',[BlogController::class,'create'])->name('blog.create');

// To single blog post
Route::get('/blog/{post:slug}',[BlogController::class,'show'])->name('blog.show');

// To store blog post to the db
Route::post('/blog',[BlogController::class,'store'])->name('blog.store');

// To  About page
Route::get('/about',function(){
    return view('about');
})->name('about');

// To contact page
Route::get('/contact',[ContactController::class,'index'])->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
