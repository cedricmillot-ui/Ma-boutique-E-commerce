<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Affiche l'écran demandant à l'utilisateur de vérifier son adresse e-mail.
     * * La méthode __invoke() permet d'appeler ce contrôleur comme s'il s'agissait 
     * d'une simple fonction. Elle est déclenchée quand un utilisateur essaie d'accéder 
     * à une page qui nécessite d'avoir un e-mail vérifié (middleware 'verified').
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // On utilise ici une condition ternaire ( condition ? si_vrai : si_faux )
        // Étape 1 : On vérifie si l'utilisateur a déjà validé son adresse e-mail.
        return $request->user()->hasVerifiedEmail()
        
                    // Étape 2 (Si VRAI) : S'il est déjà vérifié, il n'a rien à faire ici !
                    // On le renvoie vers sa page de destination ou vers le dashboard.
                    // 💡 ASTUCE : Encore une fois, si vous avez supprimé le dashboard,
                    // vous pouvez remplacer cette ligne par : ? redirect()->intended('/')
                    ? redirect()->intended(route('dashboard', absolute: false))
                    
                    // Étape 3 (Si FAUX) : S'il n'est pas encore vérifié, on lui affiche 
                    // la vue qui lui dit "Merci de vérifier votre boîte mail".
                    // C'est depuis cette vue qu'il pourra d'ailleurs cliquer sur "Renvoyer l'e-mail"
                    // (ce qui fera appel au contrôleur précédent qu'on a vu !).
                    : view('auth.verify-email');
    }
}