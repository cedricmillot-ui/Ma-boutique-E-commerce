<section class="bg-white p-8 sm:p-10 rounded-[3rem] border border-red-50 shadow-sm shadow-red-50/50">
    <header class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </div>
        <div>
            <h2 class="font-inter font-black text-2xl text-slate-800 tracking-tighter uppercase">
                {{ __('Zone de danger') }}
            </h2>
            <p class="text-red-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">
                {{ __('Action irréversible sur vos données') }}
            </p>
        </div>
    </header>

    <div class="max-w-2xl">
        <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de procéder, veuillez télécharger les informations que vous souhaitez conserver.') }}
        </p>

        <button 
            x-data="" 
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-red-50 text-red-500 px-8 py-4 rounded-2xl font-inter font-black uppercase tracking-widest text-[10px] hover:bg-red-500 hover:text-white transition-all active:scale-95"
        >
            {{ __('Supprimer le compte') }}
        </button>
    </div>

    {{-- Modal de confirmation stylisée --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white rounded-[3rem]">
            @csrf
            @method('delete')

            <h2 class="font-inter font-black text-2xl text-slate-800 tracking-tighter uppercase mb-4">
                {{ __('Êtes-vous sûr de vouloir quitter l\'aventure ?') }}
            </h2>

            <p class="text-sm text-slate-500 font-medium mb-8">
                {{ __('Cette action est définitive. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer votre compte de manière permanente.') }}
            </p>

            <div class="mb-8">
                <label for="password" class="block font-inter font-black text-[10px] text-slate-400 uppercase tracking-widest ml-1 mb-2">{{ __('Mot de passe de confirmation') }}</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-slate-800 font-bold focus:bg-white focus:border-red-200 focus:ring-0 transition-all" 
                    placeholder="{{ __('Saisissez votre mot de passe') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-4">
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-8 py-4 rounded-2xl font-inter font-black uppercase tracking-widest text-[10px] text-slate-400 hover:text-slate-600 transition-all"
                >
                    {{ __('Annuler') }}
                </button>

                <button 
                    type="submit"
                    class="bg-red-500 text-white px-8 py-4 rounded-2xl font-inter font-black uppercase tracking-widest text-[10px] hover:bg-slate-900 shadow-xl shadow-red-100 transition-all"
                >
                    {{ __('Confirmer la suppression') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
