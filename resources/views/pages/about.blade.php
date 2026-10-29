@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <div class="space-y-3">
        <h1 class="text-3xl font-extrabold text-slate-900 font-display">
            Tentang Platform HakWarga
        </h1>
        <p class="text-base text-slate-600 leading-relaxed">
            Platform transparansi independen pemenuhan hak bantuan sosial warga untuk memastikan bantuan sampai utuh, tepat waktu, dan bebas dari potongan liar.
        </p>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 space-y-6">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-display mb-2">1. Latar Belakang &amp; Tujuan</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                Bantuan sosial adalah hak konstitusional warga negara yang dialokasikan dari anggaran pendapatan dan belanja negara. Namun di lapangan, warga kerap menghadapi ketidakpastian informasi mengenai jadwal salur, besaran hak tunai/barang yang sah, serta potensi potongan informal. HakWarga hadir memberikan instrumen pelacakan resi terbuka dan pengawasan publik berbasis data.
            </p>
        </div>

        <div class="border-t border-slate-100 pt-6">
            <h2 class="text-xl font-bold text-slate-900 font-display mb-2">2. Komitmen Kepatuhan UU Perlindungan Data Pribadi</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                Sesuai dengan ketentuan Undang-Undang Nomor 27 Tahun 2022 tentang Perlindungan Data Pribadi:
            </p>
            <ul class="list-disc pl-5 mt-2 space-y-1 text-sm text-slate-600">
                <li>Sistem tidak pernah mencatat, menyimpan, atau menampilkan Nomor Induk Kependudukan (NIK) mentah warga.</li>
                <li>Pencocokan data penerima menggunakan fungsi hash kriptografi satu arah HMAC-SHA256 dengan pepper rahasia.</li>
                <li>Nama warga dan alamat pada antarmuka publik disamarkan (masked) secara otomatis.</li>
                <li>Pelacakan hanya dapat diakses melalui nomor resi resmi yang tertera pada undangan salur milik penerima.</li>
            </ul>
        </div>

        <div class="border-t border-slate-100 pt-6">
            <h2 class="text-xl font-bold text-slate-900 font-display mb-2">3. Arsitektur Mandiri (Sovereign Infrastructure)</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                HakWarga dibangun di atas arsitektur perangkat lunak independen tanpa ketergantungan pada vendor proprietary tertutup. Seluruh tumpukan aplikasi dirancang berjalan di server mandiri (self-hosted VPS) dengan basis data PostgreSQL 16 dan standar performa tinggi yang hemat kuota internet warga.
            </p>
        </div>
    </div>
</div>
@endsection
