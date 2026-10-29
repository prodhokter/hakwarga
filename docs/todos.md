# Jadwal Harian & Checklist — HakWarga (hakwarga.web.id)

> Sumber pelacakan harian tim (K = Ketua/Backend, F = Frontend, D = Designer/Data/Presenter).
> Perbarui checklist setiap pergantian sesi kerja. Terkait: `backlog.md` dan `submission.md`.

---

## 1. M1 — First Draft (Target: Minggu, 1 Nov 2026)

### Jum, 30 Okt 2026 (Kickoff & Setup)
- [x] Diskusi & kunci nama platform: **HakWarga** (`https://hakwarga.web.id`)
- [x] Standardisasi arsitektur mandiri: Self-Hosted VPS + PostgreSQL 16 (tanpa lock-in PaaS/Vercel)
- [x] Wajibkan standar skill `antislop` untuk seluruh pengerjaan UI/Frontend
- [x] Pembaruan seluruh berkas dokumentasi (`PRD.md`, `STRUCTURE.md`, `DATABASE.md`, `DESIGN.md`, `BACKLOG.md`, dll.)
- [ ] B-900: Pelajari detail jam batas submit M1 & template resmi panitia (K)
- [x] B-001: Buat repo terisolasi `hakwarga` (K)
- [x] B-002: Inisialisasi scaffold Laravel + Tailwind v4 + Livewire + Alpine.js (K)
- [x] B-003: Konfigurasi `compose.yaml` PostgreSQL lokal + `.env.example` (K)

### Sab, 31 Okt 2026 (Core Features M1)
- [x] B-101: Siapkan variabel & token warna/tipografi selaras `design.md` (D)
- [x] B-102: Wireframe & UI structure Landing & Resi Tracker (D)
- [x] B-201: Migrasi skema database tahap 1 (`regions`, `aid_programs`, `agencies`, `beneficiaries`, `shipments`, `shipment_events`) (K)
- [x] B-202: Buat `ReceiptCodeFactory` dengan format `HWR-` (K)
- [x] B-203: Seeder demo untuk 3 resi emas (`HWR-PKH-2610-DEMO01`, dll.) (K+D)
- [x] B-204: Implementasi `ShipmentTrackingService` & `TrackerController` (K)
- [x] B-106: Layout aplikasi: navbar, footer, banner SIMULASI, skip-link (F)
- [x] B-107: Slicing Landing Page responsif (hero pencarian resi, strip alur kerja, kartu modul) (F)
- [x] B-205 & B-206: Slicing UI `/lacak`: form pencarian, timeline 5 tahap, kartu rincian hak (F)

### Min, 1 Nov 2026 (Review, Screenshot & Submit M1)
- [x] B-903: Ambil screenshot tajam Landing Page & Resi Tracker (1440px desktop & 390px mobile) (F)
- [ ] B-902: Susun berkas PDF Drafter `WIA_FSDMIA2026_NamaTim.pdf` (≤ 10 hal, ≤ 10 MB) (D)
- [x] B-901: Finalisasi `README.md` & uji instruksi pemasangan bersih (K)
- [ ] B-904: **Submit First Draft** (minimal 3 jam sebelum batas waktu) & simpan bukti submit (K)

---

## 2. M2 — Penyisihan (Target: Rabu, 11 Nov 2026)

### Sen, 2 Nov – Rab, 4 Nov (Infrastruktur VPS & Modul Peta)
- [ ] B-911: Beli materai Rp10.000 untuk Surat Orisinalitas (K)
- [ ] B-007: Setup Self-Hosted VPS Ubuntu, Nginx, Let's Encrypt SSL untuk domain `hakwarga.web.id` (K)
- [ ] B-301: Pipeline GeoJSON batas wilayah via mapshaper ke `public/geo/` (D+F)
- [ ] B-302 & B-303: Impor data riil BPS (% kemiskinan & jumlah penduduk) (K+D)
- [ ] B-305: Implementasi View PostgreSQL `v_anomaly_scores` & `AnomalyService` (K)
- [ ] B-307 & B-308: Halaman `/peta`: MapLibre choropleth offline + panel detail wilayah (F)
- [ ] B-309: Komponen tabel red-flag (alternatif aksesibel untuk peta) (F)

### Kam, 5 Nov – Sab, 7 Nov (Modul Lapor, Tiket & Scorecard)
- [ ] B-401 & B-402: Skema laporan, `TicketCodeFactory` format `HWT-`, hash kode rahasia (K)
- [ ] B-403 & B-404: Sanitasi data `PiiMasker` (auto-mask NIK 16 digit & no telp) + Turnstile/Honeypot (K)
- [ ] B-405: Wizard laporan pungli anonim (Livewire) (F)
- [ ] B-406: Form sanggah penerima tidak layak + `BeneficiaryPicker` (F)
- [ ] B-407 & B-408: Halaman sukses tiket (salin/cetak kode rahasia) & portal `/tiket` (F+K)
- [ ] B-502 & B-503: Modul `/scorecard` peringkat SLA instansi (K+F)
- [ ] B-601 – B-603: Panel Admin Filament 5 (`/admin`) untuk moderasi & tanggapan tiket (K)

### Min, 8 Nov – Sel, 10 Nov (Audit Kualitas, Video & Proposal)
- [ ] B-801 & B-802: Audit Lighthouse (target ≥ 90) dan aksesibilitas axe DevTools WCAG AA (F)
- [ ] B-803: Pengujian lintas perangkat (Android 360px, iPhone 390px, laptop 1440px) (F)
- [ ] B-910: Penulisan Proposal PDF Bab 1–10 (≤ 30 halaman) (K+D)
- [ ] B-911: Penandatanganan & scan Surat Orisinalitas bermaterai (K)
- [ ] B-913: Produksi Video Pitching YouTube (≤ 5 menit, audio jernih, subtitle ID, set Public) (D+F+K)
- [ ] B-912: Buat folder Google Drive publik & uji akses via incognito (K)
- [ ] B-914: **Submit Berkas Penyisihan M2** (Selasa malam, 10 Nov) (K)

---

## 3. M3 — Final Onsite (Target: Sabtu, 28 Nov 2026)

- [ ] B-920: Penyusunan Pitch Deck Slide (≤ 15 slide) (D)
- [ ] B-921: Latihan presentasi 10 menit + timer (target selesai 9:30) (ALL)
- [ ] B-922: Simulasi bank Q&A (15 pertanyaan juri) (ALL)
- [ ] B-923: Siapkan jaring pengaman demo offline: Docker lokal + dump DB + rekaman video 1080p (K+F)
- [ ] B-924: Logistik onsite (laptop demo, charger, HDMI/Type-C dongle, backup hotspot) (ALL)
