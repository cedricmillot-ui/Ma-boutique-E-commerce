<section class="bg-white p-8 sm:p-10 rounded-[3rem] border border-sky-100 shadow-sm shadow-sky-50">
    <header class="flex items-center gap-4 mb-10">
        <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div>
            <h2 class="font-inter font-black text-2xl text-slate-800 tracking-tighter uppercase">
                {{ __('Informations du profil') }}
            </h2>
            <p class="text-sky-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">
                {{ __("Identité et coordonnées de livraison") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        {{-- Ligne : Nom & Email --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label for="name" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">{{ __('Nom complet') }}</label>
                <input id="name" name="name" type="text" 
                    class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <label for="email" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">{{ __('Adresse Email') }}</label>
                <input id="email" name="email" type="email" 
                    class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                    value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 p-3 bg-amber-50 rounded-xl border border-amber-100">
                        <p class="text-xs text-amber-700 font-medium">
                            {{ __('Votre email n\'est pas vérifiée.') }}
                            <button form="send-verification" class="ml-2 underline font-bold hover:text-amber-900 transition-colors">
                                {{ __('Renvoyer le lien') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-bold text-[10px] text-emerald-600 uppercase tracking-tight">
                                {{ __('Nouveau lien envoyé !') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Ligne : Adresse --}}
        <div class="space-y-2">
            <label for="address" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">{{ __('Adresse de livraison') }}</label>
            <input id="address" name="address" type="text" 
                class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                value="{{ old('address', $user->address) }}" required autocomplete="street-address" 
                placeholder="N°, Rue..." />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        {{-- Ligne : CP & Ville --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label for="zip_code" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">{{ __('Code Postal') }}</label>
                <input id="zip_code" name="zip_code" type="text" 
                    class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-black focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                    value="{{ old('zip_code', $user->zip_code) }}" required autocomplete="postal-code" />
                <x-input-error class="mt-2" :messages="$errors->get('zip_code')" />
            </div>

            <div class="space-y-2">
                <label for="city" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">{{ __('Ville') }}</label>
                <input id="city" name="city" type="text" 
                    class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                    value="{{ old('city', $user->city) }}" required autocomplete="address-level2" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-6 pt-6 border-t border-sky-50">
            <button type="submit" class="bg-sky-500 text-white px-10 py-5 rounded-[2rem] font-inter font-black uppercase tracking-[0.2em] text-xs hover:bg-slate-800 shadow-xl shadow-sky-100 transition-all active:scale-[0.98]">
                {{ __('Enregistrer les modifications') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center gap-2 text-emerald-500 font-inter font-bold text-xs uppercase tracking-widest"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Mise à jour effectuée') }}
                </div>
            @endif
        </div>
    </form>
</section>
