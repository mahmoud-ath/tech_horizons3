<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index($themeId)
    {
        $articles = Article::with('user')->where('theme_id', $themeId)->get();

        return view('annonces', compact('articles', 'themeId'));
    }

    public function show($themeId, $articleId)
    {
        $article = Article::with('user')->where('id', $articleId)->where('theme_id', $themeId)->firstOrFail();

        return view('article', compact('article', 'themeId'));
    }
}
