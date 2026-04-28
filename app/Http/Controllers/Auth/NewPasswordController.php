<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Affiche la vue (le formulaire) pour créer un nouveau mot de passe.
     * L'utilisateur arrive ici après avoir cliqué sur le lien dans son e-mail.
     */
    public function create(Request $request): View
    {
        // On renvoie la vue en lui passant la requête actuelle.
        // C'est important car la requête contient le "token" (le jeton de sécurité unique)
        // et l'adresse e-mail cachés dans l'URL du lien cliqué.
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Traite la soumission du formulaire contenant le nouveau mot de passe.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Étape 1 : On valide les données envoyées par le formulaire.
        $request->validate([
            'token' => ['required'], // Le jeton de sécurité est obligatoire
            'email' => ['required', 'email'], // L'e-mail doit être valide
            // Le mot de passe doit être confirmé (champ 'password_confirmation' rempli) 
            // et respecter les règles de base de Laravel (ex: 8 caractères minimum).
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Étape 2 : Tentative de réinitialisation via le "Broker" de mots de passe de Laravel.
        // On lui donne les infos saisies et une fonction (Closure) à exécuter en cas de succès.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                // Si le token et l'e-mail sont bons, cette fonction s'exécute.
                // On met à jour le mot de passe de l'utilisateur (en le hachant pour la sécurité).
                // On regénère aussi un 'remember_token' pour déconnecter les autres sessions éventuelles.
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save(); // On sauvegarde en base de données

                // On déclenche un événement Laravel indiquant que le mot de passe a été changé.
                event(new PasswordReset($user));
            }
        );

        // Étape 3 : Gestion de la redirection finale selon le résultat.
        // On utilise encore une condition ternaire ( ? : )
        return $status == Password::PASSWORD_RESET
                    // Si succès : on redirige vers la page de connexion avec un message vert de succès.
                    // (💡 Note : Pas besoin de changer la redirection ici, on le renvoie vers /login logiquement !)
                    ? redirect()->route('login')->with('status', __($status))
                    
                    // Si échec (ex: token expiré ou e-mail incorrect) : on le renvoie sur le formulaire
                    // en gardant l'e-mail qu'il avait tapé, avec un message d'erreur rouge.
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}