@extends('layouts.app')

@section('content')
<div class="space-y-16 py-8 sm:py-12">
    {{-- Hero Section --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-xs font-semibold">
            <span>Sistem Transparansi Bantuan Sosial Mandiri</span>
        </div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 font-display leading-tight max-w-4xl mx-auto">
            Bansos Adalah Hak Warga. Pastikan Sampai Utuh Tanpa Potongan.
        </h1>

        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Ketahui posisi penyaluran dan rincian hak bantuan sosial resmi yang wajib Anda terima di lokasi salur, dilindungi secara anonim tanpa membuka data pribadi Anda.
        </p>

        {{-- Resi Search Form --}}
        <div class="max-w-2xl mx-auto mt-8 bg-white p-4 sm:p-6 rounded-xl border border-slate-200 shadow-sm text-left">
            <form action="{{ route('tracker.index') }}" method="GET" class="space-y-4">
                <div>
                    <label for="search-receipt" class="block text-sm font-semibold text-slate-900 mb-1.5">
                        Masukkan Nomor Resi Penyaluran Resmi
                    </label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                id="search-receipt"
                                name="code"
                                placeholder="Contoh: HWR-PKH-2610-DEMO01"
                                required
                                class="w-full rounded-md border border-slate-300 px-3.5 py-2.5 text-base text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700 font-mono uppercase min-h-[44px]"
                            >
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-teal-700 px-6 py-2.5 text-base font-semibold text-white hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 focus-visible:ring-offset-2 min-h-[44px]"
                        >
                            Lacak Hak Bansos
                        </button>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">
                        Format nomor resi: <code>HWR-[PROGRAM]-[TAHUN_BULAN]-[KODE_UNIK]</code> (tertera pada surat undangan salur resmi).
                    </p>
                </div>
            </form>

            {{-- Demo Shortcut Buttons --}}
            <div class="pt-4 mt-4 border-t border-slate-100">
                <span class="text-xs font-semibold text-slate-700 block mb-2">Coba Nomor Resi Data Simulasi:</span>
                <div class="flex flex-wrap gap-2">
                    @foreach($demoReceipts as $demo)
                        <a
                            href="{{ route('tracker.show', ['receipt' => $demo['code']]) }}"
                            class="inline-flex items-center gap-1.5 text-xs font-medium rounded-md bg-slate-100 hover:bg-slate-200 text-slate-800 px-2.5 py-1.5 border border-slate-200 focus-visible:ring-2 focus-visible:ring-teal-700 min-h-[38px]"
                        >
                            <span class="font-bold text-teal-800 font-mono">{{ $demo['code'] }}</span>
                            <span class="text-slate-500">({{ $demo['program'] }} - {{ $demo['status'] }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 font-display">
                Tiga Langkah Mengawal Bantuan Sosial
            </h2>
            <p class="text-sm text-slate-600 mt-2">
                HakWarga menjembatani transparansi penyaluran tanpa mengorbankan keamanan data pribadi warga.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg border border-slate-200">
                <div class="w-10 h-10 rounded-md bg-teal-100 text-teal-900 font-bold flex items-center justify-center mb-4 text-base font-display">
                    1
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 font-display">Cari Resi Penyaluran</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Masukkan nomor resi pada undangan bansos resmi Anda. Sistem mencocokkan jadwal penyaluran yang telah diagendakan instansi terkait.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg border border-slate-200">
                <div class="w-10 h-10 rounded-md bg-teal-100 text-teal-900 font-bold flex items-center justify-center mb-4 text-base font-display">
                    2
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 font-display">Periksa Hak &amp; Linimasa</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Ketahui jumlah pasti hak tunai dan komoditas sembako yang wajib Anda terima di lokasi salur, beserta nama instansi pelaksana resmi.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg border border-slate-200">
                <div class="w-10 h-10 rounded-md bg-teal-100 text-teal-900 font-bold flex items-center justify-center mb-4 text-base font-display">
                    3
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 font-display">Laporkan Bila Terjadi Pungli</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Bila dana yang Anda terima dipotong atau tidak sesuai, kirimkan laporan anonim tanpa mencatat identitas dan pantau respon dengan kode rahasia.
                </p>
            </div>
        </div>
    </section>

    {{-- Platform Modules Overview --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8">
            <h2 class="text-xl font-bold text-slate-900 font-display mb-6">
                Modul Transparansi HakWarga (Roadmap Milestone 1 &amp; 2)
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-lg border border-teal-200 bg-teal-50/50 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-teal-800 uppercase tracking-wide">Modul A</span>
                            <span class="text-[11px] font-bold bg-teal-700 text-white px-2 py-0.5 rounded">Aktif di M1</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 font-display">Resi Tracker</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Lacak resi bansos, linimasa 5 tahap penyaluran, dan rincian hak resmi yang wajib diterima warga.
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('tracker.index') }}" class="text-xs font-bold text-teal-800 hover:text-teal-900 underline">Buka Resi Tracker &rarr;</a>
                    </div>
                </div>

                <div class="p-4 rounded-lg border border-slate-200 bg-slate-50 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Modul B</span>
                            <span class="text-[11px] font-medium bg-slate-200 text-slate-700 px-2 py-0.5 rounded">Milestone 2</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 font-display">Peta Anomali</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Deteksi under-coverage dan over-coverage kuota bansos terhadap data estimasi kemiskinan BPS.
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('map.index') }}" class="text-xs font-medium text-slate-600 hover:underline">Lihat Rencana &rarr;</a>
                    </div>
                </div>

                <div class="p-4 rounded-lg border border-slate-200 bg-slate-50 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Modul C</span>
                            <span class="text-[11px] font-medium bg-slate-200 text-slate-700 px-2 py-0.5 rounded">Milestone 2</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 font-display">Lapor Pungli &amp; Sanggah</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Pengaduan pemotongan dana tanpa identitas pelapor dan sanggah kelayakan penerima berbasis tiket.
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('report.choose') }}" class="text-xs font-medium text-slate-600 hover:underline">Lihat Rencana &rarr;</a>
                    </div>
                </div>

                <div class="p-4 rounded-lg border border-slate-200 bg-slate-50 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Modul D</span>
                            <span class="text-[11px] font-medium bg-slate-200 text-slate-700 px-2 py-0.5 rounded">Milestone 2</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 font-display">Scorecard SLA Instansi</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Peringkat kepatuhan instansi penyalur dalam menindaklanjuti laporan warga (target 72 jam &amp; 14 hari).
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('scorecard.index') }}" class="text-xs font-medium text-slate-600 hover:underline">Lihat Rencana &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
