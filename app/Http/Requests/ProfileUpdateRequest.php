<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Récupère les règles de validation qui s'appliquent à cette requête.
     */
    public function rules(): array
    {
        return [
            // Nom
            'name' => ['required', 'string', 'max:255'], 

            // Email avec gestion de l'unique
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // --- AJOUTS BYFECT SHOP ---
            
            'address' => ['required', 'string', 'max:255'],

            'zip_code' => ['required', 'string', 'max:10'],

            'city' => ['required', 'string', 'max:100'],
        ];
    }
}