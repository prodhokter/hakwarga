# Backlog — HakWarga (hakwarga.web.id) + Deliverable Lomba WIA

> Daftar kerja berprioritas (apa & mengapa). Jadwal harian (kapan & siapa) ada di `todos.md`.
> Terkait: `prd.md` (ID kebutuhan) · `submission.md` (spesifikasi deliverable) · `context.md`

## Cara Membaca

| Kolom | Arti |
|---|---|
| **Prio** | **M**ust · **S**hould · **C**ould · **W**on't (kali ini) |
| **Ukuran** | S ≤ 2 jam · M ≤ ½ hari · L ≤ 1 hari · XL > 1 hari |
| **Pemilik** | **K** Ketua/Backend · **F** Frontend · **D** Designer/Data/Presenter · **ALL** |
| **MS** | M1 = 1 Nov · M2 = 11 Nov · M3 = 28 Nov · ∞ = rutin |
| **Status** | ⬜ belum · 🟡 jalan · ✅ selesai · ⛔ terblokir |

**Aturan Khusus:** Seluruh perencanaan development di tanggal lain **DIMAJUKAN HARI INI (Jumat, 30 Okt 2026)** tanpa terkecuali. Seluruh modul A, B, C, D, admin, dan API dieksekusi secara penuh.

---

## Cakupan Pengembangan (Semua Dimajukan Hari Ini: 30 Okt 2026)

| Komponen | Status Target |
|---|---|
| **Fondasi & Modul A (Tracker)** | ✅ Selesai dieksekusi hari ini |
| **Modul C (Lapor & Tiket Rahasia)** | 🟡 Sedang dieksekusi hari ini |
| **Modul B (Peta Anomali & Choropleth)** | 🟡 Sedang dieksekusi hari ini |
| **Modul D (Scorecard SLA Instansi)** | 🟡 Sedang dieksekusi hari ini |
| **Panel Admin (Filament 5) & API v1** | 🟡 Sedang dieksekusi hari ini |

---

## E0 — Fondasi & DevOps

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-001 | Buat repo **publik** + undang tim + larang force-push ke `main` | M | S | K | M1 | ⬜ | Terbuka tanpa login; wajib-PR mulai setelah First Draft (`AGENTS.md` §8) |
| B-002 | Scaffold Laravel 13 + Tailwind 4 + Vite + Livewire; push | M | M | K | M1 | ⬜ | `php artisan serve` jalan; semua anggota PHP versi sama |
| B-003 | `compose.yaml` PostgreSQL + `.env.example` lengkap | M | S | K | M1 | ⬜ | Clone baru bisa jalan sesuai README |
| B-004 | CI: Pint + Larastan + Pest + build npm | S | M | K | M1→M2 | ⬜ | Minimal Pint + Pest di M1 |
| B-005 | Locale `id`, timezone `Asia/Jakarta`, `lang/id`, helper `Money` | M | S | K | M1 | ⬜ | Format `Rp1.250.000` |
| B-006 | Security baseline: header, throttle named limiters, `NoStore` | M | M | K | M2 | ⬜ | `prd.md` §9 |
| B-007 | Deploy ke Self-Hosted VPS pribadi + Nginx + Let's Encrypt SSL (D-13) | M | L | K | M2 | ⬜ | Mandiri, tanpa PaaS, bisa dibuka dari HP lain jaringan |
| B-008 | Halaman galat 404/419/429/500 berbahasa Indonesia | S | S | F | M2 | ⬜ | |
| B-009 | Kebijakan log tanpa PII + `/up` | S | S | K | M2 | ⬜ | Tes: body `/lapor/*` tak tercatat |
| B-010 | Perintah `hw:demo-reset` + `DemoScenarioSeeder` | M | M | K | M2 | ⬜ | Menolak jalan di production |

## E1 — Desain & Landing (Wajib Anti-Slop)

