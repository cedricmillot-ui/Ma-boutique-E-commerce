<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="font-inter font-black text-3xl text-slate-800 tracking-tighter uppercase">
            Bon retour chez BY<span class="text-sky-500">FECT</span>
        </h1>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-2">
            Connectez-vous à votre espace client
        </p>
    </div>

    <x-auth-session-status class="mb-6 p-4 bg-sky-50 text-sky-600 rounded-2xl text-xs font-bold" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="email" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1">
                {{ __('Adresse Email') }}
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all placeholder-slate-300"
                placeholder="nom@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1" />
        </div>

        <div class="space-y-2">
            <div class="flex justify-between items-center ml-1">
                <label for="password" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest">
                    {{ __('Mot de passe') }}
                </label>
                @if (Route::has('password.request'))
                    <a class="text-[9px] font-black text-sky-400 hover:text-sky-600 uppercase tracking-tighter transition-colors" href="{{ route('password.request') }}">
                        {{ __('Oublié ?') }}
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-sky-200 focus:ring-0 transition-all"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1" />
        </div>

        <div class="flex items-center justify-between px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="rounded-lg border-slate-200 text-sky-500 shadow-sm focus:ring-sky-500/20 w-5 h-5 transition-all">
                <span class="ms-3 text-[11px] font-bold text-slate-400 group-hover:text-slate-600 transition-colors">{{ __('Rester connecté') }}</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-sky-500 text-white py-5 rounded-[2rem] font-inter font-black uppercase tracking-[0.2em] text-xs hover:bg-slate-900 shadow-xl shadow-sky-100 transition-all active:scale-[0.98]">
                {{ __('Se connecter') }}
            </button>
        </div>

        <div class="text-center pt-6">
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" class="text-sky-500 hover:underline ml-1">Créer un profil</a>
            </p>
        </div>
    </form>
</x-guest-layout>
