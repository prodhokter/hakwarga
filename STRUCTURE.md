# Structure — Arsitektur & Struktur Proyek

> Pemilik: K (Backend) + F (Frontend). Terkait: `database.md` · `prd.md` · `AGENTS.md`

---

## 1. Gambaran Arsitektur

Aplikasi **monolit Laravel** (server-rendered) dengan "pulau" interaktif seperlunya.

```
Browser (HP/Desktop)
   │  HTML (Blade) + sedikit JS (Alpine/Livewire); MapLibre & Chart.js dimuat lazy
   ▼
Laravel 13 (PHP 8.3+)
   ├─ routes/web.php ──► Controller tipis ──► Service / Action ──► Eloquent Model
   ├─ routes/api.php (read-only, /api/v1/*) ──► API Resource (JSON untuk peta & grafik)
   ├─ Livewire (form Lapor, tabel sortir)       └─► PostgreSQL 16 (+ view analitik)
   ├─ Filament 5  (/admin: instansi & moderator)
   └─ Storage privat (bukti laporan, EXIF dibersihkan)

Statis: public/geo/*.geojson (batas wilayah, sudah disederhanakan)
Data awal: database/data/*.csv  ──► Seeder/Importer ──► PostgreSQL
```

**Prinsip:** satu repo, satu proses deploy, infrastruktur minimal (tanpa Redis, tanpa worker queue untuk MVP), halaman inti tetap berfungsi tanpa JavaScript.

---

## 2. Stack Final

| Lapisan | Pilihan | Catatan |
|---|---|---|
| Bahasa/Runtime | PHP **8.3+** | Laravel 13 butuh PHP 8.3–8.5; fallback Laravel 12 bila PHP lokal < 8.3 (D-02) |
| Framework | **Laravel 13** | Kunci versi di `composer.json` |
| Templating | Blade + Blade Components | Tanpa SPA |
| Interaktivitas | **Livewire** (versi yang dipasangkan Filament 5) + Alpine.js | Livewire hanya untuk form bertahap & tabel sortir |
| CSS | **Tailwind CSS 4** (via Vite) | Token di `resources/css/app.css` (`@theme`) |
| Peta | **MapLibre GL JS** | Hanya polygon GeoJSON, tanpa tile basemap (D-07) |
| Grafik | **Chart.js** | Dimuat lazy di halaman yang butuh |
| Database | **PostgreSQL 16+** | Lihat `database.md` |
| Admin | **Filament 5** | `/admin` |
| Anti-bot | Cloudflare **Turnstile** | Kunci uji tersedia di dokumentasi Turnstile untuk lokal |
| Gambar | `intervention/image` | Re-encode untuk membersihkan EXIF |
| Kualitas | **Pest**, **Pint**, **Larastan** | Wajib hijau di CI |
| CI | GitHub Actions | §12 |
| Cache/Session | driver `database` | Queue: `sync` (belum perlu worker) |

**Paket Composer (perkiraan):**
```
require:     filament/filament intervention/image
require-dev: pestphp/pest pestphp/pest-plugin-laravel larastan/larastan laravel/pint
```
**Paket npm:** `maplibre-gl` `chart.js` (+ `mapshaper` sebagai devDependency untuk menyederhanakan GeoJSON).
Tidak memakai starter kit auth: publik tanpa login; login admin disediakan Filament.

> Versi paket mengikuti kompatibilitas Laravel yang dipilih. Jalankan `composer why-not` / baca *upgrade guide* sebelum menambah paket baru, lalu catat di `context.md` (Decision Log).

---

## 3. Struktur Folder

