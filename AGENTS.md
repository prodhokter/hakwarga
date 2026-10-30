# AGENTS.md — Panduan untuk AI Coding Agent & Kontributor

> File kanonik. `CLAUDE.md` hanya menunjuk ke sini. Bahasa penjelasan ke tim: **Indonesia**. Kode, komentar kode, nama variabel/tabel: **Inggris**. Teks UI: **Indonesia** (`lang/id`).

## 1. Proyek

**HakWarga** (`hakwarga.web.id`) — platform web transparansi bantuan sosial & pemenuhan hak publik (Resi Tracker, Peta Anomali, Lapor Pungli/Sanggah + Tiket, Scorecard SLA). Proyek lomba **MIA 2026 — Web In Action**. Dinilai pada: fungsionalitas, orisinalitas, desain, konten, kesesuaian tema, **performa, kerapian kode, responsif, aksesibilitas**.

## 2. Baca Dulu (urut)

1. `docs/context.md` — status (§1), keputusan (§5), risiko
2. `docs/prd.md` — kebutuhan & aturan bisnis (§8)
3. Butir kerja di `docs/backlog.md` / `docs/todos.md`
4. `docs/structure.md` dan `docs/database.md` — sebelum menyentuh kode/skema
5. `docs/design.md` — sebelum menyentuh UI

Jika dokumen bertentangan dengan permintaan, **tanyakan** — jangan menebak.

## 3. Stack & Infrastruktur Mandiri

PHP 8.3+ · **Laravel 13** (fallback 12; jangan campur versi) · Blade + Livewire + Alpine · Tailwind CSS 4 + Vite · **PostgreSQL 16** · Filament 5 (admin) · MapLibre GL JS (offline GeoJSON) · Chart.js · Pest · Pint · Larastan.

**Arsitektur Mandiri (Sovereign Infrastructure):**
- Sistem dirancang 100% independen tanpa vendor lock-in (bebas dari Vercel, Supabase, Neon, Railway, Cloudflare KV proprietary, dsb).
- Production target: **Self-Hosted VPS** (Ubuntu LTS + Docker Compose / Nginx + PHP-FPM + PostgreSQL 16 bawaan).
- Storage berkas privat di local filesystem VPS, caching/session via DB/Redis lokal.
- Integrasi model AI bersifat **opsional**: hanya digunakan jika ada fitur yang benar-benar memerlukan LLM. Bila tidak ada use-case wajib, jangan gunakan/skip. Jika dibutuhkan, akses melalui direct API atau proxy mandiri (`9router`).

## 4. Perintah

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
docker compose up -d db
php artisan migrate --seed
npm run dev                         # terminal 1
php artisan serve                   # terminal 2

