# Context — HakWarga (hakwarga.web.id)

> **Sumber kebenaran tunggal** untuk tim dan AI agent. Baca file ini dulu sebelum mengerjakan apa pun.
> Perbarui §1 (status) setiap selesai sesi kerja. Terakhir diperbarui: **Jum 30 Okt 2026**.

---

## 1. Status Saat Ini

> **Percepatan Proyek:** Seluruh perencanaan development di tanggal lain dimajukan hari ini (**Jum 30 Okt 2026**).

| Area | Status | Catatan |
|---|---|---|
| Konsep & paket dokumen | ✅ v0.1 | Dibuat 30 Okt |
| Repo + scaffold Laravel | ✅ | Selesai B-001 s.d. B-003 |
| Landing page | ✅ | Selesai B-106, B-107 |
| Resi Tracker (Modul A) | ✅ | Selesai B-201 s.d. B-207 |
| Lapor & Tiket (Modul C) | ✅ | Selesai B-401 s.d. B-410 |
| Wireframe & UI System | ✅ | Selesai (Anti-slop Tailwind v4) |
| Peta Anomali (Modul B) | 🟡 | Dimajukan hari ini (sedang dikembangkan) |
| Scorecard SLA (Modul D) | 🟡 | Dimajukan hari ini (sedang dikembangkan) |
| Admin (Filament) | 🟡 | Dimajukan hari ini (sedang dikembangkan) |
| PDF First Draft | 🟡 | B-902 dalam penyusunan |

Legenda: ⬜ belum · 🟡 berjalan · ✅ selesai · ⛔ terblokir

---

## 2. Kompetisi

| Item | Isi |
|---|---|
| Nama | Multimedia In Action (MIA) 2026 — cabang **Web In Action (WIA)** |
| Fokus WIA | Inovasi digital untuk keterbukaan publik: website *fully-functional*, performa, kerapian kode, responsif multi-device, aksesibilitas |
| Tema | Designing Digital Futures – Powering Public Transparency |
| Subtema terpilih | Public Service Tracking · Data-Driven Decision Support |
| Gamifikasi | Kuis/misi harian → XP; Diamonds dapat ditukar tiket konsultasi mentor/merchandise; ada leaderboard harian |

### 2.1 Timeline

| Milestone | Tanggal | Hari | Deliverable |
|---|---|---|---|
| M1 First Draft | 1 Nov 2026 | Minggu | Repo publik + README; PDF Drafter |
| M2 Penyisihan | 11 Nov 2026 | Rabu | Proposal PDF + Surat Orisinalitas + Video YouTube |
| M3 Final Onsite | 28 Nov 2026 | Sabtu | Deck (≤ 15 hal), presentasi 10 mnt + Q&A 5 mnt |

> ⚠️ **Jam batas pengumpulan belum diketahui.** Cek panduan resmi dan tulis di sini: `__:__ WIB`. Aturan tim: kirim **minimal 3 jam sebelum batas**.

### 2.2 Bobot Penilaian

**Penyisihan:** Fungsionalitas 25% · Orisinalitas Ide 20% · Desain & Estetika 20% · Konten & Informasi 20% · Kesesuaian Tema 15%

**Final:** Fungsionalitas & UX 25% · Desain & Kreativitas 20% · Presentasi & Komunikasi 20% · Orisinalitas & Konsep 15%

(Detail pemetaan ada di `prd.md` §10, rincian deliverable di `submission.md`.)

---

## 3. Tim

| Peran | Nama | Tanggung jawab | Kode |
|---|---|---|---|
| Ketua · PM & Backend Lead | `<Nama>` | Logika sistem, database, API, proposal, repo GitHub | **K** |
| Frontend Lead & Web Performance | `<Nama>` | Slicing UI ke Blade/Livewire, peta & grafik, responsif, kecepatan | **F** |
| UI/UX Designer, Data & Presenter | `<Nama>` | Figma, riset & olah data, video pitching, presentasi | **D** |

Kode **K / F / D** dipakai di `backlog.md` dan `todos.md`. **ALL** = seluruh tim.

---

## 4. Tentang Proyek (ringkas)

HakWarga (`hakwarga.web.id`): tracker resi bansos, peta anomali alokasi, pelaporan pungli/sanggah anonim, scorecard SLA instansi. Detail: `prd.md`.

**Jargon yang akan sering muncul** → lihat §9 Glosarium.

---

## 5. Keputusan (Decision Log)