```
hakwarga/
├── app/
│   ├── Actions/              # satu tindakan = satu kelas: CreateExtortionReport, AdvanceShipmentStatus
│   ├── Console/Commands/     # hw:demo-reset, hw:import-regions, hw:import-poverty, hw:cache-warm
│   ├── Enums/                # ShipmentStatus, ReportType, ReportStatus, EligibilityStatus, RegionLevel, ...
│   ├── Filament/Resources/   # ShipmentResource, ReportResource, AgencyResource
│   ├── Http/
│   │   ├── Controllers/      # tipis: Home, Tracker, Map, Report, Ticket, Scorecard, Data, About
│   │   │   └── Api/V1/       # MapController, RegionController, ScorecardController
│   │   ├── Middleware/       # SecurityHeaders, NoStore, VerifyTurnstile
│   │   ├── Requests/         # LookupReceiptRequest, StoreExtortionReportRequest, StoreDisputeReportRequest
│   │   └── Resources/        # API Resources
│   ├── Livewire/             # ExtortionWizard, DisputeWizard, BeneficiaryPicker, ScorecardTable, RedFlagTable
│   ├── Models/               # Region, PovertyStat, AidProgram, AidAllocation, Agency, Beneficiary,
│   │                         # Shipment, ShipmentEvent, Report, ReportUpdate, ReportAttachment, User
│   ├── Policies/             # ReportPolicy, ShipmentPolicy
│   ├── Providers/
│   ├── Services/             # lihat §7
│   └── Support/              # Money (format Rupiah), Alphabet kode acak
├── bootstrap/
├── config/hakwarga.php       # ambang anomali, SLA, kode, fitur
├── database/
│   ├── data/                 # regions.csv, poverty.csv + SOURCES.md (sumber & lisensi)
│   ├── factories/
│   ├── migrations/
│   └── seeders/              # termasuk DemoScenarioSeeder
├── docs/                     # prd.md, context.md, structure.md, database.md, design.md,
│   │                         # submission.md, backlog.md, todos.md
│   └── img/                  # wireframe, mockup, screenshot (untuk PDF)
├── lang/id/                  # terjemahan UI (messages, validation)
├── public/
│   └── geo/                  # provinces.geojson, regencies/{kode_prov}.geojson
├── resources/
│   ├── css/app.css
│   ├── js/                   # app.js, map.js (lazy), charts.js (lazy)
│   └── views/
│       ├── components/       # <x-ui.*> komponen Blade
│       ├── layouts/app.blade.php
│       ├── pages/            # home, tracker, map, report, ticket, scorecard, data, about
│       └── livewire/
├── routes/                   # web.php, api.php, console.php
├── tests/                    # Feature/, Unit/
├── .github/workflows/ci.yml
├── compose.yaml              # PostgreSQL lokal
├── AGENTS.md  CLAUDE.md  README.md
└── composer.json  package.json  vite.config.js  phpstan.neon  pint.json
```

`README.md`, `AGENTS.md`, `CLAUDE.md` tetap di **root** (dibaca juri dan tools). Dokumen lain ditaruh di `docs/`.

---

## 4. Lapisan & Aturan Kode

| Lapisan | Tanggung jawab | Dilarang |
|---|---|---|
| Route | Memetakan URL → controller, menempel middleware & throttle | Logika bisnis |
| Controller | Validasi via FormRequest, panggil Service/Action, return view/JSON | Query rumit, rumus |
| FormRequest | Validasi + otorisasi + normalisasi input | Akses DB berat |
| Action | Satu use-case bertransaksi (membuat laporan, menambah event) | Memformat tampilan |
| Service | Logika domain berulang (anomali, SLA, pelacakan, kode) | Mengakses `request()` langsung |
| Model | Relasi, scope, cast enum, accessor ringan | Logika multi-langkah |
| View/Blade | Presentasi | Query, logika bisnis, `{!! !!}` untuk input pengguna |

Aturan tambahan: `declare(strict_types=1);` · `Model::preventLazyLoading(! app()->isProduction())` · enum PHP untuk status · `$fillable` eksplisit · eager loading · tidak ada `DB::raw` dengan input pengguna tanpa binding.

---

## 5. Routes

### 5.1 Web

| Method | Path | Nama route | Catatan |
|---|---|---|---|
| GET | `/` | `home` | Landing |
| GET | `/lacak` | `tracker.index` | Form resi (`?resi=` untuk tautan langsung) |
| GET | `/lacak/{receipt}` | `tracker.show` | `throttle:tracker` (10/mnt) |
| GET | `/peta` | `map.index` | |
| GET | `/peta/{code}` | `map.show` | Deep-link ke wilayah (kode BPS) |
| GET | `/lapor` | `report.choose` | Pilih jenis laporan |
| GET·POST | `/lapor/pungli` | `report.extortion.create` / `.store` | `throttle:report`, Turnstile |
| GET·POST | `/lapor/sanggah` | `report.dispute.create` / `.store` | `throttle:report`, Turnstile |
| GET | `/lapor/sukses` | `report.success` | Hanya via flash session; `no-store` |
| GET | `/tiket` | `ticket.lookup` | Form kode tiket + kode rahasia |
| POST | `/tiket` | `ticket.access` | `throttle:ticket`; sukses → session akses pelapor |
| GET | `/tiket/{ticket}` | `ticket.show` | Status publik (tanpa isi laporan) |
| POST | `/tiket/{ticket}/tambahan` | `ticket.reply` | Hanya pelapor ber-session |
| GET | `/scorecard` | `scorecard.index` | |
| GET | `/scorecard/{agency:slug}` | `scorecard.show` | |
| GET | `/data` | `data.index` | Metodologi & sumber |
| GET | `/data/unduh/{dataset}.csv` | `data.download` | `anomaly`, `scorecard` |
| GET | `/tentang` | `about` | Misi, privasi, FAQ |
| GET | `/up` | — | Health check bawaan Laravel |

