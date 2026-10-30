@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <div class="space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 text-xs font-semibold shadow-xs">
            <span class="w-2 h-2 rounded-full bg-[#c2e050]"></span>
            <span>Misi &amp; Komitmen Etika</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white font-display">
            Tentang Platform HakWarga
        </h1>
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
            Platform transparansi independen pemenuhan hak bantuan sosial warga untuk memastikan bantuan sampai utuh, tepat waktu, dan bebas dari potongan liar.
        </p>
    </div>

    <div class="starline-card p-6 sm:p-10 rounded-2xl space-y-8">
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white font-display mb-2">1. Latar Belakang &amp; Tujuan</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                Bantuan sosial adalah hak konstitusional warga negara yang dialokasikan dari anggaran pendapatan dan belanja negara. Namun di lapangan, warga kerap menghadapi ketidakpastian informasi mengenai jadwal salur, besaran hak tunai/barang yang sah, serta potensi potongan informal. HakWarga hadir memberikan instrumen pelacakan resi terbuka dan pengawasan publik berbasis data.
            </p>
        </div>

        <div class="border-t border-slate-200/50 dark:border-slate-800 pt-6">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white font-display mb-2">2. Komitmen Kepatuhan UU Perlindungan Data Pribadi</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                Sesuai dengan ketentuan Undang-Undang Nomor 27 Tahun 2022 tentang Perlindungan Data Pribadi:
            </p>
            <ul class="list-disc pl-5 mt-2.5 space-y-1.5 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                <li>Sistem tidak pernah mencatat, menyimpan, atau menampilkan Nomor Induk Kependudukan (NIK) mentah warga.</li>
                <li>Pencocokan data penerima menggunakan fungsi hash kriptografi satu arah HMAC-SHA256 dengan pepper rahasia.</li>
                <li>Nama warga dan alamat pada antarmuka publik disamarkan (masked) secara otomatis.</li>
                <li>Pelacakan hanya dapat diakses melalui nomor resi resmi yang tertera pada undangan salur milik penerima.</li>
            </ul>
        </div>

        <div class="border-t border-slate-200/50 dark:border-slate-800 pt-6">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white font-display mb-2">3. Arsitektur Mandiri (Sovereign Infrastructure)</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                HakWarga dibangun di atas arsitektur perangkat lunak independen tanpa ketergantungan pada vendor proprietary tertutup. Seluruh tumpukan aplikasi dirancang berjalan di server mandiri (self-hosted VPS) dengan basis data PostgreSQL 16 dan standar performa tinggi yang hemat kuota internet warga.
            </p>
        </div>
    </div>
</div>
@endsection
