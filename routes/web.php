<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NumberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\IssueController;
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


Route::get('/', [IssueController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'index']);

Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');
Route::get('/a_propos', function () {
    return view('a_propos');
});
Route::get('/contact_us', function () {
    return view('contact_us');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user', [userController::class, 'index'])->name('user.dashboard');
Route::post('/toggle-subscription', [userController::class, 'toggleSubscription'])->name('user.toggleSubscription');

// Default Breeze routes (login, registration, etc.)
require __DIR__.'/auth.php';

// Admin routes (restricted to admin users)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Add the route for toggling user status
    Route::post('/admin/users/toggle/{user}', [AdminDashboardController::class, 'toggleUserStatus'])->name('admin.users.toggle');
    Route::delete('/admin/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');
    // Store a new user
    Route::post('/admin/users/store', [AdminDashboardController::class, 'storeUser'])->name('admin.users.store');

    // Update admin settings
    Route::post('/home#settings', [AdminDashboardController::class, 'updateSettings'])->name('settings.update');    // routes/web.php

    Route::get('/admin/adminhome', [AdminDashboardController::class, 'managethemes']);



});

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
