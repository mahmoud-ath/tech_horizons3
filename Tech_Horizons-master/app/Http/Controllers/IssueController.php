<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issues;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issues::all();
        return view('firstpage', compact('issues'));
    }
}
