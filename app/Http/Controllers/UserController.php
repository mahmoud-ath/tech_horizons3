<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Issues;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Theme;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboarduser');
    }
    public function subscription()
    {
        // Fetch subscription data or perform any logic
        return redirect()->route('user.subscription'); // Assuming you have a `subscription.blade.php` view
    }

    public function myArticles()
    {dd('here') ;
        // Fetch articles created by the authenticated user
        $articles = Article::where('user_id', auth()->id())->get();
        return view('user.my-articles', compact('articles')); // Assuming you have a `my-articles.blade.php` view
    }
    public function browsingHistory()
    {
        // Fetch browsing history for the authenticated user
        $history = History::where('user_id', auth()->id())->get();
        return view('user.browsing-history', compact('history')); // Assuming you have a `browsing-history.blade.php` view
    }
    public function proposeArticle()
    {  dd('here');
        if (Auth::check()) {
            $user = Auth::user();

            // Fetch data required for the propose-article page
            $themes = Theme::all(); // Assuming you have a Theme model to fetch themes

            return view('user.proposearticle', compact('user', 'themes'));
        }

        return redirect('/');
    }
    public function settings()
    {
        // Your logic to retrieve and display user settings
        return view('user.settings'); // Ensure you have a `settings.blade.php` view file
    }
    public function showUserProfile()
{
    // Assuming the user is authenticated
    $user = Auth::user(); // Fetch the authenticated user's data
    return view('user.dashboarduser', compact('user')); // Pass the user data to the view
 }
    public function index()
    {
        // Get authenticated user
        $user = Auth::user();
        
        // Get recommended articles based on user subscriptions
        $recommendedArticles = Article::whereHas('themes', function($query) use ($user) {
            $query->whereIn('theme_id', $user->subscriptions->pluck('theme_id'));
        })
        ->where('status', 'Published')
        ->latest()
        ->take(5)
        ->get();

        // Get magazine issues
        $magazineIssues = Issues::where('status', 'Public')
            ->latest()
            ->take(5)
            ->get();

        // Get user subscriptions
        $subscriptions = $user->subscriptions->pluck('theme_id');
        dd($magazineIssues);

        return view('user.dashboard', compact('user', 'recommendedArticles', 'magazineIssues', 'subscriptions'));
    }

       
    public function showSubscriptions()
    {
        $themes = Theme::all(); // Récupère tous les thèmes
        return view('user.subscriptions', compact('themes'));
    }
    public function toggleSubscription(Request $request)
    {
        $subscription = Subscription::where('user_id', Auth::id())->where('theme', $request->theme)->first();
        if ($subscription) {
            $subscription->delete();
        } else {
            Subscription::create([
                'user_id' => Auth::id(),
                'theme' => $request->theme,
            ]);
        }

        return response()->json(['status' => 'success']);
    }
   

}
