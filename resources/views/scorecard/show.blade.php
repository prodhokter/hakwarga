@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <a href="{{ route('scorecard.index') }}" class="inline-flex items-center text-xs text-teal-800 hover:underline font-medium mb-3">
            &larr; Kembali ke papan peringkat scorecard
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs text-slate-500 font-medium">{{ $details['agency_type'] }} &bull; {{ $details['region_name'] }}</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display mt-0.5">
                    {{ $details['agency_name'] }}
                </h1>
            </div>
            <div>
                @php
                    $gradeBadge = match($details['grade']) {
                        'A' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                        'B' => 'bg-blue-100 text-blue-900 border-blue-300',
                        'C' => 'bg-amber-100 text-amber-900 border-amber-300',
                        default => 'bg-rose-100 text-rose-900 border-rose-300',
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
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <span class="text-xs text-slate-500 font-medium">Total Aduan Terdistribusi</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1">{{ $details['total_reports'] }}</div>
            <span class="text-[11px] text-slate-500">{{ $details['due_response_count'] }} telah jatuh tempo evaluasi</span>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <span class="text-xs text-slate-500 font-medium">Kepatuhan Respon Awal (&le; 72 Jam)</span>
            <div class="text-2xl font-bold font-mono text-emerald-800 mt-1">{{ $details['response_rate'] }}%</div>
            <span class="text-[11px] text-slate-500">{{ $details['response_ok_count'] }} dari {{ $details['due_response_count'] }} laporan tepat waktu</span>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
            <span class="text-xs text-slate-500 font-medium">Kepatuhan Selesai (&le; 14 Hari)</span>
            <div class="text-2xl font-bold font-mono text-emerald-800 mt-1">{{ $details['resolve_rate'] }}%</div>
            <span class="text-[11px] text-slate-500">{{ $details['resolve_ok_count'] }} dari {{ $details['due_resolve_count'] }} laporan tuntas</span>
        </div>
    </div>

    {{-- Recent Reports Audit --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
        <h2 class="text-lg font-bold text-slate-900 font-display">Daftar Aduan Terkait Instansi Ini</h2>
        <div class="divide-y divide-slate-100">
            @forelse($reports as $report)
                <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-900">{{ $report->ticket_code }}</span>
                            <span class="text-xs text-slate-500">&bull; {{ $report->category }}</span>
                        </div>
                        <p class="text-xs text-slate-600 line-clamp-1">{{ $report->description }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $report->status->badgeClass() }}">
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
