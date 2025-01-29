<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homecontroller;
use App\http\Controllers\themecontroller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (){
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/home',[homecontroller::class,'index']);
Route::get('/themes', [ThemeController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';









Route::get('/others/auth', function () {
    return view('/others/auth');
});
Route::get('/others/themes', function () {
    return view('others/themes');
});
Route::get('/others/public_articles', function () {
    return view('others/public_articles');
});
Route::get('/others/home', function () {
    return view('others/home');
});
Route::get('/others/articles', function () {
    return view('others/articles');
});
Route::get('/others/article_details', function () {
    return view('others/article_details');
});
