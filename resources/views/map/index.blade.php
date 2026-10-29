@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    {{-- Header --}}
    <div class="space-y-2">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-xs font-semibold">
            <span>Modul B: Deteksi Anomali Penyaluran</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Peta Anomali &amp; Rasio Alokasi Bantuan Sosial
        </h1>
        <p class="text-sm text-slate-600 max-w-3xl leading-relaxed">
            Membandingkan kuota penerima bansos resmi terhadap angka estimasi kemiskinan BPS per wilayah. Indikator bendera merah (Red Flag) menapis wilayah yang berpotensi kekurangan kuota (under-coverage) atau kelebihan kuota (over-coverage) untuk ditelaah lebih lanjut.
        </p>
    </div>

    {{-- Metric Strip --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
            <span class="text-xs text-slate-500 font-medium">Wilayah Terpantau</span>
            <div class="text-2xl font-bold font-mono text-slate-900 mt-1">{{ $anomalies->count() }}</div>
            <span class="text-[11px] text-slate-500">Kabupaten/Kota Pilot</span>
        </div>

        <div class="bg-white p-4 rounded-xl border border-amber-300 bg-amber-50/20 shadow-xs">
            <span class="text-xs text-amber-900 font-semibold">Potensi Defisit (Under-Coverage)</span>
            <div class="text-2xl font-bold font-mono text-amber-900 mt-1">{{ $underCount }}</div>
            <span class="text-[11px] text-amber-800">Rasio alokasi &lt; 0.5 median</span>
        </div>

        <div class="bg-white p-4 rounded-xl border border-indigo-300 bg-indigo-50/20 shadow-xs">
            <span class="text-xs text-indigo-900 font-semibold">Potensi Kelebihan Kuota (Over-Coverage)</span>
            <div class="text-2xl font-bold font-mono text-indigo-900 mt-1">{{ $overCount }}</div>
            <span class="text-[11px] text-indigo-800">Rasio alokasi &gt; 1.5 median</span>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
            <span class="text-xs text-emerald-800 font-medium">Alokasi Proporsional</span>
            <div class="text-2xl font-bold font-mono text-emerald-800 mt-1">{{ $normalCount }}</div>
            <span class="text-[11px] text-slate-500">Mendekati median alokasi</span>
        </div>
    </div>

    {{-- Visual Map Card with Offline GeoJSON Representation --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-bold text-slate-900 font-display">Visualisasi Wilayah Pilot Jawa Tengah</h2>
                <span class="text-xs text-slate-500">Periode: {{ $period }} (Program PKH &amp; Sembako)</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Defisit Kuota</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-500"></span> Surplus Kuota</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Proporsional</span>
            </div>
        </div>

        {{-- Geo Visual Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-3 pt-2">
            @foreach($anomalies as $anomaly)
                @php
                    $cardBorder = match($anomaly->flag->value) {
                        'under_coverage' => 'border-amber-400 bg-amber-50/30',
                        'over_coverage' => 'border-indigo-400 bg-indigo-50/30',
                        default => 'border-slate-200 bg-white',
                    };
                @endphp
                <div class="p-4 rounded-lg border {{ $cardBorder }} flex flex-col justify-between space-y-3">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-mono text-slate-500">{{ $anomaly->bps_code }}</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ $anomaly->flag->badgeClass() }}">
                                {{ $anomaly->flag->value === 'under_coverage' ? 'Defisit' : ($anomaly->flag->value === 'over_coverage' ? 'Surplus' : 'Normal') }}
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 font-display mt-1">{{ $anomaly->region_name }}</h3>
                    </div>

                    <div class="space-y-1 text-xs border-t border-slate-200/60 pt-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kuota Bansos:</span>
                            <span class="font-mono font-semibold text-slate-900">{{ number_format($anomaly->quota_recipients, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Estimasi Miskin:</span>
                            <span class="font-mono font-semibold text-slate-900">{{ number_format((int) $anomaly->poor_estimate, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Rasio Sasaran:</span>
                            <span class="font-mono font-bold {{ $anomaly->flag->value === 'under_coverage' ? 'text-amber-800' : ($anomaly->flag->value === 'over_coverage' ? 'text-indigo-800' : 'text-slate-800') }}">
                                {{ round((float) $anomaly->targeting_ratio, 3) }}
                            </span>
                        </div>
                        <div class="flex justify-between pt-1 text-[11px] text-slate-500">
                            <span>vs Median ({{ round((float) $anomaly->median_ratio, 3) }}):</span>
                            <span class="font-bold">{{ round((float) $anomaly->relative_ratio, 2) }}x</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Accessible Red-Flag Table (Mandatory Alternative) --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900 font-display">Tabel Rincian Anomali Wilayah (Alternatif Aksesibel)</h2>
            <p class="text-xs text-slate-600 mt-0.5">
                Data komprehensif seluruh indikator per wilayah untuk memudahkan telaah dan pemeriksaan tanpa mengandalkan tampilan warna visual semata.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider bg-slate-50">
                        <th class="py-3 px-3 font-semibold">Kode BPS</th>
                        <th class="py-3 px-3 font-semibold">Nama Wilayah</th>
                        <th class="py-3 px-3 font-semibold">Program</th>
                        <th class="py-3 px-3 font-semibold text-right">Kuota Bansos</th>
                        <th class="py-3 px-3 font-semibold text-right">Estimasi Miskin (BPS)</th>
                        <th class="py-3 px-3 font-semibold text-right">Rasio Kuota/Miskin</th>
                        <th class="py-3 px-3 font-semibold text-right">Rasio Relatif</th>
                        <th class="py-3 px-3 font-semibold">Indikator Telaah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($anomalies as $row)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-3 font-mono text-xs text-slate-600">{{ $row->bps_code }}</td>
                            <td class="py-3 px-3 font-bold text-slate-900">{{ $row->region_name }}</td>
                            <td class="py-3 px-3 font-medium text-slate-700">{{ $row->program_code }}</td>
                            <td class="py-3 px-3 font-mono text-right text-slate-800">{{ number_format($row->quota_recipients, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 font-mono text-right text-slate-800">{{ number_format((int) $row->poor_estimate, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 font-mono text-right font-semibold text-slate-900">{{ round((float) $row->targeting_ratio, 3) }}</td>
                            <td class="py-3 px-3 font-mono text-right font-bold text-slate-900">{{ round((float) $row->relative_ratio, 2) }}x</td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold border {{ $row->flag->badgeClass() }}">
                                    {{ $row->flag->label() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-xs text-slate-600 space-y-1">
            <p class="font-bold text-slate-800">Catatan Metodologi:</p>
            <p>
                Rasio sasaran dihitung dari kuota penerima dibagi estimasi penduduk miskin resmi BPS. Rasio relatif adalah perbandingan rasio wilayah terhadap median wilayah setingkat. Angka di atas merupakan indikator telaah awal dan bukan kesimpulan pelanggaran hukum.
            </p>
        </div>
    </div>
</div>
@endsection
