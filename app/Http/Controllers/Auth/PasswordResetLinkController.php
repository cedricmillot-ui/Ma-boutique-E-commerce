<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Affiche la vue de demande de lien de réinitialisation.
     * C'est tout simplement la page "Mot de passe oublié ?" 
     * où l'utilisateur tape son adresse e-mail.
     */
    public function create(): View
    {
        // On renvoie le formulaire correspondant
        return view('auth.forgot-password');
    }

    /**
     * Traite la demande d'envoi du lien de réinitialisation.
     * Cette méthode est appelée quand l'utilisateur valide le formulaire avec son e-mail.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Étape 1 : Validation.
        // On vérifie que le champ e-mail a bien été rempli et qu'il a un format valide.
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Étape 2 : Tentative d'envoi du lien.
        // On utilise la façade 'Password' de Laravel. Celle-ci va chercher en base de données
        // s'il existe bien un utilisateur avec cet e-mail. 
        // Si oui, elle génère un jeton (token) sécurisé et lui envoie l'e-mail.
        $status = Password::sendResetLink(
            $request->only('email') // On ne passe que l'e-mail pour la recherche
        );

        // Étape 3 : Gestion de la réponse selon le statut renvoyé par l'étape 2.
        // On utilise encore notre fameuse condition ternaire ( ? : )
        return $status == Password::RESET_LINK_SENT
                    // Si l'e-mail a bien été envoyé (RESET_LINK_SENT) :
                    // On renvoie l'utilisateur sur la même page (back) avec un message flash 
                    // de succès (ex: "Nous vous avons envoyé un lien par e-mail !").
                    ? back()->with('status', __($status))
                    
                    // Si ça a échoué (ex: aucun compte n'existe avec cet e-mail) :
                    // On le renvoie sur la même page, on garde l'e-mail qu'il avait tapé (withInput)
                    // pour qu'il n'ait pas à tout retaper, et on affiche l'erreur correspondante.
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}