### 5.2 API v1 (read-only, `throttle:api` 60/mnt)

| Method | Path | Isi |
|---|---|---|
| GET | `/api/v1/map/choropleth?level=&program=&period=&layer=` | `[{code, value, flag, severity}]` |
| GET | `/api/v1/regions/{code}` | Metrik wilayah + flag + median pembanding |
| GET | `/api/v1/regions/{code}/beneficiaries?q=` | Penerima tersamar, paginasi (ID = `public_id`) |
| GET | `/api/v1/scorecard?level=&region=` | Peringkat SLA |
| GET | `/api/v1/agencies/{slug}/sla` | Tren bulanan + distribusi status |

### 5.3 Admin
`/admin` — Filament (login, peran `super_admin` · `moderator` · `agency_officer`).

---

## 6. Komponen UI

**Blade (`<x-ui.*>`):** `button` · `input` · `select` · `textarea` · `badge` · `flag-badge` · `card` · `alert` · `stat` · `timeline` · `table` · `stepper` · `receipt-input` · `ticket-card` · `simulated-banner` · `skip-link` · `page-header` · `breadcrumbs`.

**Livewire:** `ExtortionWizard` · `DisputeWizard` · `BeneficiaryPicker` · `ScorecardTable` · `RedFlagTable`.

**JS:** `map.js` (MapLibre, `IntersectionObserver` untuk lazy-init) · `charts.js` · `app.js` (Alpine, kecil).

Spesifikasi visual: `design.md`.

---

## 7. Services, Actions & Perintah Artisan

| Kelas | Tugas |
|---|---|
| `ReceiptCodeFactory` / `TicketCodeFactory` | Membuat & memvalidasi kode (alfabet aman, tanpa pola berurutan) |
| `NikHasher` | `HMAC-SHA256(nik, HW_NIK_PEPPER)`; tidak ada metode kebalikan |
| `PiiMasker` | Menyamarkan pola NIK (16 digit) & telepon pada teks bebas |
| `ShipmentTrackingService` | Mengambil shipment + events + rincian hak untuk satu resi |
| `AnomalyService` | Membaca `v_anomaly_scores`, menetapkan flag & severity dari config |
| `SlaScoreService` | Menghitung skor & peringkat instansi (query di `database.md` §6) |
| `MapDataService` | Menyusun payload choropleth + cache berversi |
| `AttachmentStore` | Validasi MIME, re-encode gambar (hapus EXIF), nama acak, disk privat |
| `TurnstileVerifier` | Memverifikasi token Turnstile ke endpoint Cloudflare (fallback honeypot/rate-limiter) |
| `CreateExtortionReport` / `CreateDisputeReport` | Transaksi: validasi → simpan → kode tiket + rahasia |
| `AddReportUpdate` | Menambah tanggapan; mengisi `first_response_at`/`resolved_at` |
| `AdvanceShipmentStatus` | Menambah `shipment_events` + memperbarui `current_status` |

**Perintah Artisan**

| Perintah | Fungsi | Pengaman |
|---|---|---|
| `hw:demo-reset` | `migrate:fresh --seed` + skenario demo | **Menolak jalan** di `production` kecuali `--force-demo` |
| `hw:import-regions {csv}` | Impor wilayah dari CSV | Idempoten |
| `hw:import-poverty {csv}` | Impor statistik kemiskinan | Idempoten |
| `hw:cache-warm` | Menaikkan versi cache & memanaskan endpoint peta | — |

---

## 8. Konfigurasi

### 8.1 `config/hakwarga.php`
```php
return [
    'simulated_banner' => env('HW_SIMULATED_BANNER', true),
    'nik_pepper'       => env('HW_NIK_PEPPER'),

    'anomaly' => [
        'under_threshold'  => 0.5,
        'over_threshold'   => 1.5,
        'high_under'       => 0.3,
        'high_over'        => 2.0,
    ],

    'sla' => [
        'response_hours'   => 72,
        'resolve_days'     => 14,
        'min_due_reports'  => 5,
        'weights'          => ['response' => 0.5, 'resolve' => 0.5],
    ],

    'codes' => [
        'alphabet'        => '23456789ABCDEFGHJKMNPQRSTVWXYZ',
        'receipt_regex'   => '/^HWR-[A-Z]{3,5}-\d{4}-[A-Z0-9]{6}$/',
        'ticket_regex'    => '/^HWT-\d{4}-[A-Z0-9]{6}$/',
    ],

    'attachments' => ['max_files' => 3, 'max_kb' => 5120, 'mimes' => ['jpg', 'jpeg', 'png', 'pdf']],
];
```

### 8.2 `.env.example` (kunci penting)
```
APP_NAME="HakWarga"
APP_URL="https://hakwarga.web.id"
APP_ENV=local
APP_DEBUG=true
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID
APP_TIMEZONE=Asia/Jakarta

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hakwarga
DB_USERNAME=hakwarga
DB_PASSWORD=secret

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

HW_SIMULATED_BANNER=true
HW_NIK_PEPPER=            # php artisan tinker → Str::random(64)
HW_SEED_DEMO_USERS=true
HW_DEMO_PASSWORD=         # isi lokal; jangan commit

TURNSTILE_SITE_KEY=       # gunakan kunci uji Cloudflare di lokal / kosongkan untuk bypass
TURNSTILE_SECRET_KEY=
```
Jangan pernah commit `.env`. Hanya `.env.example` dengan nilai kosong/aman.

---

## 9. Pipeline Data Geo

```
Sumber batas wilayah (cek lisensi!)
   │  samakan kode wilayah dengan database/data/regions.csv
   ▼
mapshaper: simplify + pembulatan koordinat
   npx mapshaper in.geojson -simplify 8% keep-shapes -o precision=0.0001 out.geojson
   ▼
public/geo/provinces.geojson            (target ≤ 1 MB gzip)
public/geo/regencies/{kode_prov}.geojson (dimuat saat drill-down)
```
- Properti minimal tiap fitur: `code`, `name`. Nilai metrik **tidak** ditanam; diambil dari API agar file statis bisa di-cache lama.
- Simpan sumber, tanggal, dan lisensi di `database/data/SOURCES.md`.
- Jumlah provinsi (34 vs 38) bergantung tahun data; **samakan** dengan GeoJSON.

---

## 10. Hosting & Deployment Mandiri (Sovereign Infrastructure)

> **D-13 (FINAL): Self-Hosted VPS Pribadi.** Sepenuhnya independen tanpa ketergantungan pada vendor pihak ketiga/PaaS (tanpa Vercel, Railway, Render, Supabase, Neon, atau cloud lock-in lainnya).
> Mengoptimalkan advantage infrastruktur pribadi: VPS Ubuntu (medium-high specs), dedicated IP, Docker Compose, akses proxy AI pribadi (`9router` / direct API).

### 10.1 Target Arsitektur Produksi di VPS
```
Internet ──► Nginx Reverse Proxy (SSL / Let's Encrypt / Certbot)
                 │
                 ├──► Laravel 13 App Container (PHP 8.3-FPM + Octane/Nginx)
                 │         │
                 │         ├──► PostgreSQL 16 (Local Container / Dedicated Unix Socket)
                 │         ├──► Local Storage Privat (/var/www/storage/app/private)
                 │         └──► Local Cache & Database Session
                 │
                 └──► GeoJSON Static Assets & Vite Bundles (Cached locally)
```

- **Database:** PostgreSQL 16 terpasang di VPS yang sama (container terisolasi atau native service), performa kencang dengan latensi ultra-rendah (localhost/socket), tanpa batas koneksi PaaS eksternal.
- **Storage Bukti:** Disk privat lokal VPS (`storage/app/private`), diakses streaming hanya lewat otorisasi admin/moderator Filament (tanpa S3 pihak ketiga).
- **AI Integrasi:** Model AI bersifat **opsional** (lewati/skip jika tidak ada fitur yang strictly membutuhkan LLM). Bila sewaktu-waktu dibutuhkan (mis. asistensi penapisan laporan), gunakan direct API atau proxy mandiri (`9router`).

