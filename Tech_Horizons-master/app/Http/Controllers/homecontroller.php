<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $usertype = $user->usertype;

            if ($usertype == 'user') {
                return view('user.dashboarduser');
            } elseif ($usertype == 'moderator') {
                return view('dashboard');
            } elseif ($usertype == 'admin') {
                $users = User::all();
                return view('admin.adminhome', compact('users'));
            }
        }

        return redirect('/');
    }
}
