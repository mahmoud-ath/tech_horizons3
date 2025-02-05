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
use App\Http\Controllers\ResponsableDashboardController;


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

//route accueil
Route::get('/', [IssueController::class, 'index'])->name('/.index');
//a-propos
Route::get('/a_propos', function () {
    return view('accueil.a_propos');
});
//contact us
Route::get('/contact_us', function () {
    return view('accueil.contact_us');
});
//after login
Route::get('/home', [HomeController::class, 'index']);
// Default Breeze routes (login, registration, etc.)
require __DIR__.'/auth.php';




// gestion  des articles
// themes
Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');

//page articles d'un nombre
Route::get('/numbers/{issue_id}', [IssueController::class, 'showArticlesByIssue'])->name('issue.articles')->middleware('auth.custom');
//page article d'un nombre
Route::get('/numbers/{issue_id}/{article_id}', [IssueController::class, 'showArticle'])->name('issue.article')->middleware('auth.custom');


// Route to display articles based on theme ID
Route::get('/themes/{themeId}', [ArticleController::class, 'index'])->middleware('auth.custom');

// Route to display a specific article
Route::get('/themes/{themeId}/articles/{articleId}', [ArticleController::class, 'show'])->middleware('auth.custom');





// responsable

Route::middleware(['auth', 'moderator'])->group(function () {
    Route::match(['get', 'post'], '/respo/moderatorhome', [ResponsableDashboardController::class, 'showDashboard'])->name('moderatorhome');
});





//admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::match(['get', 'post'], '/admin/adminhome', [AdminDashboardController::class, 'admin'])->name('adminhome');
    Route::post('/api/users', [AdminDashboardController::class, 'admin']);
    Route::put('/api/users/{id}', [AdminDashboardController::class, 'updateUser']);
    Route::post('/api/users/{id}/toggle-block', [AdminDashboardController::class, 'toggleUserStatus'])->name('admin.users.toggle');
    Route::delete('/api/users/{id}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');
    //
    Route::get('/articles', [AdminDashboardController::class, 'index']);
    Route::post('/articles/update', [AdminDashboardController::class, 'update']);
    Route::post('/articles/delete', [AdminDashboardController::class, 'delete']);
    // Theme management routes

    Route::post('/api/themes', [AdminDashboardController::class, 'storeTheme']);
    Route::put('/api/themes/{id}', [AdminDashboardController::class, 'updateTheme']);
    Route::delete('/api/themes/{id}', [AdminDashboardController::class, 'deleteTheme']);

    // Issues management routes
    Route::get('/api/issues', [AdminDashboardController::class, 'getIssues']);
    Route::post('/api/issues', [AdminDashboardController::class, 'storeIssue']);
    Route::put('/api/issues/{id}/status', [AdminDashboardController::class, 'updateIssueStatus']);
    Route::delete('/api/issues/{id}', [AdminDashboardController::class, 'deleteIssue']);
    //settings
    Route::post('/admin/update-settings', [AdminDashboardController::class, 'updateSettings'])->name('admin.updateSettings');
});






//user
Route::get('/user/dashboarduser', [UserController::class, 'dashboard'])->name('user.dashboarduser');
Route::get('/user/subscription', [UserController::class, 'subscription'])->name('user.subscription');
Route::get('/user/my-articles', [UserController::class, 'myArticles'])->name('user.myArticle');
Route::get('/user/browsing-history', [UserController::class, 'browsingHistory'])->name('user.browsing-history');
Route::get('/user/settings', [UserController::class, 'settings'])->name('user.settings');
Route::get('/user/proposearticle', [UserController::class, 'proposeArticle'])->name('user.proposearticle');

/*
//TEST A VERIFIE

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user', [userController::class, 'index'])->name('user.dashboard');
Route::post('/toggle-subscription', [userController::class, 'toggleSubscription'])->name('user.toggleSubscription');





// Other routes...

Route::get('/user/dashboard', [UserController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth');
Route::post('/toggle-subscription', [UserController::class, 'toggleSubscription']);

*/
