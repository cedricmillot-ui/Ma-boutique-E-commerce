<x-app-layout>
    {{-- Header --}}
    <div class="py-10 bg-white border-b border-sky-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.orders.index') }}" class="text-sky-500 font-bold text-xs uppercase tracking-widest flex items-center gap-2 mb-2 hover:text-sky-600 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    Retour aux commandes
                </a>
                <h2 class="font-inter font-extrabold text-4xl text-slate-900">Journal d'Activité</h2>
            </div>
            <div class="bg-slate-900 text-white px-6 py-2 rounded-2xl font-inter font-bold text-xs uppercase tracking-tighter shadow-xl shadow-slate-200">
                Live Audit
            </div>
        </div>
    </div>

    {{-- Liste des Logs --}}
    <div class="py-12 bg-[#f8fbff]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-100/50 border border-sky-50 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-sky-50">
                            <th class="p-6 font-inter font-black text-[10px] uppercase tracking-widest text-slate-400">Date & Heure</th>
                            <th class="p-6 font-inter font-black text-[10px] uppercase tracking-widest text-slate-400">Utilisateur</th>
                            <th class="p-6 font-inter font-black text-[10px] uppercase tracking-widest text-slate-400">Action</th>
                            <th class="p-6 font-inter font-black text-[10px] uppercase tracking-widest text-slate-400">Description détaillée</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($logs as $log)
                            <tr class="hover:bg-sky-50/20 transition-colors">
                                <td class="p-6 font-dm text-xs text-slate-400">
                                    {{ $log->created_at->translatedFormat('d M Y') }}
                                    <span class="block font-bold text-slate-500">{{ $log->created_at->format('H:i:s') }}</span>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 font-bold text-[10px]">
                                            {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <span class="font-inter font-bold text-sm text-slate-900">{{ $log->user->name ?? 'Système / Visiteur' }}</span>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                        {{ $log->action == 'CREATION' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}
                                        {{ $log->action == 'MODIFICATION' ? 'bg-sky-50 text-sky-600 border border-sky-100' : '' }}
                                        {{ $log->action == 'SUPPRESSION' ? 'bg-red-50 text-red-600 border border-red-100' : '' }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="p-6">
                                    <p class="font-dm text-sm text-slate-600 italic leading-relaxed">
                                        {{ $log->description }}
                                    </p>
                                    <span class="text-[9px] text-slate-300 font-mono mt-1 block">IP: {{ $log->ip_address }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center">
                                    <p class="font-inter font-bold text-slate-300 italic text-xl">Aucun événement enregistré pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
