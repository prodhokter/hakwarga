@extends('layouts.app')

@section('content')
<div class="space-y-16 sm:space-y-24 py-8 sm:py-12">
    {{-- Hero Section: Desktop 2-Column with Live Product Preview --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            {{-- Left Column: Problem, Value Proposition & Search --}}
            <div class="lg:col-span-7 space-y-6 text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 dark:bg-teal-950 border border-teal-200 dark:border-teal-800 text-teal-800 dark:text-teal-300 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-teal-600 dark:bg-teal-400"></span>
                    <span>Sistem Transparansi Hak Bansos Mandiri</span>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white font-display leading-[1.15]">
                    Bansos Adalah Hak Warga. Pastikan Sampai Utuh Tanpa Potongan.
                </h1>

                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
                    Ketahui posisi distribusi dan rincian nominal hak bantuan resmi yang wajib Anda terima di lokasi salur. Aman, transparan, dan terlindungi tanpa membuka identitas warga ke publik.
                </p>

                {{-- Interactive Search Form with Real-time Validation --}}
                <div class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4"
                     x-data="{
                         receipt: '',
                         pattern: /^HWR-[A-Z0-9]{3,5}-\d{4}-[A-Z0-9]{6}$/,
                         get isValid() { return this.pattern.test(this.receipt.trim().toUpperCase()); },
                         fillDemo(code) {
                             this.receipt = code;
                             $nextTick(() => { $refs.searchForm.submit(); });
                         }
                     }">
                    <form x-ref="searchForm" action="{{ route('tracker.index') }}" method="GET" class="space-y-3">
                        <label for="search-receipt-code" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                            Masukkan Nomor Resi Penyaluran Resmi
                        </label>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="relative flex-1">
                                <input
                                    type="text"
                                    id="search-receipt-code"
                                    name="code"
                                    x-model="receipt"
                                    @input="receipt = receipt.toUpperCase()"
                                    placeholder="Contoh: HWR-PKH-2610-DEMO01"
                                    required
                                    class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2.5 text-sm sm:text-base text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700 font-mono min-h-[44px]"
                                >
                            </div>
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 px-6 py-2.5 text-sm sm:text-base font-semibold text-white shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px] transition-all shrink-0"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Lacak Hak
                            </button>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            <span>Format: <code>HWR-[PROGRAM]-[YYMM]-[KODE]</code></span>
                            <span x-show="receipt.length > 5" x-cloak :class="isValid ? 'text-emerald-700 dark:text-emerald-400 font-semibold' : 'text-amber-700 dark:text-amber-400'">
                                <span x-text="isValid ? '✓ Format valid' : 'Kombinasi sesuai lembar undangan'"></span>
                            </span>
                        </div>
                    </form>

                    {{-- Demo Fast Chips --}}
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 block mb-2">Pilih data simulasi satu klik:</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($demoReceipts as $demo)
                                <button
                                    type="button"
                                    @click="fillDemo('{{ $demo['code'] }}')"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium rounded-md bg-slate-100 dark:bg-slate-800 hover:bg-teal-50 dark:hover:bg-teal-950/50 hover:border-teal-300 dark:hover:border-teal-700 text-slate-800 dark:text-slate-200 px-2.5 py-1.5 border border-slate-200 dark:border-slate-700 transition-colors cursor-pointer"
                                >
                                    <span class="font-bold text-teal-800 dark:text-teal-400 font-mono">{{ $demo['code'] }}</span>
                                    <span class="text-slate-500 dark:text-slate-400">({{ $demo['program'] }})</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Live Animated Product Preview (5-Stage Lifecycle) --}}
            <div class="lg:col-span-5"
                 x-data="{
                     activeStep: 4,
                     paused: false,
                     steps: [
                         { num: 1, title: 'Pendataan DTKS', agency: 'Dinas Sosial', time: 'Hari ke-1' },
                         { num: 2, title: 'Verifikasi Kelayakan', agency: 'Petugas Lapangan', time: 'Hari ke-3' },
                         { num: 3, title: 'Penjadwalan Salur', agency: 'PT Pos Indonesia', time: 'Hari ke-5' },
                         { num: 4, title: 'Dalam Pengiriman', agency: 'Kurir Resmi', time: 'Hari ke-6' },
                         { num: 5, title: 'Diterima di Titik Salur', agency: 'Balai Desa', time: 'Hari ke-7' },
                     ],
                     timer: null,
                     startTimer() {
                         this.timer = setInterval(() => {
                             if (!this.paused && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                                 this.activeStep = this.activeStep >= 5 ? 1 : this.activeStep + 1;
                             }
                         }, 3200);
                     }
                 }"
                 x-init="startTimer()"
                 @mouseenter="paused = true"
                 @mouseleave="paused = false">
                <div class="hw-card p-6 border-2 border-teal-600/30 rounded-2xl relative overflow-hidden bg-white dark:bg-slate-900">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-slate-800 dark:text-white uppercase font-display">Pratinjau Resi Aktif</span>
                        </div>
                        <span class="text-[11px] font-mono text-teal-800 dark:text-teal-400 bg-teal-50 dark:bg-teal-950 px-2 py-0.5 rounded font-semibold">
                            HWR-PKH-2610-DEMO01
                        </span>
                    </div>

                    {{-- Stepper Display --}}
                    <ol class="space-y-4 relative border-l-2 border-slate-200 dark:border-slate-800 ml-3.5 my-2">
                        <template x-for="step in steps" :key="step.num">
                            <li class="ml-5 relative transition-all duration-300">
                                {{-- Marker --}}
                                <span class="absolute -left-[31px] flex items-center justify-center w-6 h-6 rounded-full font-bold text-[11px] ring-4 ring-white dark:ring-slate-900 transition-colors"
                                      :class="{
                                          'bg-teal-700 text-white': step.num === activeStep,
                                          'bg-emerald-600 text-white': step.num < activeStep,
                                          'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400': step.num > activeStep
                                      }">
                                    <span x-show="step.num < activeStep">&check;</span>
                                    <span x-show="step.num >= activeStep" x-text="step.num"></span>
                                </span>

                                <div class="p-2 rounded-lg transition-colors"
                                     :class="step.num === activeStep ? 'bg-teal-50/70 dark:bg-teal-950/40 border border-teal-200 dark:border-teal-800' : ''">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white font-display" x-text="step.title"></h4>
                                        <span class="text-[10px] text-slate-400 font-mono" x-text="step.time"></span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5" x-text="'Pelaksana: ' + step.agency"></p>
                                </div>
                            </li>
                        </template>
                    </ol>

                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-500">
                        <span>Penerima: <strong class="text-slate-800 dark:text-slate-200 font-mono">S*** W***</strong></span>
                        <span>Hak: <strong class="text-teal-800 dark:text-teal-400 font-mono font-bold">Rp750.000</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Work Proof Statistics Strip --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 text-white rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center divide-y lg:divide-y-0 lg:divide-x divide-slate-800">
                <div class="space-y-1">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Wilayah Terpantau</span>
                    <div class="text-3xl sm:text-4xl font-extrabold font-mono text-teal-400 tabular-nums">5</div>
                    <span class="text-xs text-slate-400 block">Kabupaten Pilot Jawa Tengah</span>
                </div>
                <div class="space-y-1 pt-4 lg:pt-0">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Tahapan Penyaluran</span>
                    <div class="text-3xl sm:text-4xl font-extrabold font-mono text-teal-400 tabular-nums">5</div>
                    <span class="text-xs text-slate-400 block">Tahap Verifikasi Terbuka</span>
                </div>
                <div class="space-y-1 pt-4 lg:pt-0">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Target Respon Awal</span>
                    <div class="text-3xl sm:text-4xl font-extrabold font-mono text-teal-400 tabular-nums">72</div>
                    <span class="text-xs text-slate-400 block">Jam Maksimal Tindak Lanjut</span>
                </div>
                <div class="space-y-1 pt-4 lg:pt-0">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Jaminan Privasi</span>
                    <div class="text-3xl sm:text-4xl font-extrabold font-mono text-emerald-400 tabular-nums">100%</div>
                    <span class="text-xs text-slate-400 block">Anonimitas Tanpa Simpan IP</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Connected 3-Step Civic Journey --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white font-display">
                Tiga Langkah Mengawal Bantuan Sosial
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Alur sederhana bagi setiap warga untuk memastikan bantuan sampai tanpa ada yang memotong.
            </p>
        </div>

        <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Step 1 --}}
            <div class="hw-card p-6 rounded-xl relative flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-950 text-teal-900 dark:text-teal-300 font-bold flex items-center justify-center mb-4 text-base font-display">
                        1
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 font-display">Cari Resi Penyaluran</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Masukkan nomor resi dari lembar undangan bansos Anda untuk mengetahui jadwal penyerahan dan instansi pelaksana.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-semibold text-teal-800 dark:text-teal-400">
                    Pelacakan Transparan &rarr;
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="hw-card p-6 rounded-xl relative flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-950 text-teal-900 dark:text-teal-300 font-bold flex items-center justify-center mb-4 text-base font-display">
                        2
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 font-display">Periksa Rincian Hak Sah</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Lihat rincian hak tunai dan komoditas sembako yang wajib Anda terima di lokasi salur tanpa biaya sepeser pun.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-semibold text-teal-800 dark:text-teal-400">
                    Ketahui Hak Utuh &rarr;
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="hw-card p-6 rounded-xl relative flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-950 text-teal-900 dark:text-teal-300 font-bold flex items-center justify-center mb-4 text-base font-display">
                        3
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 font-display">Laporkan Bila Terjadi Pungli</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Bila dana Anda dipotong oleh oknum di lokasi, kirimkan laporan anonim seketika dan pantau respon dengan kode rahasia.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-semibold text-teal-800 dark:text-teal-400">
                    100% Terlindungi &rarr;
                </div>
            </div>
        </div>
    </section>

    {{-- 4 Core Platform Modules (Clickable Cards with Distinct Mini Visuals) --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="hw-card p-6 sm:p-8 rounded-2xl space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white font-display">
                        Empat Modul Transparansi Terpadu
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Inovasi keterbukaan publik untuk mengawal penyaluran bansos dari tingkat pusat hingga desa.
                    </p>
                </div>
                <span class="text-xs font-semibold text-teal-800 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/60 px-2.5 py-1 rounded border border-teal-200 dark:border-teal-800 w-fit">
                    Platform Aktif Penuh
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Modul A: Resi Tracker --}}
                <a href="{{ route('tracker.index') }}" class="hw-card p-5 rounded-xl border-2 border-teal-600/30 hover:border-teal-700 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-teal-800 dark:text-teal-300 uppercase tracking-wider">Modul A</span>
                            <span class="text-[10px] font-bold bg-teal-700 text-white px-2 py-0.5 rounded">Resi</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white font-display group-hover:text-teal-700 transition-colors">Resi Tracker</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Lacak resi bansos, linimasa 5 tahap penyaluran, dan rincian hak resmi yang wajib diterima warga secara utuh.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs font-bold text-teal-800 dark:text-teal-400 flex items-center justify-between">
                        <span>Buka Pelacakan</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                {{-- Modul B: Peta Anomali --}}
                <a href="{{ route('map.index') }}" class="hw-card p-5 rounded-xl border-2 border-indigo-600/30 hover:border-indigo-700 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-indigo-900 dark:text-indigo-300 uppercase tracking-wider">Modul B</span>
                            <span class="text-[10px] font-bold bg-indigo-700 text-white px-2 py-0.5 rounded">Spasial</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white font-display group-hover:text-indigo-700 transition-colors">Peta Anomali</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Deteksi under-coverage dan over-coverage kuota bansos terhadap data estimasi kemiskinan resmi BPS.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs font-bold text-indigo-900 dark:text-indigo-400 flex items-center justify-between">
                        <span>Buka Peta Wilayah</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                {{-- Modul C: Lapor Pungli & Sanggah --}}
                <a href="{{ route('report.choose') }}" class="hw-card p-5 rounded-xl border-2 border-amber-600/30 hover:border-amber-700 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-amber-900 dark:text-amber-300 uppercase tracking-wider">Modul C</span>
                            <span class="text-[10px] font-bold bg-amber-700 text-white px-2 py-0.5 rounded">Aduan</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white font-display group-hover:text-amber-700 transition-colors">Lapor &amp; Sanggah</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Pengaduan pemotongan dana 100% anonim dan sanggah kelayakan penerima berbasis tiket rahasia.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs font-bold text-amber-900 dark:text-amber-400 flex items-center justify-between">
                        <span>Kirim Laporan</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                {{-- Modul D: Scorecard SLA --}}
                <a href="{{ route('scorecard.index') }}" class="hw-card p-5 rounded-xl border-2 border-emerald-600/30 hover:border-emerald-700 transition-all flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-emerald-900 dark:text-emerald-300 uppercase tracking-wider">Modul D</span>
                            <span class="text-[10px] font-bold bg-emerald-700 text-white px-2 py-0.5 rounded">Kepatuhan</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white font-display group-hover:text-emerald-700 transition-colors">Scorecard SLA</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Peringkat kepatuhan instansi penyalur dalam menindaklanjuti laporan warga (target 72 jam &amp; 14 hari).
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs font-bold text-emerald-900 dark:text-emerald-400 flex items-center justify-between">
                        <span>Lihat Peringkat</span>
                        <span>&rarr;</span>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
