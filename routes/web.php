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
use App\Http\Controllers\AdminUserController;



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

Route::get('/user/dashboarduser', [UserController::class, 'index'])->middleware('auth');

Route::get('/', [IssueController::class, 'index'])->name('/.index');

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


// Route to display articles based on theme ID
Route::get('/themes/{themeId}', [ArticleController::class, 'index'])->middleware('auth.custom');

// Route to display a specific article
Route::get('/themes/{themeId}/articles/{articleId}', [ArticleController::class, 'show'])->middleware('auth.custom');



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

//Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::match(['get', 'post'], '/admin/adminhome', [AdminDashboardController::class, 'admin'])->name('adminhome');
    Route::post('/admin/users/toggle/{id}', [AdminDashboardController::class, 'toggleUserStatus'])->name('admin.users.toggle');
    Route::delete('/admin/users/delete/{id}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');


});
Route::get('/user/dashboarduser', [UserController::class, 'dashboard'])->name('user.dashboarduser');
Route::get('/user/subscription', [UserController::class, 'subscription'])->name('user.subscription');
Route::get('/user/my-articles', [UserController::class, 'myArticles'])->name('user.myArticle');
Route::get('/user/browsing-history', [UserController::class, 'browsingHistory'])->name('user.browsing-history');
Route::get('/user/settings', [UserController::class, 'settings'])->name('user.settings');
Route::get('/user/settings', [UserController::class, 'settings'])->name('user.settings');

// Other routes...






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
Route::get('/user/dashboard', [UserController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth');
Route::post('/toggle-subscription', [UserController::class, 'toggleSubscription']);
Route::get('/subscriptions', [UserController::class, 'showSubscriptions']);
