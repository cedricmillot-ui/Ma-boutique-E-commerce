<section class="bg-white p-8 sm:p-10 rounded-[3rem] border border-sky-100 shadow-sm shadow-sky-50">
    <header class="flex items-center gap-4 mb-10">
        <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <div>
            <h2 class="font-inter font-black text-2xl text-slate-800 tracking-tighter uppercase">
                {{ __('Sécurité du compte') }}
            </h2>
            <p class="text-sky-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">
                {{ __('Utilisez un mot de passe complexe pour protéger vos accès.') }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        {{-- Mot de passe actuel --}}
        <div class="space-y-2 max-w-md">
            <label for="update_password_current_password" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">
                {{ __('Mot de passe actuel') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Nouveau mot de passe & Confirmation (En parallèle) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label for="update_password_password" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">
                    {{ __('Nouveau mot de passe') }}
                </label>
                <input id="update_password_password" name="password" type="password" 
                    class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <label for="update_password_password_confirmation" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">
                    {{ __('Confirmer le mot de passe') }}
                </label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                    class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all" 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        {{-- Bouton d'action --}}
        <div class="flex items-center gap-6 pt-6 border-t border-sky-50">
            <button type="submit" class="bg-sky-500 text-white px-10 py-5 rounded-[2rem] font-inter font-black uppercase tracking-[0.2em] text-xs hover:bg-slate-800 shadow-xl shadow-sky-100 transition-all active:scale-[0.98]">
                {{ __('Mettre à jour') }}
            </button>

            @if (session('status') === 'password-updated')
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
                    {{ __('Sécurité mise à jour') }}
                </div>
            @endif
        </div>
    </form>
</section>
