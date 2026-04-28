<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Marque l'adresse e-mail de l'utilisateur connecté comme étant vérifiée.
     * Cette méthode est appelée automatiquement quand on clique sur le lien du mail.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Étape 1 : On vérifie si l'utilisateur a DÉJÀ vérifié son e-mail.
        // (Par exemple, s'il clique deux fois sur le même lien par erreur).
        if ($request->user()->hasVerifiedEmail()) {
            
            // S'il est déjà vérifié, on le redirige vers l'accueil (au lieu du dashboard).
            // Le petit "?verified=1" à la fin de l'URL permet à votre site de savoir 
            // qu'il vient de valider son e-mail (pratique pour afficher un petit message 
            // "Merci, e-mail vérifié !").
            return redirect()->intended('/?verified=1');
        }

        // Étape 2 : Si l'e-mail n'est pas encore vérifié, on le valide en base de données.
        // La méthode markEmailAsVerified() met la date et l'heure actuelles dans 
        // la colonne 'email_verified_at' de la table 'users'.
        if ($request->user()->markEmailAsVerified()) {
            
            // Étape 3 : On déclenche un événement Laravel pour signaler que le compte est vérifié.
            // Cela peut servir si vous avez d'autres actions à faire à ce moment-là
            // (ex: lui envoyer un e-mail de bienvenue avec un code promo !).
            event(new Verified($request->user()));
        }

        // Étape 4 : Redirection finale.
        // Une fois l'e-mail validé, on le redirige vers l'accueil avec le paramètre de succès.
        return redirect()->intended('/?verified=1');
    }
}