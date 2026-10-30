@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 text-xs font-semibold shadow-xs">
            <span class="w-2 h-2 rounded-full bg-[#c2e050]"></span>
            <span>Kanal Pengaduan Independen</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-display">
            Pilih Jenis Laporan Warga
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
            Laporkan pemotongan dana bantuan sosial secara anonim atau ajukan sanggah data kelayakan penerima dengan perlindungan privasi penuh.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
        {{-- Card 1: Lapor Pungli --}}
        <div class="starline-card starline-card-hover p-6 sm:p-7 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#e6ff94] text-slate-950 text-xs font-bold font-mono shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        100% Anonim
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium">Tanpa Identitas Pelapor</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white font-display">
                        Lapor Pungutan Liar &amp; Pemotongan Bansos
                    </h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mt-2">
                        Gunakan jalur ini jika bansos yang Anda terima dipotong oleh oknum, ditarik iuran liar, kartu KKS ditahan, atau dipaksa membeli komoditas di luar aturan.
                    </p>
                </div>
                <div class="bg-white/70 dark:bg-slate-800/60 p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-700/80 text-xs text-slate-600 dark:text-slate-400 space-y-1">
                    <p class="font-bold text-slate-900 dark:text-white">Jaminan Privasi:</p>
                    <p>Sistem tidak mencatat nama, alamat, nomor HP, maupun alamat IP Anda.</p>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-200/50 dark:border-slate-800">
                <a href="{{ route('report.extortion.create') }}" class="btn-starline-primary w-full text-center text-xs font-bold">
                    Mulai Laporan Pungli &rarr;
                </a>
            </div>
        </div>

        {{-- Card 2: Sanggah Penerima --}}
        <div class="starline-card starline-card-hover p-6 sm:p-7 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-900 text-white dark:bg-slate-100 dark:text-slate-900 text-xs font-bold font-mono shadow-2xs">
                        Sanggah Kelayakan
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium">Verifikasi Berkeadilan</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white font-display">
                        Sanggah Penerima Tidak Tepat Sasaran
                    </h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mt-2">
                        Gunakan jalur ini jika ada penerima bantuan di lingkungan Anda yang tergolong mampu, data ganda, telah meninggal, atau warga miskin yang belum terdaftar.
                    </p>
                </div>
                <div class="bg-white/70 dark:bg-slate-800/60 p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-700/80 text-xs text-slate-600 dark:text-slate-400 space-y-1">
                    <p class="font-bold text-slate-900 dark:text-white">Proses Verifikasi:</p>
                    <p>Sanggahan akan ditelaah bersama data kependudukan dan statistik wilayah resmi.</p>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-200/50 dark:border-slate-800">
                <a href="{{ route('report.dispute.create') }}" class="btn-starline-secondary w-full text-center text-xs font-bold">
                    Ajukan Sanggah Penerima &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Already Have Ticket --}}
    <div class="starline-card p-4 rounded-xl text-center text-xs">
        <span class="text-slate-600 dark:text-slate-400">Sudah pernah mengirimkan laporan sebelumnya?</span>
        <a href="{{ route('ticket.index') }}" class="font-bold text-slate-900 dark:text-[#e6ff94] hover:underline ml-1">
            Cek Status Tiket Anda &rarr;
        </a>
    </div>
</div>
@endsection
