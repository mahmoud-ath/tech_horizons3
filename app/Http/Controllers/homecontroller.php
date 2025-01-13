<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users;
use illuminate\support\facades\Auth;


class homecontroller extends Controller
{
    public function index()
    {
        if(auth::id())
        {
            $usertype=Auth()->user()->usertype;

            if($usertype=='user')
            {
                return view('dashboard');
            }
            if($usertype=='admin')
            {
                return view('admin.adminhome');
            }
            if($usertype=='moderator')
            {
                return view('dashboard');
            }
        }
    }
}
