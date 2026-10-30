# Catatan Perubahan Redesign & Penguatan UI/UX — HakWarga

**Versi:** 0.3.0  
**Tanggal:** 30 Oktober 2026  
**Fokus:** Total Enhancement Front-End, Interaktivitas Data, Sistem Desain Anti-Slop, dan Keamanan Produksi

---

## 1. Ringkasan Eksekusi Per Fase

### Fase 0 — Audit & Security Reconnaissance
- Pemetaan menyeluruh seluruh rute, endpoint, model data, dan relasi.
- Verifikasi kepatuhan 5 klaim publik (UU PDP No. 27/2022, zero raw NIK, 100% anonimitas lapor, keterbukaan formula dan CSV, otentikasi admin).
- Hasil audit terdokumentasi di `docs/AUDIT.md` dan `docs/AUDIT-SECURITY.md`.

### Fase 1 — Bug Kritis & Fondasi Layout Global
- **MapLibre GL JS Bounding Box:** Penambahan otomatis `fitBounds([[108.65, -7.85], [109.88, -7.12]])` mencakup 5 kabupaten pilot Jawa Tengah (Cilacap, Banyumas, Purbalingga, Banjarnegara, Kebumen).
- **Penanganan Resize & State Peta:** Pemanggilan otomatis `map.resize()` pada event window resize, penambahan skeleton loader, dan kotak fallback jika terjadi kendala jaringan.
- **Segmented Control Filter:** Sinkronisasi multidimensi antara peta, kartu wilayah, tabel rincian, dan grafik donat secara instan.
- **Sistem Kontainer Global:** Standarisasi kontainer `max-w-6xl` (1200px) responsif dan varian formulir terarah `max-w-2xl` / `max-w-3xl`.
- **Navigasi Mobile Responsif:** Drawer menu di bawah 1024px dengan transisi geser mulus, backdrop blur, fokus trap, dan penutupan dengan tombol Escape.
- **Banner SIMULASI Cerdas:** Dapat ditutup per sesi (`sessionStorage`) dengan tetap menampilkan chip indikator permanen di header agar kejujuran etika data tetap terjaga 100%.

### Fase 2 — Design System & Anti-Slop Visual Identity
- **Design Tokens (`resources/css/app.css`):**
  - Palet warna: Deep rich teal (warna merek berwibawa), netral slate, dan aksen hangat amber yang proporsional.
  - Tipografi: Plus Jakarta Sans (heading) + Inter (body) + font mono untuk nomor resi/tiket + angka tabular (`tabular-nums`) untuk data statistik.
  - Permukaan bertingkat (*layered cards*) dan bayangan berlapis.
- **Mode Gelap (Dark Mode):** Dukungan penuh tema gelap (`class="dark"`) dengan sinkronisasi `localStorage` dan preferensi sistem OS.
- **Aturan Bebas Em Dash (R-02):** Seluruh teks antarmuka publik diaudit dan terverifikasi **0 karakter em dash (`—`)**.

### Fase 3 — Revitalisasi Halaman Inti
- **Beranda (`/`):**
  - Hero desktop 2-kolom: kolom kiri memuat nilai utama dan form pencarian resi real-time; kolom kanan memuat **pratinjau produk hidup (*live animated 5-stage timeline*)** yang beranimasi otomatis.
  - Strip statistik bukti kerja berbasis data riil.
  - Alur 3 langkah kawal bansos yang terhubung garis alur visual.
  - 4 kartu modul A–D yang seluruh areanya dapat diklik dengan visual khas.
- **Resi Tracker (`/lacak` & `/lacak/{receipt}`):**
  - Tombol aksi lanjutan: Salin nomor resi, Bagikan tautan pelacakan, Cetak Kartu Hak (`@media print`), dan **Laporkan Masalah Resi Ini** (otomatis membawa nomor resi ke form pengaduan).
  - Tampilan linimasa 5 tahap terperinci dan kartu rincian hak itemized.
- **Peta Anomali (`/peta`):**
  - Interaksi dua arah: klik poligon peta memusatkan dan menyorot kartu/tabel wilayah; klik kartu/tabel memusatkan poligon peta.
  - Diagram donat distribusi anomali Chart.js yang terhubung dengan filter segmented control.
- **Lapor Pungli & Sanggah (`/lapor`, `/tiket`):**
  - Multi-step wizard 3 tahap dengan indikator keamanan 100% anonim.
  - Penyimpanan draf formulir di `sessionStorage` agar ketikan tidak hilang saat refresh.
  - Sensor otomatis NIK 16 digit dan nomor HP via `PiiMasker`.
  - Halaman sukses dengan tombol salin tiket dan kode rahasia satu klik.
- **Scorecard SLA (`/scorecard`):**
  - Grafik benchmark Chart.js dengan **garis target 100% putus-putus**.
  - Papan peringkat dengan filter tipe instansi, pencarian nama, pengurutan kolom, dan baris detail yang dapat di-expand untuk transparansi rumus skor.
- **Keterbukaan Data Publik (`/data`):**
  - Pratinjau 5 baris pertama untuk dataset SLA dan Anomali Wilayah.
  - Kamus kolom lengkap (data dictionary).
  - **Dua Kalkulator Rumus Interaktif (Alpine.js):** Kalkulator Anomali Kuota Bansos dan Kalkulator Skor Kepatuhan SLA.
  - **Keamanan Ekspor CSV:** Sanitasi CSV Formula Injection (karakter `=`, `+`, `-`, `@` otomatis di-escape dengan tanda kutip tunggal `'`).

### Fase 4 & 5 — Kualitas & Verifikasi Akhir
- **Pengujian Otomatis:** 48 Pest tests (305 assertions) 100% hijau.
- **Pint Formatting:** Memenuhi standar PSR-12 tanpa pelanggaran format.
- **Larastan:** Level 5 static analysis bersih tanpa error.
- **Deployment VPS:** Sinkronisasi ke server mandiri `https://kinerja.web.id` dengan Nginx SSL dan Docker Compose.
