<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Theme;

class UserProposalController extends Controller
{
    public function submitArticle(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'theme_id' => 'required|array',
            'imagepath' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string|max:1000',
        ]);
    
        // Handle file upload for cover image
        $coverPath = $request->file('imagepath')->store('cover_images', 'public');
    
        // Create and save the new article
        $article = new Article();
        $article->title = $validated['title'];
        $article->theme_id = implode(',', $validated['theme_id']); // Save multiple themes as a comma-separated string
        $article->imagepath = $coverPath;
        $article->description = $validated['description'];
        $article->status = 'pending'; // Set the status to "pending"
        $article->save();
        dd($request->all());

        // Redirect back with success message
        return redirect()->back()->with('success', 'Article proposé avec succès!');
    }
    
    public function showProposalForm()
{
    $themes = Theme::all(); // Assuming you are passing themes to the view
    return view('user.propose-article', compact('themes'));
}

}
