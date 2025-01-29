<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Issues;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Theme;

class UserController extends Controller
{
    public function showUserProfile()
{
    // Assuming the user is authenticated
    $user = Auth::user(); // Fetch the authenticated user's data
    return view('user.dashboarduser', compact('user')); // Pass the user data to the view
 }
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user) return redirect('/');
            
            $recommendedArticles = Article::where('recommended', true)->get();
            $magazineIssues = Issues::all();
            $subscriptions = Subscription::where('user_id', $user->id)->get();
            
            return view('user.dashboarduser', compact('user', 'recommendedArticles', 'magazineIssues', 'subscriptions'));
        }

        return redirect('/');
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
    public function dashboard() {
        $user = Auth::user();
        $recommendedArticles = Article::where('category', $user->favorite_category)->get(); // Exemple de récupération
        $magazineIssues = Issues::all();
        $subscriptions = Subscription::where('user_id', $user->id)->get();
        return view('user.dashboarduser', compact('user', 'recommendedArticles','magazineIssues','subscriptions'));
    }
    
}
