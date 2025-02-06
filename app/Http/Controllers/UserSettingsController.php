<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

    
    class UserSettingsController extends Controller
    {
        public function update(Request $request)
        {
            // Récupérer l'utilisateur actuellement authentifié
            $user = Auth::user();
    
            if (!$user) {
                return back()->with('error', 'Utilisateur non trouvé.');
            }
    
            // Validation des données
            $request->validate([
                'username' => 'required|string|max:255',
                'password' => 'nullable|min:6',
                'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            // Mettre à jour le nom d'utilisateur
            $user->name = $request->username;
    
            // Mettre à jour le mot de passe (si fourni)
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            // Gérer l'upload de l'image de profil
            if ($request->hasFile('user_image')) {
                // Supprimer l'ancienne image si elle existe
                if ($user->user_image) {
                    Storage::delete('public/profiles/' . $user->user_image);
                }
    
                // Sauvegarder la nouvelle image
                $imagePath = $request->file('user_image')->store('public/profiles');
                $user->user_image = basename($imagePath);
            }

            // Enregistrer les modifications
            $user->save();
    
            return back()->with('success', 'Paramètres mis à jour avec succès !');
        }
    }
    
    

