@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-xs font-semibold">
            <span>Kanal Pengaduan Independen</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Pilih Jenis Laporan Warga
        </h1>
        <p class="text-sm text-slate-600 max-w-xl mx-auto leading-relaxed">
            Laporkan pemotongan dana bantuan sosial secara anonim atau ajukan sanggah data kelayakan penerima dengan perlindungan privasi penuh.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
        {{-- Card 1: Lapor Pungli --}}
        <div class="bg-white rounded-xl border-2 border-slate-200 hover:border-teal-700 p-6 flex flex-col justify-between transition-colors shadow-xs">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-100 text-amber-900 text-xs font-bold font-display">
                        100% Anonim
                    </span>
                    <span class="text-xs text-slate-500">Tanpa Identitas Pelapor</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 font-display">
                        Lapor Pungutan Liar &amp; Pemotongan Bansos
                    </h2>
                    <p class="text-xs text-slate-600 leading-relaxed mt-2">
                        Gunakan jalur ini jika bansos yang Anda terima dipotong oleh oknum, ditarik iuran liar, kartu KKS ditahan, atau dipaksa membeli komoditas di luar aturan.
                    </p>
                </div>
                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 text-xs text-slate-600 space-y-1">
                    <p class="font-semibold text-slate-800">Jaminan Privasi:</p>
                    <p>Sistem tidak mencatat nama, alamat, nomor HP, maupun alamat IP Anda.</p>
                </div>
            </div>
            <div class="pt-6">
                <a href="{{ route('report.extortion.create') }}" class="w-full inline-flex items-center justify-center rounded-md bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px]">
                    Mulai Laporan Pungli &rarr;
                </a>
            </div>
        </div>

        {{-- Card 2: Sanggah Penerima --}}
        <div class="bg-white rounded-xl border-2 border-slate-200 hover:border-teal-700 p-6 flex flex-col justify-between transition-colors shadow-xs">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-100 text-blue-900 text-xs font-bold font-display">
                        Sanggah Kelayakan
                    </span>
                    <span class="text-xs text-slate-500">Verifikasi Berkeadilan</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 font-display">
                        Sanggah Penerima Tidak Tepat Sasaran
                    </h2>
                    <p class="text-xs text-slate-600 leading-relaxed mt-2">
                        Gunakan jalur ini jika ada penerima bantuan di lingkungan Anda yang tergolong mampu, data ganda, telah meninggal, atau warga miskin yang belum terdaftar.
                    </p>
                </div>
                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 text-xs text-slate-600 space-y-1">
                    <p class="font-semibold text-slate-800">Proses Verifikasi:</p>
                    <p>Sanggahan akan ditelaah bersama data kependudukan dan statistik wilayah resmi.</p>
                </div>
            </div>
            <div class="pt-6">
                <a href="{{ route('report.dispute.create') }}" class="w-full inline-flex items-center justify-center rounded-md bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px]">
                    Ajukan Sanggah Penerima &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Already Have Ticket --}}
    <div class="bg-slate-100 p-4 rounded-xl border border-slate-200 text-center text-sm">
        <span class="text-slate-600">Sudah pernah mengirimkan laporan sebelumnya?</span>
        <a href="{{ route('ticket.index') }}" class="font-bold text-teal-800 hover:text-teal-900 underline ml-1">
            Cek Status Tiket Anda &rarr;
        </a>
    </div>
</div>
@endsection
