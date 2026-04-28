<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire du profil de l'utilisateur.
     * C'est la page "Mon Compte" où le client peut voir ses infos.
     */
    public function edit(Request $request): View
    {
        // On renvoie la vue 'profile.edit' en lui passant les données 
        // de l'utilisateur actuellement connecté ($request->user()).
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Met à jour les informations du profil (nom, e-mail).
     * Cette méthode est appelée quand le client clique sur "Sauvegarder".
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Étape 1 : On remplit le modèle utilisateur avec les données validées par le formulaire.
        // (La validation stricte des champs est externalisée dans le fichier ProfileUpdateRequest).
        $request->user()->fill($request->validated());

        // Étape 2 : Vérification intelligente du changement d'e-mail.
        // La méthode isDirty('email') est magique : elle vérifie si la nouvelle adresse e-mail 
        // tapée par le client est différente de celle actuellement sauvegardée en base de données.
        if ($request->user()->isDirty('email')) {
            // S'il a effectivement changé son e-mail, on annule la vérification de son compte.
            // La colonne 'email_verified_at' repasse à null, ce qui l'obligera à valider 
            // sa nouvelle adresse via un lien envoyé par e-mail !
            $request->user()->email_verified_at = null;
        }

        // Étape 3 : On sauvegarde les modifications dans la base de données.
        $request->user()->save();

        // Étape 4 : Redirection.
        // On le renvoie sur la page de son profil pour qu'il voie les changements,
        // avec un petit message flash 'profile-updated' (ex: "Profil mis à jour avec succès").
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Supprime définitivement le compte de l'utilisateur.
     * (Action irréversible, souvent appelée depuis un bouton "Supprimer mon compte" en bas du profil).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Étape 1 : Sécurité maximale.
        // Même si l'utilisateur est connecté, on l'oblige à retaper son mot de passe actuel
        // pour être sûr à 100% que ce n'est pas quelqu'un d'autre devant son écran.
        // L'erreur s'affichera sous le nom 'userDeletion' si le mot de passe est faux.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Étape 2 : On récupère l'instance de l'utilisateur.
        $user = $request->user();

        // Étape 3 : On le déconnecte du système.
        Auth::logout();

        // Étape 4 : On supprime purement et simplement son compte de la base de données.
        $user->delete();

        // Étape 5 : Nettoyage de sécurité.
        // On invalide sa session et on regénère le token CSRF pour éviter toute faille.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Étape 6 : La redirection finale ! 🎉
        // Comme pour vos demandes précédentes, la redirection par défaut est déjà fixée à '/',
        // l'ancien client retournera donc sur l'accueil de votre boutique après avoir supprimé son compte.
        return Redirect::to('/');
    }
}