> **Catatan Agent/Dev:** Semua pengerjaan frontend di bawah wajib memanggil & mematuhi skill `antislop` (`antislop`, `antislop-ui`, `antislop-copywriting`, `antislop-human`, `antislop-layoutmobile`). Dilarang UI/copywriting AI generik.

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-101 | Figma foundations (token, tipografi, warna, grid) | M | M | D | M1 | ⬜ | Selaras `design.md` §2 |
| B-102 | Wireframe low-fi: Landing, Tracker, Peta | M | L | D | M1 | ⬜ | Masuk PDF hal 6–7 |
| B-103 | Wireframe low-fi: Lapor, Tiket, Scorecard, Data | M | M | D | M1 | ⬜ | Masuk PDF hal 7 |
| B-104 | Hi-fi Landing + Tracker (desktop 1440 + mobile 390) | M | L | D | M1 | ⬜ | Selesai **sebelum** F memoles UI |
| B-105 | Hi-fi Peta, Lapor, Tiket, Scorecard | M | L | D | M2 | ⬜ | |
| B-106 | Layout aplikasi: header/nav/footer/skip link/banner SIMULASI | M | M | F | M1 | ⬜ | GEN-02 |
| B-107 | Landing page (hero + cari resi, strip angka, cara kerja, modul, CTA) | M | L | F | M1 | ⬜ | GEN-01; Lighthouse awal ≥ 90 |
| B-108 | Komponen Blade dasar (button, input, badge, card, alert, stat, timeline, table, stepper) | M | M | F | M1 | ⬜ | `design.md` §4 |
| B-109 | Halaman `/tentang` (misi, privasi, FAQ) | S | M | D+F | M2 | ⬜ | GEN-04 |
| B-110 | Halaman `/data` (metodologi, sumber, unduhan) | M | M | D+K | M2 | ⬜ | GEN-03, SLA-05 |
| B-111 | Favicon, OG image, meta SEO | S | S | F | M2 | ⬜ | |
| B-112 | Mode gelap | W | M | F | – | ⬜ | Icebox |

## E2 — Resi Tracker (Modul A)

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-201 | Migrasi + model: `regions`, `aid_programs`, `agencies`, `beneficiaries`, `shipments`, `shipment_events` | M | M | K | M1 | ⬜ | `database.md` §3 |
| B-202 | `ReceiptCodeFactory` + validasi regex | M | S | K | M1 | ⬜ | Tes unit |
| B-203 | Seeder demo: wilayah minimal, 3 resi DEMO + ±200 shipment acak | M | M | K+D | M1 | ⬜ | Semua `is_simulated` |
| B-204 | `ShipmentTrackingService` + `TrackerController` | M | M | K | M1 | ⬜ | TRK-02/03/04/05 |
| B-205 | UI pencarian resi `/lacak` + validasi | M | M | F | M1 | ⬜ | TRK-01 |
| B-206 | UI hasil: kartu ringkasan, timeline, rincian hak | M | L | F | M1 | ⬜ | **Halaman ke-2 untuk screenshot** |
| B-207 | Throttle tracker + pesan tidak ditemukan generik | M | S | K | M1 | ⬜ | TRK-06 |
| B-208 | Prefill konteks (tanpa identitas) ke `/lapor/pungli` | S | S | K+F | M2 | ⬜ | TRK-07 |
| B-209 | Konfirmasi penerimaan nominal | C | L | K+F | M3 | ⬜ | TRK-08 |
| B-210 | Stylesheet cetak "Kartu Hak" | C | S | F | M3 | ⬜ | TRK-09 |
| B-211 | Feature test tracker (ditemukan, tidak ditemukan, throttle, tanpa NIK) | S | M | K | M2 | ⬜ | |

## E3 — Peta & Anomali (Modul B)

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-301 | Pipeline geo: sumber berlisensi → mapshaper → `public/geo/*` | M | L | D+F | M2 | ⬜ | ≤ 1 MB gzip/level; kode wilayah cocok CSV |
| B-302 | Migrasi: `poverty_stats`, `aid_allocations` | M | S | K | M2 | ⬜ | |
| B-303 | Importer CSV wilayah & kemiskinan (idempoten) | M | M | K+D | M2 | ⬜ | Data BPS riil |
| B-304 | Generator alokasi sintetis + anomali tersuntik | M | M | K+D | M2 | ⬜ | `mt_srand(2026)` |
| B-305 | View `v_anomaly_scores` + `AnomalyService` + config ambang | M | L | K | M2 | ⬜ | `prd.md` §8.1 |
| B-306 | API `/api/v1/map/*`, `/regions/{code}` + cache berversi | M | M | K | M2 | ⬜ | |
| B-307 | Halaman peta: choropleth, legenda, lapisan, drill-down | M | XL | F | M2 | ⬜ | MAP-01/02/03/06 |
| B-308 | Panel detail wilayah + grafik vs median | M | L | F | M2 | ⬜ | MAP-04 |
| B-309 | Tabel red-flag + navigasi keyboard/dropdown wilayah | M | M | F | M2 | ⬜ | MAP-05/08 (aksesibilitas) |
| B-310 | Daftar penerima tersamar per desa (uji publik) | S | M | K+F | M2 | ⬜ | MAP-07 |
| B-311 | Performa peta (lazy init, simplifikasi, cache) | S | M | F | M2 | ⬜ | Anggaran `prd.md` §9 |
| B-312 | Unit test `AnomalyService` dengan fixture | S | M | K | M2 | ⬜ | |

## E4 — Lapor & Tiket (Modul C)

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-401 | Migrasi: `reports`, `report_updates`, `report_attachments` | M | M | K | M2 | ⬜ | |
| B-402 | `TicketCodeFactory` + kode rahasia (hash `sha256`, `hash_equals`) | M | S | K | M2 | ⬜ | |
| B-403 | FormRequest + `PiiMasker` (NIK/telepon) | M | M | K | M2 | ⬜ | RPT-08 |
| B-404 | Integrasi Turnstile + honeypot + throttle | M | S | K | M2 | ⬜ | RPT-07 |
| B-405 | UI wizard pungli (Livewire) | M | L | F | M2 | ⬜ | RPT-01 |
| B-406 | UI form sanggah + `BeneficiaryPicker` | M | L | F | M2 | ⬜ | RPT-02 |
| B-407 | Halaman sukses (tiket + rahasia, salin, cetak, `no-store`) | M | M | F | M2 | ⬜ | RPT-03 |
| B-408 | Halaman `/tiket`: publik + akses pelapor + tambah keterangan | M | L | F+K | M2 | ⬜ | RPT-04/05 |
| B-409 | Upload bukti (MIME, re-encode, disk privat) | S | L | K | M2 | ⬜ | RPT-06 |
| B-410 | Tes privasi: tanpa IP/PII tersimpan, token benar/salah, throttle | M | M | K | M2 | ⬜ | |
| B-411 | Notifikasi email ke pelapor | W | M | – | – | ⬜ | Bertentangan dengan anonimitas |

## E5 — Scorecard SLA (Modul D)

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-501 | Seed laporan simulasi dengan waktu respon bervariasi | M | M | K+D | M2 | ⬜ | ±60 laporan |
| B-502 | `SlaScoreService` + config + tes (belum jatuh tempo ≠ gagal) | M | M | K | M2 | ⬜ | `prd.md` §8.2 |
| B-503 | UI peringkat + filter | M | L | F | M2 | ⬜ | SLA-01/02/03 |
| B-504 | Detail instansi: tren bulanan + distribusi status | S | L | F | M2 | ⬜ | SLA-04 |
| B-505 | Ekspor CSV | S | S | K | M2 | ⬜ | SLA-06 |
| B-506 | Halaman metodologi skor | M | S | D | M2 | ⬜ | SLA-05 |

## E6 — Admin (Filament)

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-601 | Pasang Filament 5 + peran + user demo (dari env) | M | M | K | M2 | ⬜ | ADM-01 |
| B-602 | Resource Shipment + Event (update status) | M | L | K | M2 | ⬜ | ADM-02 |
| B-603 | Resource Report (status, balasan publik/internal; `first_response_at` otomatis) | M | L | K | M2 | ⬜ | ADM-03/04 |
| B-604 | Policy ruang lingkup per instansi | S | M | K | M2 | ⬜ | ADM-05 |
| B-605 | Widget dashboard ringkas | C | M | K | M3 | ⬜ | |
| B-606 | Impor CSV penyaluran | C | L | K | M3 | ⬜ | |

## E7 — Data & Konten

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-701 | Kumpulkan % penduduk miskin per kab/kota (BPS) | M | M | D | M1 | ⬜ | Catat sumber & tanggal akses |
| B-702 | Kumpulkan jumlah penduduk per kab/kota | M | S | D | M1 | ⬜ | |
| B-703 | Cari data agregat bansos riil (data.go.id / Kemensos) | S | M | D | M1 | ⬜ | Q-06 |
| B-704 | Tulis copy Bahasa Indonesia (landing, FAQ, microcopy, galat) | M | M | D | M2 | ⬜ | |
| B-705 | Kumpulkan statistik & rujukan latar belakang (bersumber resmi) | M | M | D | M1 | ⬜ | PDF hal 2 |
| B-706 | `SOURCES.md` + `ATTRIBUTION.md` (data, font, ikon, lisensi) | M | S | D | M2 | ⬜ | |

## E8 — Kualitas

| ID | Butir | Prio | Uk. | Pemilik | MS | Status | Catatan / Penerimaan |
|---|---|---|---|---|---|---|---|
| B-801 | Lighthouse CI (mobile) terhadap staging | S | M | F | M2 | ⬜ | Target `prd.md` §3.2 |
| B-802 | Audit aksesibilitas: axe + keyboard + pembaca layar | M | M | F+D | M2 | ⬜ | `design.md` §9 |
| B-803 | Uji lintas perangkat (Android Chrome, iOS Safari; 360/390/768/1440) | M | M | F | M2 | ⬜ | |
| B-804 | Uji pengguna mini (5 orang, tugas "cari status resi") | S | M | D | M2 | ⬜ | Catat temuan → proposal bab 8 |
| B-805 | Tinjauan keamanan (OWASP dasar, header, secret scan) | M | M | K | M2 | ⬜ | |
| B-806 | Tuning performa (cache, gambar, font, eager load) | M | M | F+K | M2 | ⬜ | |
| B-807 | Rehearsal demo + verifikasi `hw:demo-reset` | M | M | ALL | M3 | ⬜ | |

