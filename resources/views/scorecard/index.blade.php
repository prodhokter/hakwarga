@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8"
     x-data="{
         searchQuery: '',
         typeFilter: 'all',
         expandedRow: null,
         sortBy: 'score',
         sortDir: 'desc',
         toggleExpand(id) {
             this.expandedRow = this.expandedRow === id ? null : id;
         }
     }">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 dark:bg-teal-950 border border-teal-200 dark:border-teal-800 text-teal-800 dark:text-teal-300 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-teal-600 dark:bg-teal-400"></span>
                <span>Modul D: Akuntabilitas Pelayanan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-display">
                Scorecard SLA Instansi Penyalur Bansos
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
                Peringkat kepatuhan instansi penyalur dalam merespon aduan warga (target 72 jam) dan menyelesaikan tindak lanjut (target 14 hari) dengan bobot seimbang 50:50.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('data.export', ['dataset' => 'sla']) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-xs min-h-[44px]">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh Data CSV
            </a>
        </div>
    </div>

    {{-- Top Summary Cards --}}
    @php
        $avgScore = $scorecard->count() > 0 ? round($scorecard->avg('final_score'), 1) : 0;
        $bestAgency = $scorecard->first();
        $attentionAgency = $scorecard->last();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="hw-card p-5 rounded-xl">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">Rata-Rata Skor Kepatuhan</span>
            <div class="text-3xl font-extrabold font-mono text-slate-900 dark:text-white mt-1 tabular-nums">{{ $avgScore }}</div>
            <span class="text-[11px] text-slate-500">Standar evaluasi kompetitif</span>
        </div>

        @if($bestAgency)
        <div class="hw-card p-5 rounded-xl border-l-4 border-l-emerald-600">
            <span class="text-xs font-semibold text-emerald-800 dark:text-emerald-400 block">Kepatuhan Tertinggi (Peringkat 1)</span>
            <div class="text-lg font-bold text-slate-900 dark:text-white mt-1 line-clamp-1 font-display">{{ $bestAgency['agency_name'] }}</div>
            <span class="text-[11px] font-mono text-emerald-700 dark:text-emerald-400 font-semibold">Skor: {{ $bestAgency['final_score'] }} (Mutu {{ $bestAgency['grade'] }})</span>
        </div>
        @endif

        @if($attentionAgency)
        <div class="hw-card p-5 rounded-xl border-l-4 border-l-amber-500">
            <span class="text-xs font-semibold text-amber-800 dark:text-amber-400 block">Perlu Peningkatan Kecepatan</span>
            <div class="text-lg font-bold text-slate-900 dark:text-white mt-1 line-clamp-1 font-display">{{ $attentionAgency['agency_name'] }}</div>
            <span class="text-[11px] font-mono text-amber-700 dark:text-amber-400 font-semibold">Respon: {{ $attentionAgency['response_rate'] }}%</span>
        </div>
        @endif
    </div>

    {{-- Interactive Visual Benchmark Chart with 100% Target Line --}}
    <div class="hw-card p-6 rounded-2xl shadow-xs space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
            <div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Grafik Benchmark Kepatuhan SLA Instansi</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Tingkat respon &le; 72 jam vs penyelesaian &le; 14 hari terhadap garis target merah</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-800 dark:text-teal-300 bg-teal-50 dark:bg-teal-950 px-2.5 py-1 rounded-md border border-teal-200 dark:border-teal-800">
                    Target Standar: 100%
                </span>
            </div>
        </div>
        <div class="h-[280px] w-full pt-2">
            <canvas id="sla-benchmark-chart"></canvas>
        </div>
    </div>

    {{-- Filter & Search Controls --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        {{-- Search Input --}}
        <div class="relative flex-1 max-w-sm">
            <input
                type="text"
                x-model="searchQuery"
                placeholder="Cari nama instansi..."
                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 pl-9 pr-3.5 py-2 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[40px]"
            >
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        {{-- Type Filter Pills --}}
        <div class="flex items-center gap-1.5">
            <button
                type="button"
                @click="typeFilter = 'all'"
                :class="typeFilter === 'all' ? 'bg-teal-700 text-white font-bold' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200'"
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors cursor-pointer"
            >
                Semua Tipe
            </button>
            <button
                type="button"
                @click="typeFilter = 'Dinas Sosial'"
                :class="typeFilter === 'Dinas Sosial' ? 'bg-teal-700 text-white font-bold' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200'"
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors cursor-pointer"
            >
                Dinas Sosial
            </button>
            <button
                type="button"
                @click="typeFilter = 'Penyalur'"
                :class="typeFilter === 'Penyalur' ? 'bg-teal-700 text-white font-bold' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200'"
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors cursor-pointer"
            >
                Penyalur Resmi
            </button>
        </div>
    </div>

    {{-- Scorecard Interactive Table --}}
    <div class="hw-card rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold w-16 text-center">Peringkat</th>
                        <th class="py-3.5 px-4 font-semibold">Instansi Penyalur</th>
                        <th class="py-3.5 px-4 font-semibold">Wilayah &amp; Tipe</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Respon &le; 72 Jam</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Selesai &le; 14 Hari</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Skor Akhir</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Mutu</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($scorecard as $index => $row)
                        @php
                            $gradeBadge = match($row['grade']) {
                                'A' => 'bg-emerald-100 dark:bg-emerald-950 text-emerald-900 dark:text-emerald-300 border-emerald-300 dark:border-emerald-700',
                                'B' => 'bg-blue-100 dark:bg-blue-950 text-blue-900 dark:text-blue-300 border-blue-300 dark:border-blue-700',
                                'C' => 'bg-amber-100 dark:bg-amber-950 text-amber-900 dark:text-amber-300 border-amber-300 dark:border-amber-700',
                                default => 'bg-rose-100 dark:bg-rose-950 text-rose-900 dark:text-rose-300 border-rose-300 dark:border-rose-700',
                            };
                        @endphp
                        {{-- Main Row --}}
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors"
                            x-show="(typeFilter === 'all' || '{{ $row['agency_type'] }}'.includes(typeFilter)) && ('{{ strtolower($row['agency_name']) }}'.includes(searchQuery.toLowerCase()))">
                            <td class="py-4 px-4 font-bold text-center text-slate-900 dark:text-white font-mono">
                                #{{ $index + 1 }}
                            </td>
                            <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">
                                <a href="{{ route('scorecard.show', ['agency' => $row['agency_slug']]) }}" class="hover:text-teal-700 dark:hover:text-teal-400 underline">
                                    {{ $row['agency_name'] }}
                                </a>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600 dark:text-slate-400">
                                <div>{{ $row['agency_type'] }}</div>
                                <div class="text-slate-400 text-[11px] font-medium">{{ $row['region_name'] }}</div>
                            </td>
                            <td class="py-4 px-4 text-center font-mono">
                                <span class="font-bold {{ $row['response_rate'] >= 80 ? 'text-emerald-800 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-300' }}">
                                    {{ $row['response_rate'] }}%
                                </span>
                                <span class="text-[11px] text-slate-400 block">({{ $row['response_ok_count'] }}/{{ $row['due_response_count'] }})</span>
                            </td>
                            <td class="py-4 px-4 text-center font-mono">
                                <span class="font-bold {{ $row['resolve_rate'] >= 80 ? 'text-emerald-800 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-300' }}">
                                    {{ $row['resolve_rate'] }}%
                                </span>
                                <span class="text-[11px] text-slate-400 block">({{ $row['resolve_ok_count'] }}/{{ $row['due_resolve_count'] }})</span>
                            </td>
                            <td class="py-4 px-4 text-center font-mono font-extrabold text-base text-teal-800 dark:text-teal-400 tabular-nums">
                                {{ $row['final_score'] }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-sm border {{ $gradeBadge }}">
                                    {{ $row['grade'] }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <button type="button" @click="toggleExpand({{ $row['agency_id'] }})" class="inline-flex items-center gap-1 text-xs font-semibold text-teal-800 dark:text-teal-400 hover:underline cursor-pointer">
                                    <span x-text="expandedRow === {{ $row['agency_id'] }} ? 'Tutup' : 'Rumus'"></span>
                                    <svg class="w-3.5 h-3.5 transform transition-transform" :class="expandedRow === {{ $row['agency_id'] }} ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>

                        {{-- Expandable Formula Detail Row --}}
                        <tr x-show="expandedRow === {{ $row['agency_id'] }}" x-cloak class="bg-teal-50/40 dark:bg-slate-900/80 border-t border-b border-teal-200 dark:border-teal-900">
                            <td colspan="8" class="p-4 text-xs">
                                <div class="bg-white dark:bg-slate-950 p-4 rounded-xl border border-teal-200 dark:border-teal-800 space-y-2">
                                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                                        <span class="font-bold text-slate-900 dark:text-white font-display">Transparansi Rumus Skor: {{ $row['agency_name'] }}</span>
                                        <span class="font-mono text-xs text-teal-800 dark:text-teal-400 font-bold">Hasil Akhir: {{ $row['final_score'] }} / 100</span>
                                    </div>
                                    <div class="font-mono text-[11px] text-slate-700 dark:text-slate-300 space-y-1">
                                        <div>&bull; Skor Komposit = (50% &times; % Respon Tepat Waktu) + (50% &times; % Penyelesaian Tuntas)</div>
                                        <div>&bull; Perhitungan: (0.5 &times; {{ $row['response_rate'] }}%) + (0.5 &times; {{ $row['resolve_rate'] }}%) = <strong class="text-teal-800 dark:text-teal-400">{{ $row['final_score'] }}</strong></div>
                                        <div>&bull; Ambang Mutu: Nilai {{ $row['grade'] }} (Kategori {{ $row['final_score'] >= 85 ? 'Sangat Baik (A)' : ($row['final_score'] >= 70 ? 'Baik (B)' : 'Cukup (C)') }})</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-500 text-sm">
                                Belum ada data instansi yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Methodology Explanation Callout --}}
    <div class="hw-card p-6 rounded-2xl space-y-3">
        <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Standar Perhitungan Kepatuhan SLA</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
            <div class="bg-slate-50 dark:bg-slate-850 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
                <p class="font-bold text-slate-900 dark:text-white mb-1">Target 72 Jam Respon Awal (Bobot 50%)</p>
                <p>
                    Instansi diwajibkan mencatat tanggapan awal, mengonfirmasi bukti, atau menugaskan petugas lapangan maksimal 72 jam sejak warga mengirimkan laporan.
                </p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-850 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
                <p class="font-bold text-slate-900 dark:text-white mb-1">Target 14 Hari Penyelesaian (Bobot 50%)</p>
                <p>
                    Laporan harus dituntaskan dan berstatus Selesai Ditindaklanjuti maksimal 14 hari kalender. Laporan yang belum jatuh tempo tidak mengurangi nilai instansi.
                </p>
            </div>
        </div>
        <div class="pt-1 text-xs">
            <a href="{{ route('data.index') }}" class="font-semibold text-teal-800 dark:text-teal-400 hover:underline">
                Pelajari rincian rumus matematis dan akses data keterbukaan publik &rarr;
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.hwSlaData = [
        @foreach($scorecard as $row)
        {
            name: "{{ addslashes($row['agency_name']) }}",
            responseRate: {{ $row['response_rate'] }},
            resolveRate: {{ $row['resolve_rate'] }}
        },
        @endforeach
    ];
</script>
@vite(['resources/js/charts.js'])
@endpush
@endsection
