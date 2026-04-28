<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Met à jour le mot de passe de l'utilisateur connecté.
     * C'est la méthode appelée quand on valide le formulaire "Modifier mon mot de passe"
     * dans les paramètres du profil.
     */
    public function update(Request $request): RedirectResponse
    {
        // Étape 1 : Validation des données envoyées par le formulaire.
        // On utilise "validateWithBag" ('updatePassword') au lieu du "validate" classique.
        // Cela permet à Laravel de grouper les erreurs spécifiques à ce formulaire sous le nom 'updatePassword'.
        // Très utile si vous avez plusieurs formulaires différents sur la même page (ex: profil + mot de passe) !
        $validated = $request->validateWithBag('updatePassword', [
            // L'utilisateur doit taper son mot de passe actuel, et la règle 'current_password' 
            // vérifie automatiquement en base de données que c'est bien le bon !
            'current_password' => ['required', 'current_password'],
            
            // Le nouveau mot de passe est requis, doit respecter les règles par défaut (ex: 8 caractères)
            // et doit être confirmé (tapé deux fois à l'identique).
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Étape 2 : Mise à jour en base de données.
        // On récupère l'utilisateur connecté via $request->user(), 
        // puis on met à jour son champ 'password'.
        $request->user()->update([
            // ⚠️ On n'oublie SURTOUT PAS de hacher (crypter) le nouveau mot de passe 
            // avec Hash::make() avant de le sauvegarder.
            'password' => Hash::make($validated['password']),
        ]);

        // Étape 3 : Redirection.
        // On renvoie l'utilisateur sur la page d'où il vient (back), 
        // qui est très probablement sa page de profil, avec un petit message flash de succès.
        return back()->with('status', 'password-updated');
    }
}