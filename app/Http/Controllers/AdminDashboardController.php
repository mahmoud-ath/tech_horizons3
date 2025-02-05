<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Issues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function admin(Request $request)
    {
        // Handle the creation of a new article
        if ($request->isMethod('post') && $request->has('title')) {
            $article = new Article();
            $article->title = $request->title;
            $article->theme_id = $request->theme;
            $article->user_id = Auth::id();
            $article->status = $request->status;
            $article->content = $request->content;

            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $filePath = $file->store('covers', 'public');
                $article->imagepath = $filePath;
            }

            $article->published_date = now();
            $article->save();

            return redirect()->back()->with('success', 'Article created successfully!');
        }

        // Handle the creation of a new user
        if ($request->isMethod('post') && $request->has('name')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'usertype' => 'required|string',
                'status' => 'required|string',
            ]);

            $validatedData['password'] = Hash::make('password');
            $user = User::create($validatedData);

            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        }

        // Fetch statistics for dashboard
        $totalSubscribers = User::count();
        $activeSubscribers = User::whereNotNull('email_verified_at')->count();
        $totalThemes = Theme::count();
        $activeThemes = Theme::where('status', 'active')->count();
        $totalNumbers = Issues::count();
        $publishedNumbers = Issues::where('status', 'published')->count();
        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $pendingArticles = Article::where('status', 'pending')->count();

        $articles = Article::with('theme')->get();
        $users = User::all();
        $themes = Theme::withCount('articles')->get();
        $issues = Issues::all();

        return view('admin.adminhome', compact(
            'articles',
            'users',
            'themes',
            'totalSubscribers',
            'activeSubscribers',
            'totalThemes',
            'activeThemes',
            'totalNumbers',
            'publishedNumbers',
            'totalArticles',
            'publishedArticles',
            'pendingArticles',
            'issues' // Add this line to pass issues to the view

        ));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'usertype' => 'required|string',
            'status' => 'required|string',
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully']);
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

    // Theme management functions
    public function storeTheme(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'responsible' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $theme = Theme::create($validatedData);

        return response()->json(['message' => 'Theme created successfully', 'theme' => $theme], 201);
    }

    public function updateTheme(Request $request, $id)
    {
        $theme = Theme::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'responsible' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $theme->update($validatedData);

        return response()->json(['message' => 'Theme updated successfully']);
    }

    public function deleteTheme($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->delete();

        return response()->json(['message' => 'Theme deleted successfully']);
    }

    // Issues management functions
    public function storeIssue(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'publication_date' => 'required|date',
            'imagepath' => 'required|string',
        ]);

        $issue = Issues::create($validatedData);

        return response()->json(['message' => 'Issue created successfully', 'issue' => $issue], 201);
    }

    public function updateIssueStatus(Request $request, $id)
    {
        $issue = Issues::findOrFail($id);
        $issue->status = $request->status;
        $issue->save();

        return response()->json(['message' => 'Issue status updated successfully', 'issue' => $issue]);
    }

    public function deleteIssue($id)
    {
        $issue = Issues::findOrFail($id);
        $issue->delete();

        return response()->json(['message' => 'Issue deleted successfully']);
    }

    public function getIssues()
    {
        $issues = Issues::all();
        return response()->json($issues);
    }



    public function update(Request $request) {
        $article = Article::find($request->id);
        if ($article) {
            $article->status = $request->status;
            $article->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function delete(Request $request) {
        $article = Article::find($request->id);
        if ($article) {
            $article->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function updateSettings(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'user_name' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
                'profile_image' => 'nullable|image|max:2048',
            ]);

            // Update username
            $user->user_name = $request->user_name;

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Update profile image if provided
            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $user->user_image = $imagePath;
            }

            $user->save();

            return redirect()->back()->with('success', 'Settings updated successfully.');

        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Error updating settings: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating settings. Please try again.');
        }
    }


}


