@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    {{-- Header --}}
    <div class="space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 dark:bg-teal-950 border border-teal-200 dark:border-teal-800 text-teal-800 dark:text-teal-300 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-teal-600 dark:bg-teal-400"></span>
            <span>Keterbukaan Data &amp; Sains Kebijakan</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white font-display">
            Metodologi &amp; Dataset Publik HakWarga
        </h1>
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed max-w-3xl">
            Seluruh data agregat dan formula perhitungan di platform HakWarga dapat diaudit secara terbuka oleh masyarakat, akademisi, jurnalis data, dan lembaga pengawas pelayanan publik.
        </p>
    </div>

    {{-- Interactive Calculators (Alpine.js) --}}
    <section class="hw-card p-6 sm:p-8 rounded-2xl space-y-6">
        <div>
            <span class="text-xs font-bold text-teal-800 dark:text-teal-400 uppercase tracking-wider block">Simulator Interaktif</span>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white font-display mt-0.5">
                Kalkulator Rumus Kebijakan
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Uji langsung rumus matematis HakWarga dengan memasukkan angka simulasi sendiri.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Calculator 1: Anomali Wilayah --}}
            <div class="rounded-xl border border-slate-200 dark:border-slate-800 p-5 bg-slate-50/50 dark:bg-slate-900/60 space-y-4"
                 x-data="{
                     population: 1800000,
                     povertyPct: 12.84,
                     quota: 30000,
                     medianRatio: 0.13,
                     get poorEstimate() {
                         return Math.round((this.population * this.povertyPct) / 100);
                     },
                     get targetingRatio() {
                         return this.poorEstimate > 0 ? (this.quota / this.poorEstimate).toFixed(3) : 0;
                     },
                     get relativeRatio() {
                         return this.medianRatio > 0 ? (this.targetingRatio / this.medianRatio).toFixed(2) : 0;
                     },
                     get flag() {
                         const r = parseFloat(this.relativeRatio);
                         if (r < 0.5) return { label: 'Potensi Defisit (Under-Coverage)', class: 'bg-amber-100 text-amber-900 dark:bg-amber-950 dark:text-amber-300 border-amber-300' };
                         if (r > 1.5) return { label: 'Potensi Surplus (Over-Coverage)', class: 'bg-indigo-100 text-indigo-900 dark:bg-indigo-950 dark:text-indigo-300 border-indigo-300' };
                         return { label: 'Alokasi Proporsional (Normal)', class: 'bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-300 border-emerald-300' };
                     }
                 }">
                <div class="border-b border-slate-200 dark:border-slate-800 pb-2">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white font-display">1. Kalkulator Rasio Anomali Wilayah</h3>
                    <span class="text-[11px] text-slate-500">Hitung status Red Flag kuota bansos terhadap kemiskinan</span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Populasi Wilayah (Jiwa)</label>
                        <input type="number" x-model.number="population" class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-1.5 font-mono text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Kemiskinan BPS (%)</label>
                        <input type="number" step="0.01" x-model.number="povertyPct" class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-1.5 font-mono text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Kuota Penerima Bansos</label>
                        <input type="number" x-model.number="quota" class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-1.5 font-mono text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Median Rasio Setingkat</label>
                        <input type="number" step="0.01" x-model.number="medianRatio" class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 py-1.5 font-mono text-xs">
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-950 p-3.5 rounded-lg border border-slate-200 dark:border-slate-800 space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Estimasi Penduduk Miskin:</span>
                        <span class="font-mono font-bold text-slate-900 dark:text-white" x-text="Number(poorEstimate).toLocaleString('id-ID') + ' Jiwa'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Rasio Sasaran (Kuota/Miskin):</span>
                        <span class="font-mono font-bold text-slate-900 dark:text-white" x-text="targetingRatio"></span>
                    </div>
                    <div class="flex justify-between border-t border-slate-100 dark:border-slate-800 pt-2">
                        <span class="text-slate-500">Rasio Relatif vs Median:</span>
                        <span class="font-mono font-extrabold text-teal-800 dark:text-teal-400" x-text="relativeRatio + 'x'"></span>
                    </div>
                    <div class="pt-1 flex items-center justify-between">
                        <span class="text-[11px] text-slate-500">Klasifikasi Indikator:</span>
                        <span class="px-2 py-0.5 rounded text-[11px] font-bold border" :class="flag.class" x-text="flag.label"></span>
                    </div>
                </div>
            </div>

            {{-- Calculator 2: Skor SLA Instansi --}}
            <div class="rounded-xl border border-slate-200 dark:border-slate-800 p-5 bg-slate-50/50 dark:bg-slate-900/60 space-y-4"
                 x-data="{
                     responseRate: 100,
                     resolveRate: 80,
                     get score() {
                         return ((0.5 * this.responseRate) + (0.5 * this.resolveRate)).toFixed(1);
                     },
                     get grade() {
                         const s = parseFloat(this.score);
                         if (s >= 85) return { grade: 'A', label: 'Sangat Baik', class: 'bg-emerald-100 text-emerald-900 dark:bg-emerald-950 dark:text-emerald-300 border-emerald-300' };
                         if (s >= 70) return { grade: 'B', label: 'Baik', class: 'bg-blue-100 text-blue-900 dark:bg-blue-950 dark:text-blue-300 border-blue-300' };
                         if (s >= 55) return { grade: 'C', label: 'Cukup', class: 'bg-amber-100 text-amber-900 dark:bg-amber-950 dark:text-amber-300 border-amber-300' };
                         return { grade: 'D', label: 'Perlu Perhatian', class: 'bg-rose-100 text-rose-900 dark:bg-rose-950 dark:text-rose-300 border-rose-300' };
                     }
                 }">
                <div class="border-b border-slate-200 dark:border-slate-800 pb-2">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white font-display">2. Kalkulator Skor Kepatuhan SLA</h3>
                    <span class="text-[11px] text-slate-500">Simulasi skor komposit 50:50 dan penentuan nilai mutu</span>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <div class="flex justify-between mb-1">
                            <label class="font-semibold text-slate-700 dark:text-slate-300">Kepatuhan Respon Awal &le; 72 Jam</label>
                            <span class="font-mono font-bold text-teal-800 dark:text-teal-400" x-text="responseRate + '%'"></span>
                        </div>
                        <input type="range" min="0" max="100" step="1" x-model.number="responseRate" class="w-full accent-teal-700">
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <label class="font-semibold text-slate-700 dark:text-slate-300">Kepatuhan Penyelesaian &le; 14 Hari</label>
                            <span class="font-mono font-bold text-indigo-800 dark:text-indigo-400" x-text="resolveRate + '%'"></span>
                        </div>
                        <input type="range" min="0" max="100" step="1" x-model.number="resolveRate" class="w-full accent-indigo-700">
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-950 p-3.5 rounded-lg border border-slate-200 dark:border-slate-800 space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Bobot Respon (50% &times; Respon):</span>
                        <span class="font-mono font-semibold" x-text="(0.5 * responseRate).toFixed(1) + ' Poin'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Bobot Selesai (50% &times; Selesai):</span>
                        <span class="font-mono font-semibold" x-text="(0.5 * resolveRate).toFixed(1) + ' Poin'"></span>
                    </div>
                    <div class="flex justify-between border-t border-slate-100 dark:border-slate-800 pt-2 items-center">
                        <span class="font-bold text-slate-900 dark:text-white">Skor Akhir Komposit:</span>
                        <span class="font-mono font-extrabold text-base text-teal-800 dark:text-teal-400" x-text="score + ' / 100'"></span>
                    </div>
                    <div class="pt-1 flex items-center justify-between">
                        <span class="text-[11px] text-slate-500">Nilai Mutu Kinerja:</span>
                        <span class="px-2.5 py-0.5 rounded text-[11px] font-bold border" :class="grade.class" x-text="'Nilai ' + grade.grade + ' (' + grade.label + ')'"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Dataset 01: Scorecard SLA --}}
    <section class="hw-card p-6 sm:p-8 rounded-2xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-5">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono font-bold text-teal-800 dark:text-teal-400 uppercase">Dataset 01</span>
                    <span class="text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2 py-0.5 rounded font-mono">CSV / UTF-8 BOM</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white font-display">Rekapitulasi Kepatuhan SLA Instansi</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Data performa penanganan aduan warga per instansi penyalur resmi di wilayah pengawasan.</p>
            </div>
            <div>
                <a href="{{ route('data.export', ['dataset' => 'sla']) }}" class="inline-flex items-center gap-2 rounded-lg bg-teal-700 hover:bg-teal-800 px-4 py-2.5 text-xs font-bold text-white shadow-xs min-h-[44px] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh CSV Scorecard SLA
                </a>
            </div>
        </div>

        {{-- Preview 5 Rows Table --}}
        <div>
            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Pratinjau Data (5 Baris Pertama)</h3>
            <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-semibold">
                            <th class="py-2.5 px-3">Instansi</th>
                            <th class="py-2.5 px-3">Wilayah</th>
                            <th class="py-2.5 px-3">Tipe</th>
                            <th class="py-2.5 px-3 text-center">Total Aduan</th>
                            <th class="py-2.5 px-3 text-center">Respon Tepat</th>
                            <th class="py-2.5 px-3 text-center">Selesai Tepat</th>
                            <th class="py-2.5 px-3 text-center">Skor SLA</th>
                            <th class="py-2.5 px-3 text-center">Mutu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-mono">
                        @foreach($slaPreview as $row)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-2.5 px-3 font-sans font-bold text-slate-900 dark:text-white">{{ $row['agency_name'] }}</td>
                                <td class="py-2.5 px-3 font-sans text-slate-700 dark:text-slate-300">{{ $row['region_name'] }}</td>
                                <td class="py-2.5 px-3 font-sans text-slate-600 dark:text-slate-400">{{ $row['agency_type'] }}</td>
                                <td class="py-2.5 px-3 text-center">{{ $row['total_reports'] }}</td>
                                <td class="py-2.5 px-3 text-center text-emerald-700 dark:text-emerald-400">{{ $row['response_rate'] }}%</td>
                                <td class="py-2.5 px-3 text-center text-emerald-700 dark:text-emerald-400">{{ $row['resolve_rate'] }}%</td>
                                <td class="py-2.5 px-3 text-center font-bold text-teal-800 dark:text-teal-400">{{ $row['final_score'] }}</td>
                                <td class="py-2.5 px-3 text-center font-bold">{{ $row['grade'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Column Dictionary --}}
        <div>
            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Kamus Kolom (Data Dictionary)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 text-xs">
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">agency_name</span>
                    <span class="text-slate-500 text-[11px]">Nama resmi instansi pelaksana</span>
                </div>
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">response_rate</span>
                    <span class="text-slate-500 text-[11px]">% respon dalam batas 72 jam</span>
                </div>
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">resolve_rate</span>
                    <span class="text-slate-500 text-[11px]">% tuntas dalam batas 14 hari</span>
                </div>
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">final_score</span>
                    <span class="text-slate-500 text-[11px]">Skor komposit berbobot 50:50</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Dataset 02: Anomali Wilayah --}}
    <section class="hw-card p-6 sm:p-8 rounded-2xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-5">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono font-bold text-teal-800 dark:text-teal-400 uppercase">Dataset 02</span>
                    <span class="text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2 py-0.5 rounded font-mono">CSV / UTF-8 BOM</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white font-display">Data Anomali &amp; Rasio Kuota Wilayah</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Data kuota bansos resmi dan angka estimasi penduduk miskin BPS per kabupaten/kota.</p>
            </div>
            <div>
                <a href="{{ route('data.export', ['dataset' => 'anomali']) }}" class="inline-flex items-center gap-2 rounded-lg bg-teal-700 hover:bg-teal-800 px-4 py-2.5 text-xs font-bold text-white shadow-xs min-h-[44px] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh CSV Anomali Wilayah
                </a>
            </div>
        </div>

        {{-- Preview 5 Rows Table --}}
        <div>
            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Pratinjau Data (5 Baris Pertama)</h3>
            <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-semibold">
                            <th class="py-2.5 px-3">Kode BPS</th>
                            <th class="py-2.5 px-3">Nama Wilayah</th>
                            <th class="py-2.5 px-3">Program</th>
                            <th class="py-2.5 px-3 text-right">Kuota Bansos</th>
                            <th class="py-2.5 px-3 text-right">Estimasi Miskin</th>
                            <th class="py-2.5 px-3 text-right">Rasio Sasaran</th>
                            <th class="py-2.5 px-3 text-right">Rasio Relatif</th>
                            <th class="py-2.5 px-3">Indikator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-mono">
                        @foreach($anomaliPreview as $row)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-2.5 px-3">{{ $row->bps_code }}</td>
                                <td class="py-2.5 px-3 font-sans font-bold text-slate-900 dark:text-white">{{ $row->region_name }}</td>
                                <td class="py-2.5 px-3 font-sans">{{ $row->program_code }}</td>
                                <td class="py-2.5 px-3 text-right">{{ number_format($row->quota_recipients, 0, ',', '.') }}</td>
                                <td class="py-2.5 px-3 text-right">{{ number_format((int) $row->poor_estimate, 0, ',', '.') }}</td>
                                <td class="py-2.5 px-3 text-right">{{ round((float) $row->targeting_ratio, 3) }}</td>
                                <td class="py-2.5 px-3 text-right font-bold text-teal-800 dark:text-teal-400">{{ round((float) $row->relative_ratio, 2) }}x</td>
                                <td class="py-2.5 px-3 font-sans font-semibold">{{ $row->flag->label() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Column Dictionary --}}
        <div>
            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Kamus Kolom (Data Dictionary)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 text-xs">
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">bps_code</span>
                    <span class="text-slate-500 text-[11px]">Kode wilayah resmi BPS</span>
                </div>
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">targeting_ratio</span>
                    <span class="text-slate-500 text-[11px]">Kuota penerima / estimasi miskin</span>
                </div>
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">relative_ratio</span>
                    <span class="text-slate-500 text-[11px]">Rasio wilayah / median setingkat</span>
                </div>
                <div class="p-2.5 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                    <span class="font-mono font-bold text-teal-800 dark:text-teal-400 block">flag</span>
                    <span class="text-slate-500 text-[11px]">Under-coverage / Over / Normal</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Methodology Explanation --}}
    <section class="hw-card p-6 sm:p-8 rounded-2xl space-y-6">
        <div>
            <span class="text-xs font-bold text-teal-800 dark:text-teal-400 uppercase tracking-wider block">Formula Matematis</span>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white font-display mt-0.5">
                Rumus Analisis Anomali &amp; Evaluasi SLA
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Transparansi penuh algoritma penapisan indikator dan perhitungan skor mutu pelayanan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 space-y-2">
                <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">1. Rumus Analisis Anomali (Red Flag)</h3>
                <div class="bg-white dark:bg-slate-950 p-3 rounded-lg font-mono text-[11px] text-slate-800 dark:text-slate-200 space-y-1 border border-slate-200 dark:border-slate-800">
                    <p>poor_estimate = population &times; poverty_percent / 100</p>
                    <p>targeting_ratio = quota_recipients &divide; poor_estimate</p>
                    <p>relative_ratio = targeting_ratio &divide; median_ratio(level, program, periode)</p>
                    <p class="pt-1.5 text-amber-700 dark:text-amber-400 font-bold">&bull; relative_ratio &lt; 0.5 &rarr; Potensi Defisit (Under-Coverage)</p>
                    <p class="text-indigo-700 dark:text-indigo-400 font-bold">&bull; relative_ratio &gt; 1.5 &rarr; Potensi Surplus (Over-Coverage)</p>
                </div>
            </div>

            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 space-y-2">
                <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">2. Rumus Kepatuhan SLA Instansi</h3>
                <div class="bg-white dark:bg-slate-950 p-3 rounded-lg font-mono text-[11px] text-slate-800 dark:text-slate-200 space-y-1 border border-slate-200 dark:border-slate-800">
                    <p>response_ok = (first_response_at - created_at) &le; 72 jam</p>
                    <p>resolve_ok = (resolved_at - created_at) &le; 14 hari</p>
                    <p class="pt-1.5 text-teal-800 dark:text-teal-400 font-bold">&bull; skor_komposit = (50% &times; %response_ok) + (50% &times; %resolve_ok)</p>
                    <p class="text-slate-600 dark:text-slate-400">&bull; Nilai Mutu: A (&ge; 85), B (&ge; 70), C (&ge; 55), D (&lt; 55)</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
