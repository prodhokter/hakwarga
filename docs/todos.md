# Jadwal Harian & Checklist — HakWarga (hakwarga.web.id)

> Sumber pelacakan harian tim (K = Ketua/Backend, F = Frontend, D = Designer/Data/Presenter).
> Status Khusus: Seluruh perencanaan development di tanggal lain **DIMAJUKAN HARI INI (Jumat, 30 Okt 2026)** tanpa terkecuali.

---

## Rencana Eksekusi Penuh Hari Ini (Jumat, 30 Okt 2026)

### Selesai Dieksekusi (Batch 1: Setup & Modul A Resi Tracker)
- [x] Diskusi & kunci nama platform: **HakWarga** (`https://hakwarga.web.id`)
- [x] Standardisasi arsitektur mandiri: Self-Hosted VPS + PostgreSQL 16 (tanpa lock-in PaaS/Vercel)
- [x] Wajibkan standar skill `antislop` untuk seluruh pengerjaan UI/Frontend
- [x] Pembaruan seluruh berkas dokumentasi (`PRD.md`, `STRUCTURE.md`, `DATABASE.md`, `DESIGN.md`, `BACKLOG.md`, dll.)
- [x] B-001: Buat repo terisolasi `hakwarga` (K)
- [x] B-002: Inisialisasi scaffold Laravel + Tailwind v4 + Livewire + Alpine.js (K)
- [x] B-003: Konfigurasi `compose.yaml` PostgreSQL lokal + `.env.example` (K)
- [x] B-101: Siapkan variabel & token warna/tipografi selaras `design.md` (D)
- [x] B-102: Wireframe & UI structure Landing & Resi Tracker (D)
- [x] B-201: Migrasi skema database tahap 1 (`regions`, `aid_programs`, `agencies`, `beneficiaries`, `shipments`, `shipment_events`) (K)
- [x] B-202: Buat `ReceiptCodeFactory` dengan format `HWR-` (K)
- [x] B-203: Seeder demo untuk 3 resi emas (`HWR-PKH-2610-DEMO01`, dll.) (K+D)
- [x] B-204: Implementasi `ShipmentTrackingService` & `TrackerController` (K)
- [x] B-106: Layout aplikasi: navbar, footer, banner SIMULASI, skip-link (F)
- [x] B-107: Slicing Landing Page responsif (hero pencarian resi, strip alur kerja, kartu modul) (F)
- [x] B-205 & B-206: Slicing UI `/lacak`: form pencarian, timeline 5 tahap, kartu rincian hak (F)
- [x] B-903: Ambil screenshot tajam Landing Page & Resi Tracker (1440px desktop & 390px mobile) (F)
- [x] B-901: Finalisasi `README.md` & uji instruksi pemasangan bersih (K)

### Selesai Dieksekusi (Batch 2: Modul C Lapor Pungli, Sanggah & Tiket Rahasia)
- [x] B-401: Migrasi skema database `reports`, `report_updates`, `report_attachments` (K)
- [x] B-402: `TicketCodeFactory` (format `HWT-2026-XXXXXX`) & hash kode rahasia 12 karakter `XXXX-XXXX-XXXX` (K)
- [x] B-403: Layanan sanitasi data `PiiMasker` (auto-mask 16 digit NIK & nomor telepon) (K)
- [x] B-404: FormRequest validasi, proteksi honeypot, dan rate limiting throttle pelaporan (K)
- [x] B-405: UI wizard pelaporan pungli anonim (`/lapor/pungli`) (F)
- [x] B-406: UI form sanggah kelayakan bansos (`/lapor/sanggah`) (F)
- [x] B-407: Halaman sukses tiket: tampilkan kode tiket & kode rahasia satu kali dengan instruksi simpan/cetak (`/lapor/sukses`) (F)
- [x] B-408: Portal tiket warga: pengecekan status publik & akses pelapor dengan kode rahasia (`/tiket` & `/tiket/{ticket}`) (F+K)
- [x] B-409: Fitur tanggapan pelapor ber-sesi rahasia (`/tiket/{ticket}/tambahan`) (K+F)
- [x] B-410: Pengujian Pest untuk privasi: bukti tanpa IP/NIK tersimpan, token benar vs salah, throttle (K)

### Selesai Dieksekusi (Batch 3: Modul B Peta Anomali & Deteksi Red-Flag)
- [x] B-301: Pipeline data GeoJSON statis lokal ke `public/geo/` (D+F)
- [x] B-302 & B-303: Seeder data riil kemiskinan BPS per kabupaten/kota (K+D)
- [x] B-304: Generator alokasi kuota bansos sintetis dan anomali tersuntik (K+D)
- [x] B-305: View PostgreSQL `v_anomaly_scores` & `AnomalyService` penghitung rasio `percentile_cont(0.5)` (K)
- [x] B-306: Endpoint API choropleth `/api/v1/map/choropleth` dengan caching berversi (K)
- [x] B-307 & B-308: Halaman `/peta`: integrasi visual peta wilayah + panel informasi anomali wilayah (F)
- [x] B-309: Komponen aksesibel Tabel Red-Flag wilayah (alternatif peta) (F)
- [x] B-312: Unit & Feature test untuk `AnomalyService` dan endpoint peta (K)

### Selesai Dieksekusi (Batch 4: Modul D Scorecard SLA Instansi & Data Publik)
- [x] B-501: Seeder dataset laporan simulasi dengan variasi waktu tanggap instansi (K+D)
- [x] B-502: `SlaScoreService` penghitung target 72 jam respon awal dan 14 hari selesai (bobot 50:50) (K)
- [x] B-503: UI `/scorecard` peringkat kepatuhan instansi penyalur (F)
- [x] B-504: Halaman detail instansi: tren kecepatan respon dan distribusi status tiket (`/scorecard/{agency:slug}`) (F)
- [x] B-505 & B-506: Halaman `/data`: metodologi perhitungan skor SLA dan unduhan dataset CSV (D+K)

### Selesai Dieksekusi (Batch 5: Panel Admin Filament & API v1)
- [x] B-601: Instalasi & konfigurasi Filament (`/admin`) dengan peran `super_admin`, `moderator`, `agency_officer` (K)
- [x] B-602: Filament Resource Shipment & Event: update status log penyaluran (K)
- [x] B-603: Filament Resource Report: moderasi aduan warga, penugasan instansi, input respon, dan penutupan tiket (K)
- [x] B-604: Kebijakan akses / Hak akses panel admin (K)
- [x] B-006: Endpoint API v1 read-only (`/api/v1/map/choropleth`, `/api/v1/scorecard`) + middleware rate limit (K)

### Dimajukan Hari Ini (Batch 6: Kualitas, Dokumen & Submisi)
- [ ] B-801 & B-802: Pengujian performa Lighthouse awal dan aksesibilitas WCAG AA (F)
- [ ] B-900 & B-902: Penyusunan paket PDF First Draft & Proposal lengkap (D+K)
- [ ] B-913 & B-923: Persiapan materi pitch, ringkasan demo mandiri, dan jaring pengaman offline (ALL)
