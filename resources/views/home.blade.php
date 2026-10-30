@extends('layouts.app')

@section('content')
<div class="space-y-12 sm:space-y-16 py-6 sm:py-10">
    {{-- Hero Section: Desktop 2-Column with Starline Aesthetics --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-center">
            {{-- Left Column --}}
            <div class="lg:col-span-7 space-y-5 text-left">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 font-display leading-[1.12]">
                    Bansos Adalah Hak Warga. Pastikan Sampai Utuh Tanpa Potongan.
                </h1>

                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-xl">
                    Transparansi Hak Publik. Pengawasan Mandiri.
                </p>

                {{-- Search Form Box --}}
                <div class="starline-card p-5 sm:p-6 shadow-xs space-y-4"
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
                        <label for="search-receipt-code" class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                            Nomor Resi
                        </label>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="relative flex-1">
                                <input
                                    type="text"
                                    id="search-receipt-code"
                                    name="code"
                                    x-model="receipt"
                                    @input="receipt = receipt.toUpperCase()"
                                    placeholder="HWR-PKH-2610-DEMO01"
                                    required
                                    class="input-starline w-full font-mono uppercase text-sm"
                                >
                            </div>
                            <button
                                type="submit"
                                class="btn-starline-primary shrink-0 text-xs font-bold"
                            >
                                <svg class="w-4 h-4 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Lacak Resi
                            </button>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span>Format: <code>HWR-KODE</code></span>
                            <span x-show="receipt.length > 5" x-cloak :class="isValid ? 'text-emerald-700 font-semibold' : 'text-amber-700'">
                                <span x-text="isValid ? 'Format Valid' : 'Periksa Format'"></span>
                            </span>
                        </div>
                    </form>

                    {{-- Demo Fast Chips --}}
                    <div class="pt-3 border-t border-slate-200/50">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Resi Demo:</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($demoReceipts as $demo)
                                <button
                                    type="button"
                                    @click="fillDemo('{{ $demo['code'] }}')"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium rounded-full bg-white hover:bg-[#e6ff94] text-slate-800 px-3 py-1.5 border border-slate-200 transition-all cursor-pointer shadow-2xs"
                                >
                                    <span class="font-bold font-mono">{{ $demo['code'] }}</span>
                                    <span class="text-slate-500 text-[10px]">({{ $demo['program'] }})</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Mini-Timeline Preview --}}
            <div class="lg:col-span-5"
                 x-data="{
                     activeStep: 4,
                     paused: false,
                     steps: [
                         { num: 1, title: 'Pendataan Warga', time: 'Tahap 1' },
                         { num: 2, title: 'Verifikasi Data', time: 'Tahap 2' },
                         { num: 3, title: 'Jadwal Salur', time: 'Tahap 3' },
                         { num: 4, title: 'Dalam Pengiriman', time: 'Tahap 4' },
                         { num: 5, title: 'Titik Salur', time: 'Tahap 5' },
                     ],
                     timer: null,
                     startTimer() {
                         this.timer = setInterval(() => {
                             if (!this.paused && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                                 this.activeStep = this.activeStep >= 5 ? 1 : this.activeStep + 1;
                             }
                         }, 3000);
                     }
                 }"
                 x-init="startTimer()"
                 @mouseenter="paused = true"
                 @mouseleave="paused = false">
                <div class="starline-card p-5 sm:p-6 rounded-2xl relative overflow-hidden shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">Linimasa Penyaluran</span>
                        <span class="text-[11px] font-mono text-slate-950 bg-[#e6ff94] px-2.5 py-0.5 rounded-full font-bold shadow-2xs">
                            Aktif
                        </span>
                    </div>

                    <ol class="space-y-3 relative border-l-2 border-slate-200 ml-3 my-2">
                        <template x-for="step in steps" :key="step.num">
                            <li class="ml-4 relative transition-all">
                                <span class="absolute -left-[25px] flex items-center justify-center w-5 h-5 rounded-full font-bold text-[10px] ring-4 ring-[#f0f4f8]"
                                      :class="{
                                          'bg-[#e6ff94] text-slate-950 shadow-xs': step.num === activeStep,
                                          'bg-slate-900 text-white': step.num < activeStep,
                                          'bg-slate-200 text-slate-500': step.num > activeStep
                                      }">
                                    <span x-show="step.num < activeStep">&check;</span>
                                    <span x-show="step.num >= activeStep" x-text="step.num"></span>
                                </span>

                                <div class="p-2 rounded-lg"
                                     :class="step.num === activeStep ? 'bg-white shadow-2xs border border-slate-200' : ''">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-bold text-slate-900" x-text="step.title"></h4>
                                        <span class="text-[10px] text-slate-400 font-mono" x-text="step.time"></span>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </ol>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-mono">
                        <span>Penerima: <strong class="text-slate-900">S*** W***</strong></span>
                        <span>Hak: <strong class="text-slate-900 font-bold">Rp750.000</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics Strip: Ultra Concise --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="starline-card bg-[#0f172a] text-white p-6 rounded-2xl shadow-sm">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center divide-y lg:divide-y-0 lg:divide-x divide-slate-800">
                <div class="space-y-1">
                    <div class="text-2xl sm:text-3xl font-extrabold font-mono text-[#e6ff94] tabular-nums">5</div>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Wilayah Pilot</span>
                </div>
                <div class="space-y-1 pt-3 lg:pt-0">
                    <div class="text-2xl sm:text-3xl font-extrabold font-mono text-[#e6ff94] tabular-nums">5</div>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Tahap Verifikasi</span>
                </div>
                <div class="space-y-1 pt-3 lg:pt-0">
                    <div class="text-2xl sm:text-3xl font-extrabold font-mono text-[#e6ff94] tabular-nums">72</div>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Jam SLA</span>
                </div>
                <div class="space-y-1 pt-3 lg:pt-0">
                    <div class="text-2xl sm:text-3xl font-extrabold font-mono text-[#e6ff94] tabular-nums">100%</div>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Anonimitas Lapor</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Connected 3-Step Civic Workflow --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-8 space-y-1">
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-display">
                Alur Pengawasan
            </h2>
            <p class="text-xs text-slate-500">
                Langkah Mandiri
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="starline-card p-5 rounded-2xl flex flex-col justify-between">
                <div>
                    <span class="w-8 h-8 rounded-full bg-slate-900 text-[#e6ff94] font-extrabold flex items-center justify-center mb-3 text-xs font-mono">1</span>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Cari Resi</h3>
                    <p class="text-xs text-slate-500">Periksa Lembar</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-xs font-bold text-slate-900">
                    Pelacakan Cepat &rarr;
                </div>
            </div>

            <div class="starline-card p-5 rounded-2xl flex flex-col justify-between">
                <div>
                    <span class="w-8 h-8 rounded-full bg-slate-900 text-[#e6ff94] font-extrabold flex items-center justify-center mb-3 text-xs font-mono">2</span>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Cek Hak</h3>
                    <p class="text-xs text-slate-500">Ketahui Nominal</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-xs font-bold text-slate-900">
                    Hak Utuh &rarr;
                </div>
            </div>

            <div class="starline-card p-5 rounded-2xl flex flex-col justify-between">
                <div>
                    <span class="w-8 h-8 rounded-full bg-slate-900 text-[#e6ff94] font-extrabold flex items-center justify-center mb-3 text-xs font-mono">3</span>
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Lapor Pungli</h3>
                    <p class="text-xs text-slate-500">Kirim Aduan</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-xs font-bold text-slate-900">
                    Anonimitas Terjamin &rarr;
                </div>
            </div>
        </div>
    </section>

    {{-- 4 Module Cards: Ultra Concise --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="starline-card p-6 rounded-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-900 font-display">
                    Modul Transparansi
                </h2>
                <span class="text-xs font-bold text-slate-950 bg-[#e6ff94] px-2.5 py-0.5 rounded-full">
                    Aktif
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('tracker.index') }}" class="starline-card starline-card-hover p-4 rounded-xl flex flex-col justify-between group">
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Modul A</span>
                        <h3 class="text-sm font-bold text-slate-900">Resi Tracker</h3>
                        <p class="text-xs text-slate-500">Lacak Posisi</p>
                    </div>
                    <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                        <span>Akses</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                <a href="{{ route('map.index') }}" class="starline-card starline-card-hover p-4 rounded-xl flex flex-col justify-between group">
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Modul B</span>
                        <h3 class="text-sm font-bold text-slate-900">Peta Anomali</h3>
                        <p class="text-xs text-slate-500">Deteksi Spasial</p>
                    </div>
                    <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                        <span>Akses</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                <a href="{{ route('report.choose') }}" class="starline-card starline-card-hover p-4 rounded-xl flex flex-col justify-between group">
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Modul C</span>
                        <h3 class="text-sm font-bold text-slate-900">Lapor Pungli</h3>
                        <p class="text-xs text-slate-500">Aduan Anonim</p>
                    </div>
                    <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                        <span>Akses</span>
                        <span>&rarr;</span>
                    </div>
                </a>

                <a href="{{ route('scorecard.index') }}" class="starline-card starline-card-hover p-4 rounded-xl flex flex-col justify-between group">
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase font-mono">Modul D</span>
                        <h3 class="text-sm font-bold text-slate-900">Scorecard SLA</h3>
                        <p class="text-xs text-slate-500">Peringkat Instansi</p>
                    </div>
                    <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-bold text-slate-900 flex justify-between">
                        <span>Akses</span>
                        <span>&rarr;</span>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
