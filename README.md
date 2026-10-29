# HakWarga

**Platform transparansi bantuan sosial & penegakan hak publik:** lacak resi penyaluran, telaah anomali alokasi di peta, laporkan pungli secara anonim, dan pantau kecepatan respon instansi.
Karya tim **`<NamaTim>`** untuk *Multimedia In Action (MIA) 2026 — Web In Action*. Tema: *Designing Digital Futures – Powering Public Transparency* · Subtema: *Public Service Tracking* & *Data-Driven Decision Support*.

> ⚠️ **Semua data penerima, penyaluran, dan laporan dalam repo ini adalah SIMULASI** untuk demonstrasi. Data kemiskinan dan batas wilayah bersumber dari data publik (lihat `database/data/SOURCES.md`).

🌐 Domain produksi: `https://hakwarga.web.id` · 📄 Dokumentasi: folder [`docs/`](docs/)

---

## Tech Stack & Infrastruktur Mandiri

| Lapisan | Teknologi |
|---|---|
| Backend & Frontend | **Laravel 13** (PHP 8.3+), Blade, Livewire, Alpine.js |
| Styling & UI | Tailwind CSS 4, Vite · **Anti-Slop Standard** |
| Database | **PostgreSQL 16** (Self-hosted) |
| Peta & Grafik | MapLibre GL JS (GeoJSON offline statis), Chart.js |
| Admin | Filament 5 |
| Infrastruktur | **Self-Hosted VPS** (Ubuntu LTS + Nginx/Docker Compose), zero PaaS lock-in |
| Kualitas | Pest, Pint, Larastan, GitHub Actions |
| Anti-bot | Cloudflare Turnstile / Honeypot + Rate Limiter |

---

## Fitur & Status Progres

*Terakhir diperbarui: **30 Okt 2026** — Seluruh perencanaan development dimajukan hari ini.*

| Modul | Status | Keterangan |
|---|---|---|
| Landing page | ✅ Jadi | Selesai (Anti-slop, responsif, banner simulasi) |
| Resi Tracker (`/lacak`) | ✅ Jadi | Selesai (Linimasa 5 tahap & rincian hak warga) |
| Lapor Pungli & Sanggah + Tiket (`/lapor`, `/tiket`) | 🟡 Proses | Dimajukan hari ini: wizard lapor & tiket rahasia |
| Peta Anomali (`/peta`) | 🟡 Proses | Dimajukan hari ini: GeoJSON lokal & deteksi red-flag |
| Scorecard SLA (`/scorecard`) | 🟡 Proses | Dimajukan hari ini: kepatuhan respon 72 jam & 14 hari |
| Panel Admin (`/admin`) | 🟡 Proses | Dimajukan hari ini: Filament 5 moderasi & audit |

Legenda: ✅ Jadi · 🟡 Sedang dikembangkan hari ini · ⬜ Belum

**Roadmap:** Seluruh development dipercepat dieksekusi hari ini (30 Okt 2026). Detail di [`docs/todos.md`](docs/todos.md).

---

## Cara Menjalankan

**Prasyarat:** PHP 8.3+, Composer, Node.js 22+, PostgreSQL 16 (atau Docker).

```bash
# 1) Clone
git clone https://github.com/<org>/hakwarga.git
cd hakwarga

# 2) Install
composer install
npm install
cp .env.example .env
php artisan key:generate

# 3) Database (PostgreSQL via Docker; lewati bila sudah punya PostgreSQL lokal)
docker compose up -d db
#   Pastikan DB_* di .env sesuai (default .env.example cocok dengan compose.yaml)

# 4) Migrasi + data simulasi
php artisan migrate --seed

# 5) Run (dua terminal)
npm run dev
php artisan serve
```
Buka <http://127.0.0.1:8000>.

### Kode demo
| Untuk | Kode |
|---|---|
| Lacak resi (sedang dikirim) | `HWR-PKH-2610-DEMO01` |
| Lacak resi (dijadwalkan) | `HWR-BPNT-2610-DEMO02` |
| Lacak resi (sudah diterima) | `HWR-PKH-2610-DEMO03` |
| Tiket laporan demo | `HWT-2026-DEMO01` (kode rahasia: lihat `database/seeders/DemoScenarioSeeder.php`) |
| Admin (`/admin`) | `admin@hakwarga.test` · sandi dari `HW_DEMO_PASSWORD` di `.env` |

### Perintah berguna
```bash
php artisan test                  # tes (butuh PostgreSQL)
./vendor/bin/pint                 # format kode
./vendor/bin/phpstan analyse      # analisis statis
php artisan hw:demo-reset         # reset data demo (hanya non-produksi)
```

---

## Struktur Singkat

```
app/            Actions · Services · Models · Livewire · Filament
database/       migrations · seeders · data (CSV sumber)
resources/      views (Blade) · css · js
public/geo/     GeoJSON batas wilayah (disederhanakan)
docs/           PRD, arsitektur, database, desain, backlog, todos
```
Rincian: [`docs/structure.md`](docs/structure.md).

---

## Dokumentasi
[`docs/prd.md`](docs/prd.md) · [`docs/context.md`](docs/context.md) · [`docs/structure.md`](docs/structure.md) · [`docs/database.md`](docs/database.md) · [`docs/design.md`](docs/design.md) · [`docs/submission.md`](docs/submission.md) · [`docs/backlog.md`](docs/backlog.md) · [`docs/todos.md`](docs/todos.md) · [`AGENTS.md`](AGENTS.md)

## Privasi & Etika (ringkas)
NIK tidak pernah disimpan mentah (hanya hash ber-pepper) · pelapor tidak diminta identitas · aplikasi tidak menyimpan IP · isi laporan tidak ditampilkan publik · anomali adalah **indikator untuk ditelaah**, bukan putusan pelanggaran. Detail: [`docs/prd.md`](docs/prd.md) §7.

## Tim
| Peran | Nama |
|---|---|
| Ketua · Project Manager & Backend Lead | `<Nama>` |
| Frontend Lead & Web Performance | `<Nama>` |
| UI/UX Designer, Data Specialist & Presenter | `<Nama>` |

## Lisensi & Atribusi
Kode: `<pilih lisensi, mis. MIT>` · Data & aset pihak ketiga: lihat `database/data/SOURCES.md` dan `docs/ATTRIBUTION.md`.
