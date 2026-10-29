@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <div class="space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-xs font-semibold">
            <span>Keterbukaan Data Publik</span>
        </div>
        <h1 class="text-3xl font-extrabold text-slate-900 font-display">
            Metodologi &amp; Dataset Publik HakWarga
        </h1>
        <p class="text-base text-slate-600 leading-relaxed">
            Seluruh data agregat dan rumus analisis di platform HakWarga terbuka untuk diaudit oleh masyarakat, peneliti, dan pengawas kebijakan publik.
        </p>
    </div>

    {{-- Download Dataset Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-4">
            <div class="space-y-2">
                <span class="text-xs font-mono font-bold text-teal-800 uppercase">Dataset 01 &bull; CSV</span>
                <h2 class="text-lg font-bold text-slate-900 font-display">Scorecard SLA Instansi</h2>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Data rekapitulasi kepatuhan batas waktu respon awal 72 jam dan penyelesaian 14 hari seluruh instansi penyalur bansos.
                </p>
            </div>
            <div>
                <a href="{{ route('data.export', ['dataset' => 'sla']) }}" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-teal-700 px-4 py-2.5 text-xs font-semibold text-white hover:bg-teal-800 min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh CSV Scorecard SLA
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-4">
            <div class="space-y-2">
                <span class="text-xs font-mono font-bold text-teal-800 uppercase">Dataset 02 &bull; CSV</span>
                <h2 class="text-lg font-bold text-slate-900 font-display">Anomali &amp; Rasio Kuota Wilayah</h2>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Data perbandingan kuota bansos terhadap angka penduduk miskin resmi BPS beserta rasio relatif dan indikator telaah wilayah.
                </p>
            </div>
            <div>
                <a href="{{ route('data.export', ['dataset' => 'anomali']) }}" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-teal-700 px-4 py-2.5 text-xs font-semibold text-white hover:bg-teal-800 min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh CSV Anomali Wilayah
                </a>
            </div>
        </div>
    </div>

    {{-- Methodology Explanation --}}
    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-6">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-display mb-2">1. Rumus Analisis Anomali (Red Flag)</h2>
            <div class="bg-slate-50 p-4 rounded-lg font-mono text-xs text-slate-800 space-y-1.5 border border-slate-200">
                <p>poor_estimate = population &times; poverty_percent / 100</p>
                <p>targeting_ratio = quota_recipients &divide; poor_estimate</p>
                <p>relative_ratio = targeting_ratio &divide; median_ratio(level, program, periode)</p>
                <p class="pt-2 text-slate-600">relative_ratio &lt; 0.5 &rarr; Potensi Defisit (Under-Coverage)</p>
                <p class="text-slate-600">relative_ratio &gt; 1.5 &rarr; Potensi Surplus (Over-Coverage)</p>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-6">
            <h2 class="text-xl font-bold text-slate-900 font-display mb-2">2. Rumus Kepatuhan SLA Instansi</h2>
            <div class="bg-slate-50 p-4 rounded-lg font-mono text-xs text-slate-800 space-y-1.5 border border-slate-200">
                <p>response_ok = (first_response_at - created_at) &le; 72 jam</p>
                <p>resolve_ok = (resolved_at - created_at) &le; 14 hari</p>
                <p class="pt-1 font-bold text-teal-900">skor_komposit = (50% &times; %response_ok) + (50% &times; %resolve_ok)</p>
            </div>
            <p class="text-xs text-slate-600 mt-2">
                Nilai Mutu: A (&ge; 85), B (&ge; 70), C (&ge; 55), D (&lt; 55).
            </p>
        </div>
    </div>
</div>
@endsection
