@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 flex justify-between items-end border-b border-slate-800 pb-6">
            <div>
                <h1 class="text-amber-500 font-black text-4xl font-poppins tracking-tighter">ADMINISTRATION</h1>
                <p class="text-slate-400 text-sm uppercase tracking-widest mt-1">Gestion de la plateforme Eventus</p>
            </div>
            <div class="text-right">
                <span class="text-slate-500 text-xs block uppercase font-bold">Session sécurisée</span>
                <span class="text-emerald-400 font-mono text-sm">● Online</span>
            </div>
        </div>

        <div class="admin-card bg-white overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800 uppercase text-xs tracking-widest">🚨 Événements en attente de validation</h3>
                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">Urgent</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black">
                        <tr>
                            <th class="px-6 py-4">Nom de l'événement</th>
                            <th class="px-6 py-4">Organisateur</th>
                            <th class="px-6 py-4 text-center">Actions de Modération</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-700">Festival Jazz Kasbah</span>
                                <span class="block text-[10px] text-slate-400 italic">Soumis il y a 2h</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-sm font-medium">Association Tanger Culture</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-xl text-[10px] font-black transition shadow-lg shadow-emerald-100 uppercase">
                                        ✅ Valider
                                    </button>
                                    <button class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl text-[10px] font-black transition shadow-lg shadow-rose-100 uppercase">
                                        🚫 Bannir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection