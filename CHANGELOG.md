# Changelog

Semua perubahan penting pada proyek **HakWarga** akan dicatat di berkas ini.
Format pencatatan mengacu pada [Keep a Changelog](https://keepachangelog.com/id/1.0.0/) dan menganut [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

> **INSTRUKSI UNTUK AI AGENT & KONTRIBUTOR:**
> Setiap kali melakukan perbaikan bug, penambahan fitur, pembaruan skema, atau perubahan kode/UI yang berdampak pada fungsionalitas sistem, **WAJIB memperbarui berkas CHANGELOG.md ini** pada bagian `[Unreleased]` atau versi terkait sebelum commit dinyatakan selesai.

---

## [Unreleased]

### Added
- Modul C: Skema database laporan pungli & sanggah (`reports`, `report_updates`, `report_attachments`) dalam proses eksekusi.
- Master plan percepatan pengembangan penuh seluruh modul hari ini (30 Okt 2026).

---

## [0.1.0] - 2026-10-30

### Added
- Inisialisasi repositori terisolasi mandiri untuk `hakwarga`.
- Konfigurasi toolchain lokal: Docker PostgreSQL 16 (`compose.yaml`), PHP 8.3 dengan ekstensi `pdo_pgsql`, `pgsql`, `openssl`, `mbstring`, `curl`.
- Scaffolding proyek: Laravel 12, Livewire 3, Tailwind CSS v4, Alpine.js, Pest 3, Larastan level 5, Pint.
- Migrasi database Phase 1 (10 tabel): `regions`, `poverty_stats`, `aid_programs`, `aid_allocations`, `agencies`, `beneficiaries`, `shipments`, `shipment_events`, `users`.
- PHP Backed Enums: `ShipmentStatus`, `EligibilityStatus`, `RegionLevel`, `AgencyType`, `UserRole`.
- Domain Services & Helpers:
  - `App\Support\Money`: format standar mata uang Rupiah (`Rp750.000`).
  - `App\Services\NikHasher`: enkripsi satu arah HMAC-SHA256 ber-pepper untuk NIK 16 digit sesuai amanat UU PDP No. 27/2022.
  - `App\Services\ReceiptCodeFactory`: generator & validator format nomor resi resmi `HWR-{PROGRAM}-{YYMM}-{6_CHAR}`.
  - `App\Services\ShipmentTrackingService`: pencarian resi teroptimasi dengan eager loading relasi.
- Seeder demo sintetis (`DemoScenarioSeeder`):
  - Wilayah pilot: Jawa Tengah -> Banyumas -> Patikraja -> Desa Kedungwringin.
  - Instansi: Dinsos Banyumas & PT Pos Indonesia Purwokerto.
  - 3 Resi Emas: `HWR-PKH-2610-DEMO01` (Dalam Pengiriman), `HWR-BPNT-2610-DEMO02` (Penjadwalan Sembako), `HWR-PKH-2610-DEMO03` (Diterima di Titik Salur).
  - Perintah artisan `php artisan hw:demo-reset` untuk reset bersih data demo (diproteksi di production).
- Antarmuka Publik Anti-Slop (Dial `ENERGY 1 / RHYTHM 1 / MOTION 1`):
  - Banner sticky permanen: "DATA SIMULASI: Situs dalam tahap evaluasi MIA 2026."
  - Layout responsif dengan skip-to-content link, target sentuh ≥ 44px, dan focus-visible ring.
  - Landing page (`/`): hero hak bansos, form pencarian resi instan, pintasan 3 resi demo, 3 langkah kawal bansos, dan kartu pratinjau modul.
  - Resi Tracker (`/lacak` & `/lacak/{receipt}`): rate limiter 10 req/menit, kartu rincian hak warga (tunai & komoditas sembako), linimasa vertikal 5 tahap penyaluran, jaminan perlindungan NIK, tombol pelaporan kejanggalan.
  - Halaman edukasi & privasi (`/tentang`) dan placeholder roadmap (`/peta`, `/lapor`, `/scorecard`).
  - Berkas tangkapan layar resolusi tinggi di `docs/img/m1/` (Desktop 1440px & Mobile 390px).
- Pengujian & Jaminan Kualitas:
  - 20 Pest tests (90 assertions) 100% lolos (fungsional, rate limiter, routing, dan zero NIK leakage test).
  - Verifikasi Larastan level 5: 0 error.
  - Verifikasi Pint PSR-12: 0 pelanggaran format.
  - Verifikasi Antislop R-02: 0 em dash (`—`) pada teks antarmuka publik.