## E9 — Deliverable Lomba

### M1 — First Draft (1 Nov)

| ID | Butir | Prio | Uk. | Pemilik | Status | Catatan |
|---|---|---|---|---|---|---|
| B-900 | Baca panduan resmi: jam batas, template surat, **aturan AI/orisinalitas**, cara submit | M | S | K | ⬜ | `context.md` Q-01–Q-03 |
| B-901 | `README.md`: judul + deskripsi 1–2 kalimat, tech stack, cara menjalankan, status progres | M | S | K | ⬜ | **Uji clone dari nol** |
| B-902 | **PDF Drafter** `WIA_FSDMIA2026_NamaTim` (≤ 10 hal, ≤ 10 MB) | M | L | D | ⬜ | Outline `submission.md` §1.2 |
| B-903 | Screenshot **Landing + Tracker** (1440 & 390) | M | S | F | ⬜ | Minimal 2 halaman; wajib landing |
| B-904 | Submit First Draft + bukti kirim | M | S | K | ⬜ | ≥ 3 jam sebelum batas |

### M2 — Penyisihan (11 Nov)

| ID | Butir | Prio | Uk. | Pemilik | Status | Catatan |
|---|---|---|---|---|---|---|
| B-910 | **Proposal PDF** `WIA_PenyisihanMIA2026_NamaTim` (≤ 30 hal) | M | XL | K+D | ⬜ | Outline `submission.md` §2.2 |
| B-911 | **Surat Orisinalitas bermaterai Rp10.000**: beli materai, tanda tangan, scan | M | M | K | ⬜ | **Beli materai paling lambat Sen 2 Nov** |
| B-912 | Folder Google Drive publik + uji incognito | M | S | K | ⬜ | Proposal + surat di satu tautan |
| B-913 | **Video pitching ≤ 5 mnt**: skrip → rekam → edit → subtitle → YouTube **Public** → deskripsi | M | XL | D (+F demo) | ⬜ | Target 4:30–4:45; `submission.md` §2.4 |
| B-914 | Submit Penyisihan + bukti kirim | M | S | K | ⬜ | Target Selasa malam 10 Nov |

### M3 — Final Onsite (28 Nov)

| ID | Butir | Prio | Uk. | Pemilik | Status | Catatan |
|---|---|---|---|---|---|---|
| B-920 | **Pitch Deck** `.pptx` + `.pdf` (≤ 15 slide, urutan wajib) | M | L | D | ⬜ | `submission.md` §4.1 |
| B-921 | Skrip presentasi 10 mnt + latihan ≥ 3× (dengan timer) | M | L | ALL | ⬜ | Target selesai 9:30 |
| B-922 | Bank Q&A ≥ 15 pertanyaan + penjawab | M | M | ALL | ⬜ | `submission.md` §4.3 |
| B-923 | **Cadangan demo**: server lokal offline + dump DB + rekaman layar + screenshot | M | M | K+F | ⬜ | Tak bergantung internet |
| B-924 | Logistik onsite (laptop, charger, adaptor, hotspot, USB, identitas) | M | S | ALL | ⬜ | |
| B-925 | Tag rilis `v1.0-final` + code freeze H-4 | M | S | K | ⬜ | 24 Nov |

### Rutin (∞)

| ID | Butir | Prio | Pemilik | Catatan |
|---|---|---|---|---|
| B-930 | Misi/kuis harian (XP) bergilir; kumpulkan Diamonds | S | ALL | Tukar tiket konsultasi mentor |
| B-931 | Konsultasi mentor: ≥ 1× sebelum 11 Nov, ≥ 1× sebelum 28 Nov | S | K | Siapkan pertanyaan spesifik |
| B-932 | Commit merata dari ketiga anggota | S | ALL | Riwayat commit terlihat juri |
| B-933 | Pantau pengumuman panitia (grup/email/portal) | M | K | Catat perubahan di `context.md` |
| B-934 | Standup 10 menit + perbarui `todos.md` & `context.md` §1 | M | ALL | |

---

## Icebox (tidak dikerjakan sebelum M3)

Mode gelap · Versi bahasa Inggris · PWA/offline · Notifikasi WhatsApp · API publik berautentikasi · Integrasi Dukcapil/Kemensos · Prediksi ML · Multi-bahasa daerah · PostGIS (query radius) · Aplikasi mobile native.

## Definition of Ready (sebelum butir diambil)
- Punya ID kebutuhan di `prd.md` atau tujuan jelas
- Pemilik & ukuran terisi; ketergantungan tidak terblokir
- Kriteria penerimaan dapat diuji

## Definition of Done
Lihat `AGENTS.md` §10.