**Domain:** `https://hakwarga.web.id` (A record diarahkan langsung ke IP VPS).

**Checklist deploy**
- [ ] `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` di-set, `HW_NIK_PEPPER` di-set
- [ ] `php artisan migrate --force` · `php artisan storage:link`
- [ ] `php artisan config:cache route:cache view:cache event:cache`
- [ ] `npm run build` (aset hasil build ter-compile)
- [ ] Seed demo di staging/produksi: `php artisan db:seed --class=DemoScenarioSeeder`
- [ ] HTTPS (Certbot / SSL cert) aktif · header keamanan aktif · `/up` hijau
- [ ] Uji dari HP di jaringan berbeda

**Plan B (offline) untuk Final** — wajib ada (B-923): `docker compose` penuh (app + db) di laptop; skrip `start-demo.sh/.bat`; rekaman layar penuh.

---

## 11. Lingkungan Lokal

`compose.yaml`
```yaml
services:
  db:
    image: postgres:16
    environment:
      POSTGRES_DB: hakwarga
      POSTGRES_USER: hakwarga
      POSTGRES_PASSWORD: secret
    ports: ["5432:5432"]
    volumes: [pgdata:/var/lib/postgresql/data]
volumes:
  pgdata:
```
Setup:
```bash
docker compose up -d db          # atau PostgreSQL lokal
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
npm install && npm run dev       # terminal 1
php artisan serve                # terminal 2
```
Semua anggota memakai **PHP versi yang sama** (cek `php -v`) dan PostgreSQL 16.

---

## 12. CI/CD (GitHub Actions)

`.github/workflows/ci.yml`
```yaml
name: CI
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    services:
      postgres:
        image: postgres:16
        env: { POSTGRES_PASSWORD: secret, POSTGRES_DB: hakwarga_test }
        ports: ['5432:5432']
        options: >-
          --health-cmd="pg_isready" --health-interval=10s --health-timeout=5s --health-retries=5
    env:
      DB_CONNECTION: pgsql
      DB_HOST: 127.0.0.1
      DB_PORT: 5432
      DB_DATABASE: hakwarga_test
      DB_USERNAME: postgres
      DB_PASSWORD: secret
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with: { php-version: '8.3', extensions: pdo_pgsql, coverage: none }
      - run: composer install --no-interaction --prefer-dist
      - run: cp .env.example .env && php artisan key:generate
      - run: ./vendor/bin/pint --test
      - run: ./vendor/bin/phpstan analyse --memory-limit=1G
      - run: php artisan test
      - uses: actions/setup-node@v4
        with: { node-version: 22 }
      - run: npm ci && npm run build
```
(Naikkan versi *action* bila sudah ada rilis lebih baru.) Lighthouse CI dijalankan **terhadap URL staging** setelah deploy (B-801). Tes memakai PostgreSQL, **bukan SQLite**, karena view dan `percentile_cont`.

---

## 13. Keamanan HTTP, Cache & Performa

**Header (middleware `SecurityHeaders`):** `X-Content-Type-Options: nosniff` · `Referrer-Policy: strict-origin-when-cross-origin` · `Permissions-Policy` minimal · `frame-ancestors 'none'` · HSTS di produksi · CSP mulai **Report-Only** (izinkan `challenges.cloudflare.com` untuk Turnstile), perketat setelah halaman stabil.

**Tanpa simpan:** `/lapor/sukses`, `/tiket` (akses pelapor) memakai `Cache-Control: no-store`.

**Cache**
- Endpoint peta/scorecard: `Cache::remember` TTL 10 menit, kunci berversi (`hw:cache_version`), karena driver `database` tidak mendukung tag.
- Aset statis: fingerprint Vite + `Cache-Control: immutable`.
- GeoJSON: cache panjang + gzip/brotli.

**Performa frontend**
- Font di-host sendiri (woff2, subset latin), `font-display: swap`, preload font utama.
- Gambar WebP/AVIF, `width`/`height` eksplisit, `loading="lazy"` di bawah lipatan.
- JS `defer`; `map.js` hanya di `/peta`; hindari library besar tanpa alasan.
- Anggaran: JS landing ≤ 150 KB gzip, GeoJSON per level ≤ 1 MB gzip (`prd.md` §9).
