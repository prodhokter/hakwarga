@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <a href="{{ route('scorecard.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-700 dark:text-slate-300 hover:underline font-semibold mb-3">
            &larr; Kembali ke papan peringkat scorecard
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $details['agency_type'] }} &bull; {{ $details['region_name'] }}</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-display mt-0.5">
                    {{ $details['agency_name'] }}
                </h1>
            </div>
            <div>
                @php
                    $gradeBadge = match($details['grade']) {
                        'A' => 'bg-emerald-100 dark:bg-emerald-950 text-emerald-900 dark:text-emerald-300 border-emerald-300 dark:border-emerald-700',
                        'B' => 'bg-blue-100 dark:bg-blue-950 text-blue-900 dark:text-blue-300 border-blue-300 dark:border-blue-700',
                        'C' => 'bg-amber-100 dark:bg-amber-950 text-amber-900 dark:text-amber-300 border-amber-300 dark:border-amber-700',
                        default => 'bg-rose-100 dark:bg-rose-950 text-rose-900 dark:text-rose-300 border-rose-300 dark:border-rose-700',
                    };
                @endphp
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $gradeBadge }}">
                    Nilai Mutu {{ $details['grade'] }} (Skor: {{ $details['final_score'] }})
                </span>
            </div>
        </div>
    </div>

    {{-- Performance Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="starline-card p-5 rounded-2xl shadow-xs">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">Total Aduan Terdistribusi</span>
            <div class="text-3xl font-extrabold font-mono text-slate-900 dark:text-white mt-1 tabular-nums">{{ $details['total_reports'] }}</div>
            <span class="text-[11px] text-slate-500">{{ $details['due_response_count'] }} telah jatuh tempo evaluasi</span>
        </div>

        <div class="starline-card p-5 rounded-2xl shadow-xs">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">Kepatuhan Respon Awal (&le; 72 Jam)</span>
            <div class="text-3xl font-extrabold font-mono text-emerald-700 dark:text-emerald-400 mt-1 tabular-nums">{{ $details['response_rate'] }}%</div>
            <span class="text-[11px] text-slate-500">{{ $details['response_ok_count'] }} dari {{ $details['due_response_count'] }} laporan tepat waktu</span>
        </div>

        <div class="starline-card p-5 rounded-2xl shadow-xs">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">Kepatuhan Selesai (&le; 14 Hari)</span>
            <div class="text-3xl font-extrabold font-mono text-emerald-700 dark:text-emerald-400 mt-1 tabular-nums">{{ $details['resolve_rate'] }}%</div>
            <span class="text-[11px] text-slate-500">{{ $details['resolve_ok_count'] }} dari {{ $details['due_resolve_count'] }} laporan tuntas</span>
        </div>
    </div>

    {{-- Recent Reports Audit --}}
    <div class="starline-card p-6 rounded-2xl shadow-xs space-y-4">
        <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Daftar Aduan Terkait Instansi Ini</h2>
        <div class="divide-y divide-slate-100 dark:divide-slate-800">
            @forelse($reports as $report)
                <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-900 dark:text-white">{{ $report->ticket_code }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">&bull; {{ $report->category }}</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-1">{{ $report->description }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $report->status->badgeClass() }}">
                            {{ $report->status->label() }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-500 py-4 text-center">Belum ada catatan aduan untuk instansi ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