php artisan test                    # Pest (butuh PostgreSQL)
./vendor/bin/pint                   # format
./vendor/bin/pint --test            # cek format (CI)
./vendor/bin/phpstan analyse        # analisis statis
npm run build                       # build produksi
php artisan hw:demo-reset           # reset data demo (non-produksi saja)
```

## 5. Arsitektur & Konvensi Kode

Ringkasan (rinci: `docs/structure.md` §4):
- **Controller tipis** → FormRequest → **Action/Service** → Model. Tidak ada logika bisnis di Blade/Controller.
- `declare(strict_types=1);` di setiap file PHP. Ikuti Pint (PSR-12 + preset Laravel).
- Status memakai **PHP backed enum** (`app/Enums`), disimpan sebagai string.
- `$fillable` eksplisit. Hindari `DB::raw` dengan input pengguna tanpa binding.
- Cegah N+1: eager load; `Model::preventLazyLoading(! app()->isProduction())` aktif.
- Nama route pakai *named routes* dari `docs/structure.md` §5; **jangan ganti nama** tanpa memperbarui dokumen.
- Rumus anomali & SLA hanya di `AnomalyService` / `SlaScoreService`; ambang di `config/hakwarga.php` (jangan hardcode).
- Teks UI lewat `lang/id/*` atau Blade; format Rupiah via `App\Support\Money`.
- Zona waktu `Asia/Jakarta`, locale `id`.
- Komentar menjelaskan **mengapa**, bukan **apa**. Tidak ada kode mati/`dd()`/`console.log` tertinggal.

## 6. Aturan Privasi & Keamanan — TIDAK BOLEH DILANGGAR

1. **Dilarang menyimpan, mencatat, atau menampilkan NIK mentah.** Hanya `nik_hash` (HMAC-SHA256 + pepper).
2. **Tidak ada data pribadi nyata** di repo, seeder, fixture, tes, atau screenshot. Semua data demo sintetis dengan `is_simulated = true` dan label **SIMULASI** di UI.
3. **Jangan mencatat IP** pelapor atau body request `/lapor/*` (log, DB, exception context).
4. Laporan tipe `extortion` **tidak boleh** menyimpan referensi resi/penerima.
5. Isi laporan & lampiran **tidak pernah** tampil di halaman publik/API publik.
6. Output Blade memakai `{{ }}`. **Jangan** `{!! !!}` untuk data pengguna.
7. Semua form: CSRF aktif, FormRequest, throttle; form laporan juga Turnstile + honeypot.
8. Lampiran: validasi MIME, re-encode gambar (hapus EXIF), nama acak, disk privat.
9. Tidak ada rahasia di repo (`.env`, kunci, sandi). Gunakan `.env.example`.
10. Bahasa indikator: "perlu ditelaah"/"kemungkinan" — **jangan** menuduh instansi/wilayah/individu.
11. Dilarang menyalin kode/aset berlisensi tanpa atribusi; catat sumber di `docs/ATTRIBUTION.md`.
12. Jangan mengklaim fitur yang belum ada di README, PDF, atau UI.

## 7. Desain Anti-Slop, Performa & Aksesibilitas

- **Wajib Anti-Slop:** Setiap agent/kontributor yang mengerjakan frontend & UI **wajib mengaktifkan skill antislop** (`antislop`, `antislop-ui`, `antislop-copywriting`, `antislop-human`, `antislop-layoutmobile`). Dilarang keras menghasilkan "AI slop" (sparkle berlebih, gradient ungu/pink klise, metrik palsu tanpa dasar, copy robotik, border glow berlebihan).
- **Larangan Khusus Anti-AI-Slop:**
  - Dilarang membuat border stripe berwarna di sisi kiri kartu/elemen (`border-l-*` dekoratif).
  - Dilarang membuat pill badge dengan dot hijau/kuning dekoratif di atas heading.
  - Teks wajib ringkas (1-2 kata per frasa), tanpa bertele-tele.
  - Dilarang menggunakan topbar konvensional; gunakan collapsible sidebar.
  - Bebas dari em dash (`—`).
  - Cukup tema terang murni (*light theme only*); tanpa footer publik.
  - Font primer wajib **Plus Jakarta Sans**. Seluruh ikon dibuat manual berupa SVG inline murni.
- Halaman inti harus bekerja **tanpa JS**; JS hanya peningkatan. Anggaran: JS landing ≤ 150 KB gzip; `map.js`/`charts.js` dimuat lazy.
- Gambar: WebP/AVIF, `width`/`height`, `loading="lazy"` di bawah lipatan. Font self-host (`font-display: swap`).
- Endpoint agregat di-cache (`Cache::remember`, kunci berversi).
- HTML semantik, satu `<h1>`, label form, `aria-describedby` untuk galat, `aria-live` untuk status dinamis.
- Kontras ≥ 4,5:1, fokus terlihat, target sentuh ≥ 44 px, hormati `prefers-reduced-motion`.
- Peta wajib punya **alternatif tabel**. Informasi tidak boleh hanya lewat warna.
- Uji di 360 px dan 1440 px sebelum menyatakan UI selesai.

## 8. Git & Pull Request

- Branch pendek dari `main`: `feat/B-204-tracker-service`, `fix/…`, `docs/…`. Satu butir backlog ≈ satu PR kecil.
- Commit: *Conventional Commits* — `feat(tracker): tampilkan rincian hak`, `fix(map): …`, `docs: …`, `test: …`, `chore: …`. Commit sering, **atas nama masing-masing anggota** (riwayat commit terlihat juri).
- PR berisi: ID backlog, ringkasan, **screenshot (UI)**, hasil `pint`/`phpstan`/`test`, dampak ke dokumen.
- `main` harus selalu dapat dijalankan & didemokan. Jangan push langsung ke `main` setelah Sab 31 Okt; jangan `--force` ke `main`; jangan `--no-verify`.
- Migrasi yang sudah di-merge **tidak diedit**; buat migrasi baru. Konflik skema → koordinasi dengan K.

## 9. Kepemilikan Area

| Area | Pemilik | Catatan |
|---|---|---|
| `app/Models`, `Services`, `Actions`, `Enums`, `Console`, `Policies`, `Http/Requests`, `Http/Controllers/Api`, `app/Filament`, `database/migrations`, `database/seeders`, `config/`, `routes/*`, `.github/` | **K** | F mengajukan perubahan via PR/isu |
| `resources/*`, `app/Livewire`, `public/*`, `vite.config.js`, controller web (sisi view) | **F** | K menyepakati *kontrak data* ke view |
| `docs/img`, `design.md`, `database/data/*` (pembersihan data), copy di `lang/id` | **D** | F meninjau kecocokan teknis |
| `README.md`, `docs/*.md` | Bersama | Pemilik fitur memperbarui bagiannya |

Menyentuh area orang lain → buat PR kecil dan minta tinjau pemiliknya.

## 10. Definition of Done

- [ ] `pint --test`, `phpstan`, `php artisan test` hijau
- [ ] Ada tes untuk logika baru (minimal Feature test jalur utama + kasus gagal)
- [ ] UI diuji 360 px & 1440 px, keyboard, tanpa galat konsol
- [ ] Teks UI Bahasa Indonesia, tanpa string hardcode campuran
- [ ] Tidak ada N+1 baru; migrasi dapat di-`rollback`
- [ ] Aturan §6 tidak dilanggar
- [ ] `CHANGELOG.md` diperbarui di bagian `[Unreleased]` atau versi terkait
- [ ] `docs/todos.md` dicentang; `README.md` (Status Progres) & `docs/context.md` §1 diperbarui bila relevan

## 11. Cara Bekerja (untuk AI Agent)

1. Baca konteks (§2), kenali butir backlog yang dikerjakan.
2. Untuk perubahan > 3 berkas atau menyentuh skema/route: **sampaikan rencana singkat dulu**.
3. Kerjakan kecil dan bertahap; jalankan tes/lint setelah tiap bagian.
4. Jangan menambah dependensi tanpa alasan; bila perlu, catat di `docs/context.md` (Decision Log).
5. Jangan mengubah keputusan ✅ di `context.md` §5 tanpa persetujuan tim.
6. Catat setiap perbaikan bug, penambahan fitur, atau perubahan arsitektur ke dalam `CHANGELOG.md`.
7. Setelah selesai: rangkum **apa yang berubah**, **cara mengujinya**, dan **hal yang belum selesai** (jujur).
8. Bila persyaratan ambigu **dan** menyangkut privasi/keamanan, **bertanya** — jangan berasumsi.

## 12. Larangan Cepat

`migrate:fresh` di non-lokal · commit `.env` · NIK/PII nyata · `{!! !!}` untuk input pengguna · menonaktifkan CSRF/throttle · mencatat body laporan · mengedit migrasi yang sudah di-merge · mengubah nama route tanpa update docs · menulis angka statistik tanpa sumber · menandai tugas selesai tanpa menjalankan tes.
