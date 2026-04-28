<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Affiche la vue de confirmation du mot de passe.
     * Cette page apparaît quand un utilisateur connecté essaie d'accéder
     * à une zone très sensible (ex: modifier ses infos bancaires) et 
     * que Laravel veut s'assurer que c'est bien lui devant l'écran.
     */
    public function show(): View
    {
        // Renvoie le fichier blade contenant le formulaire de confirmation
        return view('auth.confirm-password');
    }

    /**
     * Traite la soumission du formulaire et confirme le mot de passe.
     */
    public function store(Request $request): RedirectResponse
    {
        // On vérifie si le mot de passe tapé correspond bien à l'utilisateur actuellement connecté
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Si le mot de passe est incorrect, on renvoie une erreur de validation 
            // qui s'affichera sous le champ du formulaire
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // Si le mot de passe est correct, on enregistre dans la session 
        // l'heure exacte (timestamp) de cette confirmation. 
        // Cela permet à Laravel de ne pas redemander le mot de passe pendant un certain temps.
        $request->session()->put('auth.password_confirmed_at', time());

        // On redirige l'utilisateur vers la page qu'il essayait d'atteindre initialement (intended).
        // Si cette page n'est pas connue, on l'envoie par défaut vers la route 'dashboard'.
        // (C'est ici que vous pourriez remplacer par redirect()->intended('/') si vous n'utilisez plus le dashboard).
        return redirect()->intended(route('dashboard', absolute: false));
    }
}