@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-xs font-semibold">
                <span>Modul D: Akuntabilitas Pelayanan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
                Scorecard SLA Instansi Penyalur Bansos
            </h1>
            <p class="text-sm text-slate-600 max-w-2xl leading-relaxed">
                Peringkat kepatuhan instansi penyalur dalam merespon aduan warga (target 72 jam) dan menyelesaikan tindak lanjut (target 14 hari) dengan bobot seimbang 50:50.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('data.export', ['dataset' => 'sla']) }}" class="inline-flex items-center gap-1.5 rounded-md bg-white border border-slate-300 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-xs min-h-[44px]">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh Data CSV
            </a>
        </div>
    </div>

    {{-- Interactive Visual Benchmark Chart --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-3">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-bold text-slate-900 font-display">Perbandingan Kepatuhan Antar Instansi</h2>
                <span class="text-xs text-slate-500">Persentase respon tepat waktu (&le; 72 jam) vs penyelesaian tuntas (&le; 14 hari)</span>
            </div>
            <span class="text-xs font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded border border-teal-200">
                Target Standar: 100%
            </span>
        </div>
        <div class="h-[280px] w-full pt-2">
            <canvas id="sla-benchmark-chart"></canvas>
        </div>
    </div>

    {{-- Scorecard Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Peringkat</th>
                        <th class="py-3.5 px-4 font-semibold">Instansi Penyalur</th>
                        <th class="py-3.5 px-4 font-semibold">Tipe &amp; Wilayah</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Respon &le; 72 Jam</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Selesai &le; 14 Hari</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Skor SLA</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Nilai Mutu</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($scorecard as $index => $row)
                        @php
                            $gradeBadge = match($row['grade']) {
                                'A' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                                'B' => 'bg-blue-100 text-blue-900 border-blue-300',
                                'C' => 'bg-amber-100 text-amber-900 border-amber-300',
                                default => 'bg-rose-100 text-rose-900 border-rose-300',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-4 font-bold text-slate-900 font-display">
                                #{{ $index + 1 }}
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-900">
                                <a href="{{ route('scorecard.show', ['agency' => $row['agency_slug']]) }}" class="hover:text-teal-700 underline">
                                    {{ $row['agency_name'] }}
                                </a>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600">
                                <div>{{ $row['agency_type'] }}</div>
                                <div class="text-slate-400 font-medium">{{ $row['region_name'] }}</div>
                            </td>
                            <td class="py-4 px-4 text-center font-mono">
                                <span class="font-bold {{ $row['response_rate'] >= 80 ? 'text-emerald-800' : 'text-slate-700' }}">
                                    {{ $row['response_rate'] }}%
                                </span>
                                <span class="text-[11px] text-slate-400 block">({{ $row['response_ok_count'] }}/{{ $row['due_response_count'] }})</span>
                            </td>
                            <td class="py-4 px-4 text-center font-mono">
                                <span class="font-bold {{ $row['resolve_rate'] >= 80 ? 'text-emerald-800' : 'text-slate-700' }}">
                                    {{ $row['resolve_rate'] }}%
                                </span>
                                <span class="text-[11px] text-slate-400 block">({{ $row['resolve_ok_count'] }}/{{ $row['due_resolve_count'] }})</span>
                            </td>
                            <td class="py-4 px-4 text-center font-mono font-extrabold text-base text-teal-900">
                                {{ $row['final_score'] }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-sm border {{ $gradeBadge }}">
                                    {{ $row['grade'] }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <a href="{{ route('scorecard.show', ['agency' => $row['agency_slug']]) }}" class="text-xs font-semibold text-teal-800 hover:text-teal-900 underline">
                                    Detail &rarr;
                                </a>
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

    {{-- Methodology callout --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-3">
        <h2 class="text-base font-bold text-slate-900 font-display">Standar Perhitungan Kepatuhan SLA</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600 leading-relaxed">
            <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-200">
                <p class="font-bold text-slate-900 mb-1">Target 72 Jam Respon Awal (Bobot 50%)</p>
                <p>
                    Instansi diwajibkan mencatat tanggapan awal, mengonfirmasi bukti, atau menugaskan petugas lapangan maksimal 72 jam sejak warga mengirimkan laporan.
                </p>
            </div>
            <div class="bg-slate-50 p-3.5 rounded-lg border border-slate-200">
                <p class="font-bold text-slate-900 mb-1">Target 14 Hari Penyelesaian (Bobot 50%)</p>
                <p>
                    Laporan harus dituntaskan dan berstatus Selesai Ditindaklanjuti maksimal 14 hari kalender. Laporan yang belum jatuh tempo tidak mengurangi nilai instansi.
                </p>
            </div>
        </div>
        <div class="pt-1 text-xs">
            <a href="{{ route('data.index') }}" class="font-semibold text-teal-800 hover:underline">
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
