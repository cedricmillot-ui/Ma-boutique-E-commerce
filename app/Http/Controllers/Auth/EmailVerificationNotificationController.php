<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Envoie une nouvelle notification de vérification par e-mail.
     * Cette méthode est appelée quand l'utilisateur demande manuellement 
     * à recevoir un nouveau lien de vérification.
     */
    public function store(Request $request): RedirectResponse
    {
        // On vérifie d'abord si l'utilisateur a DÉJÀ vérifié son e-mail.
        if ($request->user()->hasVerifiedEmail()) {
            
            // S'il l'a déjà fait (peut-être qu'il a rafraîchi la page par erreur), 
            // on le redirige vers sa destination prévue ou vers le "dashboard" par défaut.
            // 💡 ASTUCE : Comme pour les fichiers précédents, si vous n'utilisez plus le dashboard, 
            // vous pouvez remplacer la ligne ci-dessous par : return redirect()->intended('/');
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Si l'e-mail n'est pas encore vérifié, on déclenche l'envoi du message.
        // Laravel s'occupe de générer le lien sécurisé et d'envoyer l'e-mail en arrière-plan.
        $request->user()->sendEmailVerificationNotification();

        // Enfin, on redirige l'utilisateur vers la page d'où il vient (back)
        // en ajoutant un message flash 'status' dans la session.
        // Ce message ('verification-link-sent') servira à afficher une petite alerte verte 
        // du type "Un nouveau lien vous a été envoyé !" sur la vue.
        return back()->with('status', 'verification-link-sent');
    }
}