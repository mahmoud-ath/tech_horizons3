<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Magazine;
use App\Models\Subscription;
use Auth;

class userController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recommendedArticles = Article::where('recommended', true)->get();
        $magazineIssues = Magazine::all();
        $subscriptions = Subscription::where('user_id', $user->id)->get();

        return view('admin.dashboard', compact('user', 'recommendedArticles', 'magazineIssues', 'subscriptions'));
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
