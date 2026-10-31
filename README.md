# Kinerja

[![Kinerja CI](https://github.com/prodhokter/kinerja/actions/workflows/ci.yml/badge.svg)](https://github.com/prodhokter/kinerja/actions/workflows/ci.yml)
![PHP 8.3](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)
![PostgreSQL 16](https://img.shields.io/badge/PostgreSQL-16-4169E1?logo=postgresql&logoColor=white)
![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?logo=tailwindcss&logoColor=white)
![FrankenPHP](https://img.shields.io/badge/Server-FrankenPHP_Caddy-00ADD8?logo=caddy&logoColor=white)
![Compliance](https://img.shields.io/badge/Privacy-UU_PDP_No._27%2F2022-0f766e)

> **Platform Transparansi Penyaluran Bantuan Sosial & Pemenuhan Hak Publik**  
> Karya peserta **Multimedia In Action (MIA) 2026 — Cabang Web In Action (WIA)**  
> **Tema:** *Designing Digital Futures – Powering Public Transparency*  
> **Subtema:** *Public Service Tracking* &amp; *Data-Driven Decision Support*

🌐 **Demo Live Produksi:** [https://kinerja.web.id](https://kinerja.web.id) (Self-Hosted VPS Ubuntu + Docker + SSL)  
📄 **Dokumentasi Lengkap:** Folder [`docs/`](docs/) &bull; Catatan Perubahan: [`CHANGELOG.md`](CHANGELOG.md)

---

## 1. Ikhtisar & Nilai Kebaruan

Bantuan sosial adalah hak konstitusional warga negara. Namun di lapangan, warga kerap menghadapi tiga masalah mendasar:
1. **Ketidakpastian Posisi & Hak:** Warga tidak tahu pasti kapan bantuan tiba dan berapa nominal tunai atau kuantitas sembako resmi yang wajib diterima tanpa potongan.
2. **Ketiadaan Kanal Pengaduan yang Benar-Benar Aman:** Warga takut melapor pemotongan liar (pungli) karena khawatir dicoret dari daftar penerima periode berikutnya.
3. **Ketimpangan Kuota Wilayah:** Ketiadaan alat pengawasan data terbuka untuk mendeteksi wilayah yang mengalami kekurangan kuota (*under-coverage*) atau kelebihan kuota (*over-coverage*).

**Kinerja** menyelesaikan ketiga masalah tersebut melalui 4 modul terpadu:
- **Modul A (Resi Tracker):** Pelacakan resi penyaluran berbasis linimasa 5 tahap dan rincian hak itemized resmi (tunai &amp; sembako), dilengkapi fitur cetak bukti hak warga.
- **Modul B (Peta Anomali):** Analisis spasial perbandingan kuota bansos terhadap data estimasi kemiskinan BPS menggunakan fungsi jendela SQL `percentile_cont(0.5)`, dilengkapi visualisasi MapLibre GL JS dan tabel aksesibel.
- **Modul C (Lapor Pungli &amp; Tiket Rahasia):** Kanal pelaporan 100% anonim (tanpa identitas pelapor dan tanpa pencatatan IP) dengan sensor otomatis NIK &amp; nomor telepon via `PiiMasker`, diamankan dengan kode tiket unik dan kode rahasia 12 karakter berpembanding `hash_equals`.
- **Modul D (Scorecard SLA Instansi):** Papan peringkat akuntabilitas kepatuhan batas waktu respon awal (target 72 jam) dan penyelesaian tuntas (target 14 hari) instansi penyalur dengan ekspor data publik CSV.

---

## 2. Arsitektur Mandiri (Sovereign Infrastructure)

Kinerja dibangun 100% di atas infrastruktur mandiri tanpa ketergantungan pada vendor PaaS tertutup (*zero vendor lock-in*).

```
[ Warga / Publik / Pengawas ]
              │
              ▼ HTTPS (Port 443 / SSL Let's Encrypt)
     [ Host Nginx Reverse Proxy ]
              │
              ▼ HTTP (127.0.0.1:8085)
 ┌─────────────────────────────────────────────────────────────┐
 │  Container Docker: hakwarga_web (FrankenPHP Caddy + PHP 8.3) │
 │  ─────────────────────────────────────────────────────────  │
 │  • Laravel 12 Core Engine (Routing, FormRequest, Services)  │
 │  • Livewire 3 + Alpine.js Reactive UI                       │
 │  • Tailwind CSS v4 Compiled Bundles (< 150 KB budget)       │
 │  • MapLibre GL JS (Offline Local GeoJSON, zero API keys)    │
 │  • Chart.js (Benchmark SLA & Distribution Doughnut)         │
 │  • Filament Admin Panel (/admin)                            │
 └──────────────────────────────┬──────────────────────────────┘
                                │ Internal Docker Network
                                ▼ (Port 5432)
 ┌─────────────────────────────────────────────────────────────┐
 │  Container Docker: hakwarga_db (PostgreSQL 16 Alpine)        │
 │  ─────────────────────────────────────────────────────────  │
 │  • 12 Tabel Relasional Terindeks                            │
 │  • View Analitik Matematis: v_anomaly_scores                │
 │  • Proteksi Kriptografis: HMAC-SHA256(NIK, Pepper)          │
 └─────────────────────────────────────────────────────────────┘
```

---

## 3. Matriks Fitur & Status Implementasi

Seluruh modul telah selesai dibangun, teruji penuh, dan aktif di server produksi:

| Modul | Endpoint | Status | Fitur Utama |
|---|---|---|---|
| **Beranda** | `/` | ✅ Aktif | Hero pencarian resi instan, pintasan coba 3 resi demo, pratinjau alur 4 modul. |
| **Resi Tracker** | `/lacak`, `/lacak/{receipt}` | ✅ Aktif | Linimasa vertikal 5 tahap, kartu rincian hak, tombol cetak bukti hak, rate limit 10/mnt. |
| **Peta Anomali** | `/peta`, `/api/v1/map/choropleth` | ✅ Aktif | MapLibre GL offline GeoJSON, filter interaktif (Defisit/Surplus/Normal), tabel red-flag. |
| **Lapor Pungli** | `/lapor/pungli` | ✅ Aktif | 100% anonim, proteksi honeypot, sensor otomatis PII (NIK &amp; no HP), kode rahasia. |
| **Sanggah Bansos** | `/lapor/sanggah` | ✅ Aktif | Form sanggah kelayakan penerima terintegrasi wilayah kelurahan dan program bansos. |
| **Portal Tiket** | `/tiket`, `/tiket/{ticket}` | ✅ Aktif | Status publik tanpa membuka isi aduan; sesi terotentikasi kode rahasia untuk interaksi. |
| **Scorecard SLA** | `/scorecard`, `/scorecard/{slug}` | ✅ Aktif | Leaderboard kepatuhan 72j/14h, grafik benchmark Chart.js, nilai mutu A/B/C/D. |
| **Data Publik** | `/data`, `/data/unduh/{dataset}` | ✅ Aktif | Metodologi transparan, streaming ekspor CSV dataset SLA &amp; Anomali wilayah. |
| **Panel Admin** | `/admin` | ✅ Aktif | Panel Filament dengan autentikasi multi-peran, resource Resi, dan moderasi Aduan. |
| **API Publik v1** | `/api/v1/*` | ✅ Aktif | Endpoint JSON read-only ter-cache untuk choropleth peta dan scorecard instansi. |

---

## 4. Panduan Evaluasi & Data Demo (3 Menit)

Gunakan skenario data sintetis berikut untuk menguji seluruh sistem:

### A. Lacak Nomor Resi Emas
Buka [https://kinerja.web.id/lacak](https://kinerja.web.id/lacak) dan masukkan:
- `HWR-PKH-2610-DEMO01`: Status Tahap 4 (Dalam Pengiriman), Hak Tunai Rp750.000, Penerima `S*** W***`. Coba klik **Cetak Kartu Hak**.
- `HWR-BPNT-2610-DEMO02`: Status Tahap 3 (Penjadwalan), Hak Barang Beras 10kg &amp; Telur 1kg senilai Rp200.000.
- `HWR-PKH-2610-DEMO03`: Status Tahap 5 (Diterima di Titik Salur), Hak Tunai Rp600.000 di Balai Desa Kedungwringin.

### B. Uji Peta Anomali Spasial
Buka [https://kinerja.web.id/peta](https://kinerja.web.id/peta):
- Hover pada peta untuk melihat popup rasio kuota terhadap estimasi miskin BPS.
- Klik tombol filter: **Defisit Kuota** (Kab. Cilacap, rasio 0.43x) atau **Surplus Kuota** (Kab. Purbalingga, rasio 2.22x).
- Periksa **Tabel Rincian Anomali Wilayah** di bawah peta sebagai alternatif aksesibel bagi pembaca layar.

### C. Uji Lapor Pungli &amp; Tiket Rahasia
1. Buka [https://kinerja.web.id/lapor/pungli](https://kinerja.web.id/lapor/pungli).
2. Tuliskan deskripsi yang memuat 16 digit angka (mis. `3302112001990001`) atau nomor HP.
3. Kirim laporan &rarr; perhatikan bahwa nomor NIK otomatis disensor menjadi `[NIK DISAMARKAN]`.
4. Salin nomor tiket dan kode rahasia 12 karakter yang muncul di halaman sukses.
5. Untuk memeriksa tiket demo yang sudah memiliki riwayat tindak lanjut staf:
   - Buka [https://kinerja.web.id/tiket](https://kinerja.web.id/tiket)
   - Nomor Tiket: `HWT-2026-BMS001`
   - Kode Rahasia: `BMS01-TEST-CODE`
   - Kirim tanggapan balasan pada form di bagian bawah.

### D. Uji Panel Admin Filament
Buka [https://kinerja.web.id/admin](https://kinerja.web.id/admin):
- **Email:** `admin@hakwarga.test`
- **Password:** `hakwarga2026`
- Kelola data penyaluran pada menu **Shipments** dan tinjau aduan warga pada menu **Reports**.

---

## 5. Kepatuhan Privasi & Etika (UU PDP No. 27/2022)

1. **Zero Raw NIK:** NIK mentah warga dilarang keras disimpan, dicatat ke log, atau ditampilkan. Pencocokan internal menggunakan `HMAC-SHA256(NIK, HW_NIK_PEPPER)`.
2. **Tanpa Pencarian NIK Publik:** Pelacakan hanya dapat diakses melalui nomor resi resmi pada lembar undangan salur milik penerima guna mencegah profiling sepihak.
3. **Data Masking Bawaan:** Nama penerima ditampilkan dalam format tersamar (`S*** W***`) dan atribut `$hidden = ['nik_hash']` aktif pada model Eloquent.
4. **PiiMasker Sanitizer:** Deskripsi aduan warga otomatis dipindai regex untuk menyensor deretan 16 digit NIK dan nomor kontak sebelum disimpan ke basis data.
5. **Tiket Berotentikasi Kriptografis:** Isi aduan dirahasiakan dari publik. Pembacaan detail laporan memerlukan kode rahasia 12 karakter yang diverifikasi menggunakan `hash_equals(sha256)`.
6. **Data Demo Sintetis:** Seluruh data penerima perorangan memiliki bendera `is_simulated = true` dengan banner pemberitahuan permanen di seluruh halaman.

---

## 6. Standar Kualitas & Anti-Slop UI

Mengacu pada instruksi juri lomba dan panduan skill `antislop`:
- **Bebas AI Clichés:** Tanpa sparkle palsu (`✨`), tanpa gradien ungu/pink generik, tanpa efek kaca berlebih, dan tanpa copywriting robotik AI.
- **Aturan Bebas Em Dash (R-02):** Seluruh teks antarmuka menggunakan Bahasa Indonesia yang lugas dan terverifikasi **0 em dash (`—`)**.
- **Dial Desain:** `ENERGY 2 / RHYTHM 2 / MOTION 2` (berwibawa, terstruktur, kontras tajam &ge; 4.5:1, target sentuh &ge; 44px).
- **Hasil Audit Kualitas:**
  - `./vendor/bin/pint --test`: **PASS** (PSR-12).
  - `./vendor/bin/phpstan analyse`: **PASS** (Larastan Level 5).
  - `php artisan test`: **PASS** (47 tests passed, 303 assertions, 100% hijau).

---

## 7. Cara Menjalankan di Lingkungan Lokal

### Prasyarat
- PHP 8.3+ (dengan ekstensi `pdo_pgsql`, `pgsql`, `mbstring`, `intl`, `curl`)
- Composer 2+
- Node.js 22+ &amp; npm
- Docker Desktop (untuk PostgreSQL 16)

### Langkah Pemasangan
```bash
# 1. Clone repositori
git clone https://github.com/prodhokter/kinerja.git
cd kinerja

# 2. Pasang dependensi backend & frontend
composer install
npm install

# 3. Siapkan konfigurasi lingkungan
cp .env.example .env
php artisan key:generate

# 4. Jalankan PostgreSQL 16 via Docker
docker compose up -d db

# 5. Jalankan migrasi dan seeder demo
php artisan migrate --seed

# 6. Kompilasi aset visual
npm run build

# 7. Jalankan server lokal
php artisan serve
```
Akses aplikasi melalui peramban di `http://localhost:8000`.

### Perintah Pengujian Mandiri
```bash
php artisan test             # Menjalankan 47 unit & feature tests
./vendor/bin/pint --test     # Memeriksa standar format kode
./vendor/bin/phpstan analyse # Analisis statis tipe level 5
php artisan hw:demo-reset    # Reset bersih data demo simulasi
```

---

## 8. Struktur Direktori Repositori

```
hakwarga/
├── .github/
│   ├── workflows/ci.yml       # GitHub Actions CI (Pint, Larastan, Pest, NPM Build)
│   ├── ISSUE_TEMPLATE/        # Template laporan bug & usulan fitur
│   └── PULL_REQUEST_TEMPLATE  # Standar review & definition of done
├── app/
│   ├── Console/Commands/      # Perintah Artisan (hw:demo-reset)
│   ├── Enums/                 # PHP Backed String Enums (ShipmentStatus, AnomalyFlag, dll.)
│   ├── Filament/Resources/    # Admin Resources (ShipmentResource, ReportResource)
│   ├── Http/Controllers/      # Thin Controllers (Home, Tracker, Map, Report, Ticket, Scorecard)
│   ├── Http/Requests/         # FormRequest Validasi & Honeypot
│   ├── Models/                # Eloquent Models (12 tabel terindeks)
│   ├── Providers/             # Service Providers & Filament Admin Provider
│   ├── Services/              # Core Domain Services (AnomalyService, SlaScoreService, dll.)
│   └── Support/               # Helpers (Money formatter)
├── config/
│   └── hakwarga.php           # Ambang batas SLA, rasio anomali, regex kode
├── database/
│   ├── migrations/            # 14 berkas migrasi database PostgreSQL
│   └── seeders/               # DemoScenarioSeeder & DatabaseSeeder
├── docs/
│   ├── img/m1/                # Tangkapan layar resolusi tinggi (Desktop & Mobile)
│   ├── ATTRIBUTION.md         # Lisensi pustaka & sumber data terbuka
│   ├── context.md             # Catatan status modul & log keputusan arsitektur
│   ├── database.md            # Kamus data, indeks, dan view SQL analitik
│   ├── design.md              # Token desain, tipografi, dan aturan aksesibilitas
│   ├── prd.md                 # Kebutuhan produk, rumus SLA & anomali
│   ├── structure.md           # Konvensi arsitektur kode & named routes
│   └── todos.md               # Pelacakan checklist harian tim
├── public/
│   └── geo/central_java.geojson # Batas wilayah geospasial offline
├── resources/
│   ├── css/app.css            # Tailwind CSS v4 design tokens
│   ├── js/                    # app.js, map.js (MapLibre), charts.js (Chart.js)
│   └── views/                 # Blade Views (home, tracker, map, reports, tickets, scorecard, errors)
├── routes/
│   ├── web.php                # Named web routes
│   └── api.php                # Read-only public API v1
├── compose.yaml               # Docker compose untuk PostgreSQL lokal
├── compose.prod.yaml          # Docker compose untuk deployment produksi VPS
├── Dockerfile                 # Multi-stage production container build (Node + Composer + FrankenPHP)
├── CHANGELOG.md               # Catatan rilis v0.1.0 dan v0.2.0
└── README.md                  # Dokumentasi utama proyek
```

---

## 9. Lisensi & Hak Cipta

Proyek ini didistribusikan di bawah lisensi **MIT License**. Rincian sumber data terbuka dan lisensi dependensi tercantum dalam [`docs/ATTRIBUTION.md`](docs/ATTRIBUTION.md).
