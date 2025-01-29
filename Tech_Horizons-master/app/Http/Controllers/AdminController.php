<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with statistics
     */
    public function index()
    {
        $statistics = [
            'totalSubscribers' => User::where('usertype', 'user')->count(),
            'activeSubscribers' => User::where('usertype', 'user')
                                     ->whereNotNull('email_verified_at')
                                     ->count(),
            'totalThemes' => Theme::count(),
            'activeThemes' => Theme::where('status', 'Public')->count(),
            'totalNumbers' => Number::count(),
            'publishedNumbers' => Number::where('status', 'Public')->count(),
            'totalArticles' => Article::count(),
            'publishedArticles' => Article::where('status', 'Published')->count(),
            'pendingArticles' => Article::where('status', 'Pending')->count(),
        ];

        return view('adminhome', compact('statistics'));
    }

    public function managethemes()
    {
        $themes = Theme::all();
        return view('admin.adminhome', compact('themes')); // Updated view name
    }

    /**
     * Show users management page
     */
    public function manageUsers(Request $request)
    {
        $query = User::query();

        // Apply role filter if provided
        if ($request->has('role') && $request->role !== 'all') {
            $query->where('usertype', $request->role);
        }

        $users = $query->get();
        return view('admin.adminhome', compact('users'));
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'usertype' => 'required|in:admin,user',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'usertype' => $validated['usertype'],
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully');
    }

    /**
     * Update user status (block/unblock)
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->save();

        $status = $user->email_verified_at ? 'unblocked' : 'blocked';
        return redirect()->back()->with('success', "User {$status} successfully");
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }


    /**
     * Update admin settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'profile-image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Assuming the authenticated user
        $user = auth()->user();

        // Update username
        $user->username = $request->username;

        // Update password if provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Update profile image if provided
        if ($request->hasFile('profile-image')) {
            // Delete old profile image if exists
            if ($user->profile_image) {
                Storage::delete($user->profile_image);
            }

            // Store new image
            $path = $request->file('profile-image')->store('profile-images');
            $user->profile_image = $path;
        }

        // Save user data
        $user->save();

        return response()->json(['message' => 'Settings updated successfully!', 'username' => $user->username, 'profile_image' => $user->profile_image]);
    }


    /**
     * Get dashboard statistics via API
     */
    public function getStatistics()
    {
        $statistics = DB::select("
            SELECT
                (SELECT COUNT(*) FROM users WHERE usertype = 'user') as total_subscribers,
                (SELECT COUNT(*) FROM users WHERE usertype = 'user' AND email_verified_at IS NOT NULL) as active_subscribers,
                (SELECT COUNT(*) FROM themes) as total_themes,
                (SELECT COUNT(*) FROM themes WHERE status = 'Public') as active_themes,
                (SELECT COUNT(*) FROM numbers) as total_numbers,
                (SELECT COUNT(*) FROM numbers WHERE status = 'Public') as published_numbers,
                (SELECT COUNT(*) FROM articles) as total_articles,
                (SELECT COUNT(*) FROM articles WHERE status = 'Published') as published_articles,
                (SELECT COUNT(*) FROM articles WHERE status = 'Pending') as pending_articles
        ");

        return response()->json($statistics[0]);
    }

    /**
     * Handle user search and filtering
     */
    public function searchUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('usertype')) {
            $query->where('usertype', $request->usertype);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->paginate(10);
        return view('admin.adminhome', compact('users'));
    }
}
