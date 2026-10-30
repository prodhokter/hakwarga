# Hasil Audit Baseline & Rekomendasi Desain — HakWarga

**Tanggal Audit:** 30 Oktober 2026  
**Target URL Produksi:** `https://kinerja.web.id`  
**Standar Evaluasi:** MIA 2026 Web In Action &bull; Aturan Anti-Slop &bull; UU PDP No. 27/2022

---

## 1. Pemetaan Arsitektur & Tumpukan Teknologi
- **Backend Core:** Laravel 12.70.2, PHP 8.3.36, PostgreSQL 16 Alpine, FrankenPHP Caddy.
- **Frontend Stack:** Blade Views, Livewire 3.8.11, Alpine.js, Tailwind CSS v4, MapLibre GL JS, Chart.js.
- **Deployment:** Self-Hosted VPS Ubuntu 24.04 (`169.58.99.95`), Docker Compose (`compose.prod.yaml`), Host Nginx Reverse Proxy dengan SSL Let's Encrypt aktif.
- **Rute Aplikasi:**
  - Publik: `/`, `/lacak`, `/lacak/{receipt}`, `/peta`, `/lapor`, `/lapor/pungli`, `/lapor/sanggah`, `/lapor/sukses`, `/tiket`, `/tiket/{ticket}`, `/scorecard`, `/scorecard/{slug}`, `/data`, `/data/unduh/{dataset}`, `/tentang`.
  - Admin: `/admin`, `/admin/login`, `/admin/shipments`, `/admin/reports`.
  - API: `/api/v1/map/choropleth`, `/api/v1/scorecard`.

---

## 2. Temuan Kritis & Evaluasi UI/UX

### [KRITIS] 1. Peta Anomali Membutuhkan Bounds Otomatis & Penanganan Resize
- **Lokasi:** `resources/js/map.js`
- **Gejala:** Peta offline MapLibre belum memanggil `fitBounds` otomatis untuk 5 kabupaten pilot (Cilacap, Banyumas, Purbalingga, Banjarnegara, Kebumen) dan belum menyertakan pemanggilan `map.resize()` saat layout berubah atau viewport bergeser.
- **Dampak:** Pada beberapa resolusi layar, poligon kabupaten berada di luar area pandang tengah atau kontainer tampak abu-abu sebelum digeser manual.
- **Solusi:** Tambahkan `fitBounds([[108.65, -7.85], [109.85, -7.12]], { padding: 40 })`, loading skeleton, dan error fallback.

### [TINGGI] 2. Segmented Control & Sinkronisasi Multidimensi
- **Lokasi:** `resources/views/map/index.blade.php`
- **Gejala:** Tombol filter kategori (Semua, Defisit, Surplus, Normal) belum berupa segmented control terpadu dan belum menyinkronkan status reduksi poligon peta, kartu wilayah, tabel rincian, dan donut chart secara serentak.
- **Solusi:** Bangun komponen segmented control dengan badge kuantitas per kategori dan sinkronisasi state instan dua arah.

### [TINGGI] 3. Inkonsistensi Lebar Kontainer Antar Halaman
- **Lokasi:** `resources/views/layouts/app.blade.php` dan views individual
- **Gejala:** Halaman Beranda/Scorecard menggunakan `max-w-7xl` (1280px), sementara Lapor/Tiket `max-w-2xl` atau `max-w-4xl` dengan variasi padding yang belum berstandar global.
- **Solusi:** Tetapkan sistem kontainer 2 tingkat: `max-w-6xl` (1200px) untuk dashboard/peta dan `max-w-3xl` (768px) untuk alur formulir.

### [SEDANG] 4. Hero Beranda & Mini-Timeline Interaktif
- **Lokasi:** `resources/views/home.blade.php`
- **Peluang:** Hero masih berupa satu kolom tengah statis. Dapat ditingkatkan menjadi desktop 2-kolom dengan pratinjau produk hidup (*live animated mini-timeline 5 tahap*), validasi input resi real-time, dan strip statistik bernilai riil.

### [SEDANG] 5. Interaktivitas Kalkulator Data Publik
- **Lokasi:** `resources/views/pages/data.blade.php`
- **Peluang:** Pengguna dan juri dapat langsung membuktikan kebenaran rumus Red Flag dan skor SLA bila disediakan kalkulator interaktif di sisi klien tanpa perlu mengunduh file CSV.

---

## 3. Matriks Rencana Eksekusi Perbaikan
| ID Temuan | Komponen | Prioritas | Estimasi | Target Fase |
|---|---|---|---|---|
| FIX-MAP-01 | FitBounds & 2-way sync MapLibre | Kritis | M | Fase 1 |
| FIX-MAP-02 | Segmented Control & Donut Sync | Tinggi | S | Fase 1 |
| FIX-UI-01 | Container & Header Drawer Responsif | Tinggi | M | Fase 1 |
| FIX-UI-02 | Banner Simulasi Dismissable & Header Chip | Sedang | S | Fase 1 |
| FIX-DS-01 | Design Tokens, Dark Mode, & Accent Palette | Tinggi | M | Fase 2 |
| FEAT-HERO-01 | Hero 2-Kolom & Live Animated Timeline | Tinggi | M | Fase 3 |
| FEAT-TRK-01 | Actions Cetak, Salin, Share & Prefill Lapor | Sedang | S | Fase 3 |
| FEAT-RPT-01 | Multi-step Stepper Lapor & Autosave Draft | Tinggi | M | Fase 3 |
| FEAT-SLA-01 | Garis Target 100% & Filter Tabel Scorecard | Sedang | S | Fase 3 |
| FEAT-DAT-01 | Kalkulator Rumus Anomali & SLA Interaktif | Tinggi | M | Fase 3 |
| SEC-CSV-01 | Sanitasi CSV Formula Injection | Tinggi | S | Fase 3 |
