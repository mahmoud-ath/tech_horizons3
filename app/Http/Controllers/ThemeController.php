<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('themes', compact('themes'));
    }
    public function show(Theme $theme)
    {
        $articles = $theme->articles()->get();
        return view('themes.show', compact('theme', 'articles'));
    }
}
