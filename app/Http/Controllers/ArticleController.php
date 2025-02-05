<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index($themeId)
    {
        $articles = Article::with('user')->where('theme_id', $themeId)->get();

        return view('gestion des articles.annonces', compact('articles', 'themeId'));
    }

    public function show($themeId, $articleId)
    {
        $article = Article::with('user')->where('id', $articleId)->where('theme_id', $themeId)->firstOrFail();

        return view('gestion des articles.article', compact('article', 'themeId'));
    }
    public function showArticlesByIssue($issue_id)
    {
        $articles = Article::with('user')
            ->where('issue_id', $issue_id)
            ->get();

        return view('gestion des articles.numbers', compact('articles', 'issue_id'));
    }
}
