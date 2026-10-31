@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center space-y-6">
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 text-xs font-semibold shadow-xs">
        <span class="w-2 h-2 rounded-full bg-[#c2e050]"></span>
        <span>Tahap Akselerasi Platform</span>
    </div>

    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white font-display">
        {{ $title }}
    </h1>

    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
        {{ $description }}
    </p>

    <div class="starline-card p-6 rounded-2xl text-left max-w-lg mx-auto space-y-3">
        <h2 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider font-display">Status Rilis Platform Kinerja:</h2>
        <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-2">
            <li class="flex items-center justify-between border-b border-slate-200/50 dark:border-slate-800 pb-1.5">
                <span>Resi Tracker (Modul A)</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400">&check; Aktif</span>
            </li>
            <li class="flex items-center justify-between border-b border-slate-200/50 dark:border-slate-800 pb-1.5">
                <span>Peta Anomali Bansos (Modul B)</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400">&check; Aktif</span>
            </li>
            <li class="flex items-center justify-between border-b border-slate-200/50 dark:border-slate-800 pb-1.5">
                <span>Kanal Lapor &amp; Tiket Rahasia (Modul C)</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400">&check; Aktif</span>
            </li>
            <li class="flex items-center justify-between">
                <span>Scorecard SLA &amp; Data Publik (Modul D)</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400">&check; Aktif</span>
            </li>
        </ul>
    </div>

    <div class="pt-2">
        <a href="{{ route('home') }}" class="btn-starline-primary text-xs font-bold">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