| ID | Keputusan | Alasan | Status |
|---|---|---|---|
| D-01 | Nama & konsep final: **HakWarga** (Domain: `hakwarga.web.id`) | Disepakati tim. Filosofi human-centric: bansos adalah hak konstitusional warga yang wajib diterima utuh dan transparan | ✅ |
| D-02 | **Laravel 13** full-stack (PHP 8.3+); fallback **Laravel 12** bila PHP lokal anggota < 8.3. *Seluruh anggota memakai versi yang sama* | Permintaan tim; Laravel 13 adalah rilis mayor terbaru, Laravel 12 masih didukung | ✅ |
| D-03 | UI: **Blade + Livewire + Alpine.js + Tailwind CSS 4 + Vite**; tanpa SPA | Tercepat untuk 3 orang, SEO & performa bagus, bisa jalan tanpa JS untuk halaman inti | ✅ |
| D-04 | Database: **PostgreSQL 16+** (tanpa PostGIS di MVP) | `percentile_cont` untuk median anomali, `FILTER`, CTE, view; polygon peta cukup file GeoJSON statis. Detail: `database.md` §1 | ✅ |
| D-05 | Admin: **Filament 5** | Panel instansi/moderator tanpa menulis UI dari nol | ✅ |
| D-06 | Cache & session memakai driver `database`; queue `sync` (belum perlu worker) | Tanpa Redis/worker → infrastruktur minimal | ✅ |
| D-07 | Peta: **MapLibre GL JS** hanya menggambar polygon GeoJSON, **tanpa tile basemap** | Tanpa API key, cepat, tanpa masalah kebijakan tile | ✅ |
| D-08 | Data: kemiskinan & batas wilayah = **riil**; penerima/penyaluran/laporan = **sintetis berlabel SIMULASI** | Data penerima individual tidak terbuka & dilindungi UU PDP | ✅ |
| D-09 | Tracker hanya via **resi**, tanpa pencarian NIK publik | Mencegah pengintipan status orang lain. Mengubah draf awal | ✅ |
| D-10 | Identifier kode = Inggris; teks UI = Indonesia | Kerapian kode untuk penilaian & konsistensi | ✅ |
| D-11 | Zona waktu aplikasi `Asia/Jakarta`; locale `id` | Tanpa DST, SLA lebih mudah dihitung | ✅ |
| D-12 | Screenshot First Draft boleh dari lingkungan lokal; **deploy sebelum 11 Nov** (video demo butuh tampilan stabil) | Memangkas risiko di jalur kritis M1 | ✅ |
| D-13 | Hosting aplikasi & database: **Self-Hosted VPS Pribadi** (Ubuntu + Docker Compose / Nginx + PostgreSQL 16) | Kontrol penuh, performa tinggi (medium-high specs VPS), 0 biaya PaaS, zero vendor lock-in (bebas Vercel/Supabase/dll) | ✅ |
| D-14 | Wilayah pilot untuk drill-down desa/kecamatan (1 provinsi/kab) | Menjaga cakupan data realistis. Rekomendasi: wilayah yang datanya paling mudah diperoleh | 🟡 OPEN |
| D-15 | Panduan dev: `AGENTS.md` kanonik; `CLAUDE.md` hanya menunjuk ke sana | Satu sumber aturan untuk semua AI tool | ✅ |
| D-16 | **Frontend Wajib Anti-Slop:** Setiap agent/AI wajib memanggil & mematuhi skill `antislop` | Mencegah UI/copywriting khas AI murahan (sparkle, gradien klise, metrik kosong, copy robotik) | ✅ |
| D-17 | **Sovereign Storage & Optional AI:** Storage privat lokal di VPS. Integrasi model AI bersifat opsional (on-demand via direct API / proxy `9router` hanya jika ada fitur yang membutuhkan; default dilewati) | YAGNI, kedaulatan data, tanpa dependensi SaaS AI eksternal | ✅ |

Tambah keputusan baru di bawah tabel ini dan beri ID berurutan. **Jangan mengubah keputusan ✅ tanpa diskusi tim.**

---

## 6. Asumsi & Pertanyaan Terbuka

| # | Pertanyaan | Siapa | Tenggat |
|---|---|---|---|
| Q-01 | Jam batas submit M1/M2 dan cara submit (form/email/portal)? | K | 30 Okt |
| Q-02 | **Ketentuan orisinalitas: apakah penggunaan AI coding assistant diperbolehkan / perlu dideklarasikan?** Surat Orisinalitas ditandatangani tim, jadi harus sesuai aturan | K | 30 Okt |
| Q-03 | Template resmi Surat Orisinalitas ("Surat Pernyataan" atau "Surat Keterangan"?) dan cara pemeteraian (materai tempel/e-meterai) | K | 31 Okt |
| Q-04 | Apakah URL demo yang live wajib/diutamakan di M2? | K | 2 Nov |
| Q-05 | Apakah ada format/tool wajib untuk wireframe & PDF Drafter? | D | 31 Okt |
| Q-06 | Apakah data bansos agregat riil tersedia (data.go.id, Kemensos) untuk ≥ 1 provinsi? | D | 3 Nov |
| Q-07 | Kapan pengumuman finalis dan detail onsite (alat, koneksi internet, tata ruang)? | K | pantau |
| Q-08 | Batas pemakaian lisensi font/ikon/gambar yang diizinkan? | D | 2 Nov |

