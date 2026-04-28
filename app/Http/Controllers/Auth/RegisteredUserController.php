<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue (le formulaire) d'inscription.
     */
    public function create(): View
    {
        // Renvoie la page où l'utilisateur saisit son nom, e-mail et mot de passe.
        return view('auth.register');
    }

    /**
     * Traite la soumission du formulaire d'inscription.
     * C'est ici que la magie opère pour créer un nouveau compte !
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Étape 1 : On valide les données envoyées par le visiteur.
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // Le nom est obligatoire
            
            // L'e-mail doit être valide et surtout UNIQUE dans la table des utilisateurs (User::class).
            // Impossible de créer deux comptes avec la même adresse !
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            
            // Le mot de passe doit être confirmé (tapé deux fois) et respecter les règles de sécurité.
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Étape 2 : Création de l'utilisateur en base de données.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // ⚠️ Règle d'or : On hache TOUJOURS le mot de passe avant de le sauvegarder.
            'password' => Hash::make($request->password),
        ]);

        // Étape 3 : On déclenche un événement Laravel.
        // C'est ce qui indique au système qu'un nouvel utilisateur vient d'arriver.
        // Cela sert notamment à déclencher l'envoi de l'e-mail de vérification (si vous l'avez activé).
        event(new Registered($user));

        // Étape 4 : On connecte automatiquement ce nouvel utilisateur.
        // C'est plus sympa pour lui : pas besoin de se reconnecter juste après s'être inscrit !
        Auth::login($user);

        // Étape 5 : La redirection finale ! 🚨
        // AVANT, c'était : return redirect(route('dashboard', absolute: false));
        // MAINTENANT, on le redirige directement vers l'accueil ('/'), comme pour la connexion classique.
        return redirect('/');
    }
}