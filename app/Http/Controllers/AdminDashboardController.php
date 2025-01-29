<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function admin(Request $request)
    {
        // Handle the creation of a new article
        if ($request->isMethod('post')) {
            $article = new Article();
            $article->title = $request->title;
            $article->theme_id = $request->theme;
            $article->published_date = $request->published_date;
            $article->status = $request->status;
            $article->content = $request->content;

            // Handle file upload
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $filePath = $file->store('covers', 'public');
                $article->imagepath = $filePath;
            }

            $article->save();

            // Load theme relationship for response
            $article->load('theme');

            return response()->json($article);
        }

        // Handle displaying articles and users
        $articles = Article::with('theme')->get();
        $users = User::all();

        return view('admin.adminhome', compact('articles', 'users'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
