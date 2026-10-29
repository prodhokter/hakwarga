@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center space-y-6">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-200 text-slate-800 text-xs font-semibold">
        <span>Tahap Pengembangan Milestone 2</span>
    </div>

    <h1 class="text-3xl font-extrabold text-slate-900 font-display">
        {{ $title }}
    </h1>

    <p class="text-base text-slate-600 max-w-xl mx-auto leading-relaxed">
        {{ $description }}
    </p>

    <div class="bg-white p-6 rounded-xl border border-slate-200 text-left max-w-lg mx-auto space-y-3">
        <h2 class="text-sm font-bold text-slate-900 font-display">Jadwal Rilis Kompetisi MIA 2026:</h2>
        <ul class="text-xs text-slate-600 space-y-2">
            <li class="flex items-center justify-between border-b border-slate-100 pb-1.5">
                <span>Milestone 1: First Draft &amp; Resi Tracker</span>
                <span class="font-bold text-emerald-700">Aktif (1 Nov 2026)</span>
            </li>
            <li class="flex items-center justify-between border-b border-slate-100 pb-1.5">
                <span>Milestone 2: Peta Anomali, Kanal Lapor, Scorecard SLA</span>
                <span class="font-semibold text-slate-500">11 Nov 2026</span>
            </li>
            <li class="flex items-center justify-between">
                <span>Milestone 3: Final Submission &amp; Sovereign VPS Deploy</span>
                <span class="font-semibold text-slate-500">28 Nov 2026</span>
            </li>
        </ul>
    </div>

    <div class="pt-4">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-md bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