---

## 7. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Waktu M1 hanya ±2 hari | Draft tidak punya 2 halaman jadi | Fokus Landing + Tracker; modul lain cukup wireframe; feature freeze Sab 22.00 |
| Data bansos riil tidak tersedia | Peta kosong | Data sintetis berlabel SIMULASI + data BPS riil; jelaskan di `/data` |
| Anomali sintetis terbaca sebagai tuduhan pada wilayah/instansi nyata | Risiko etis/hukum | Watermark "SIMULASI" pada peta/scorecard; bahasa "perlu ditelaah"; nama instansi demo bila perlu |
| Kebocoran identitas pelapor | Kredibilitas runtuh | Aturan privasi `prd.md` §7; tes otomatis tidak ada IP/PII; disclaimer jujur |
| Peta berat di HP | Skor performa turun | GeoJSON disederhanakan, per level, lazy-load, tabel alternatif |
| Versi PHP/Laravel berbeda antar anggota | "Di laptopku jalan" | Kunci versi di `composer.json` (`platform.php`) dan `.tool-versions`/README |
| Konflik merge di migrasi/route | Waktu hilang | Branch pendek, PR kecil, satu pemilik per folder (AGENTS.md §9) |
| Demo gagal saat final (internet/hosting) | Nilai Fungsionalitas turun | Server lokal offline + dump DB + rekaman layar (B-923) |
| Anggota kelelahan menjelang deadline | Kualitas turun | Feature freeze tegas; buffer 1 hari sebelum tiap deadline |
| Penggunaan AI tidak sesuai aturan lomba | Diskualifikasi | Selesaikan Q-02 hari ini |

---

## 8. Sumber Data & Rujukan yang Harus Dikumpulkan

Catat tiap sumber: judul, penerbit, tahun, URL, tanggal akses, lisensi/ketentuan.

| Kebutuhan | Kandidat sumber | PIC | Status |
|---|---|---|---|
| Persentase penduduk miskin per kab/kota | BPS (tabel statistik kemiskinan) | D | ⬜ |
| Jumlah penduduk per kab/kota | BPS (proyeksi/sensus) | D | ⬜ |
| Batas wilayah (GeoJSON) | BIG / Satu Peta / BPS, atau repo komunitas **berlisensi jelas** | D→F | ⬜ |
| Program & nilai bantuan (PKH, BPNT, dll.) | Situs resmi Kemensos | D | ⬜ |
| Data penerima agregat riil | data.go.id / portal data Kemensos | D | ⬜ |
| Statistik masalah (pungli/salah sasaran) untuk latar belakang | BPK, KPK, ICW, laporan Ombudsman, media kredibel | D | ⬜ |
| Dasar hukum | UU PDP 27/2022; UU KIP 14/2008 | K | ⬜ |

> **Pastikan satu sistem kode wilayah** (BPS *atau* Kemendagri) di CSV dan GeoJSON. Bila berbeda, buat tabel pemetaan sebelum seeding.

---

## 9. Glosarium

| Istilah | Arti |
|---|---|
| Bansos | Bantuan sosial |
| KPM | Keluarga Penerima Manfaat |
| PKH | Program Keluarga Harapan |
| BPNT | Bantuan Pangan Non Tunai (Program Sembako) |
| DTKS / DTSEN | Basis data penerima / data sosial-ekonomi nasional |
| Pungli | Pungutan liar |
| Resi | Kode unik pelacakan satu penyaluran |
| Tiket | Kode unik pelacakan satu laporan |
| Sanggah | Keberatan warga atas kelayakan penerima |
| Rasio Sasaran | Kuota penerima ÷ perkiraan penduduk miskin |
| Red Flag | Wilayah dengan rasio relatif di luar ambang |
| SLA | Batas waktu layanan (respon 72 jam, selesai 14 hari) |
| Simulasi | Data buatan untuk demo, selalu berlabel |
| M1 / M2 / M3 | Milestone First Draft / Penyisihan / Final |

---

## 10. Peta Dokumen

| File | Isi | Pembaca utama |
|---|---|---|
| `README.md` | Pintu masuk repo (dinilai juri) | Juri, kontributor |
| `context.md` | Konteks, keputusan, risiko | Semua |
| `prd.md` | Apa yang dibangun & aturan bisnis | Semua |
| `structure.md` | Arsitektur, folder, route, deployment | K, F |
| `database.md` | Skema, view, seed | K |
| `design.md` | Design system, wireframe, aksesibilitas | D, F |
| `submission.md` | Spesifikasi & outline semua deliverable lomba | K, D |
| `backlog.md` | Daftar kerja berprioritas | PM |
| `todos.md` | Jadwal harian & centang | Semua |
| `AGENTS.md` / `CLAUDE.md` | Aturan untuk AI coding agent | AI |
