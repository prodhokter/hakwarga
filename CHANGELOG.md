# Changelog

Semua perubahan penting pada proyek **HakWarga** akan dicatat di berkas ini.
Format pencatatan mengacu pada [Keep a Changelog](https://keepachangelog.com/id/1.0.0/) dan menganut [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

> **INSTRUKSI UNTUK AI AGENT & KONTRIBUTOR:**
> Setiap kali melakukan perbaikan bug, penambahan fitur, pembaruan skema, atau perubahan kode/UI yang berdampak pada fungsionalitas sistem, **WAJIB memperbarui berkas CHANGELOG.md ini** pada bagian `[Unreleased]` atau versi terkait sebelum commit dinyatakan selesai.

---

## [Unreleased]

---

## [0.8.0] - 2026-10-30

### Added
- **Penerapan Logo Resmi Opsi A (Pillar of Rights) & Perbaikan Reaktivitas:**
  - Integrasi master logo Konsep A dan web icon kit ke `public/`: `logo-symbol.svg`, `favicon.ico`, `favicon.svg`, `apple-touch-icon.png`, `icon-192.png`, `icon-512.png`, dan `site.webmanifest`.
  - Pemasangan pustaka `alpinejs` ke `package.json` dan inisialisasi di `resources/js/app.js` untuk pemulihan seluruh interaktivitas reaktif (collapse sidebar desktop, mobile drawer, floating dock expand).
  - Penambahan aturan CSS `[x-cloak] { display: none !important; }` di `resources/css/app.css` untuk mencegah kebocoran elemen overlay tersembunyi pada saat inisialisasi peramban.
  - Perbaikan tuntas fungsi buka-tutup sidebar desktop via tombol toggle SVG panel dan sinkronisasi status ke `localStorage`.
  - Pembersihan total glitch teks `Data SimulasiDS` (Image #10) dan ikon silang ganda (Image #8).
  - Pemeliharaan penuh 48 Pest tests (305 assertions) 100% hijau, Pint format bersih, dan Larastan Level 5 bersih.

---

## [0.7.0] - 2026-10-30

### Added
- **Mobile Floating iOS Glass Dock & Navigasi Fleksibel:**
  - Pembuatan floating bottom dock navigasi khas iOS app dengan glassmorphism (`backdrop-blur-xl`, border tipis, bayangan mengambang halus).
  - 5 tombol navigasi: 4 fitur utama (Beranda, Lacak Resi, Peta Anomali, Lapor Pungli) dan 1 tombol expand tengah bertanda plus `(+)` menonjol.
  - Animasi rotasi tombol plus 45 derajat menjadi silang saat membuka modal/sheet overlay navigasi tambahan (Sanggah Bansos, Cek Tiket, Scorecard SLA, Data Publik, Metodologi).
  - Penghapusan total icon crosshatch/glitch (Image #8) dan penggantian dengan tombol toggle sidebar presisi manual SVG (Image #9).
  - Perlebaran sidebar desktop menjadi 288px (`md:w-72`) untuk proporsi yang lebih lapang dan elegan.
  - Penghapusan teks glitch `Data SimulasiDS` (Image #10).
  - Instalasi skill `logo-design-skill` dari GitHub (`kaankiziltug/logo-design-skill.git`) tanpa eksekusi generate logo terlebih dahulu.
  - Pemeliharaan 48 Pest tests (305 assertions) 100% hijau, Pint format bersih, dan Larastan Level 5 bersih.

---

## [0.6.0] - 2026-10-30

### Added
- **Pembersihan Total Pola AI Slop (Border Stripe Kiri & Dot Badges):**
  - Penghapusan seluruh border stripe berwarna pada sisi kiri kartu (`border-l-4`, `border-l-2`) di halaman Scorecard, Peta Anomali, dan seluruh tampilan sistem (mengacu Image #5, #6, #7).
  - Pembaruan aturan anti-slop resmi di `CLAUDE.md`, `AGENTS.md`, `DESIGN.md`, dan `docs/design.md` yang melarang keras penggunaan border stripe berwarna di sisi kiri kartu dan dot badge dekoratif.
  - Penghapusan footer secara menyeluruh (tanpa footer publik pada tata letak aplikasi).
  - Penghapusan tombol tautan `/admin` dari navigasi sidebar antarmuka pengguna publik.
  - Peningkatan fungsionalitas dan kepadatan informasi halaman Beranda (`/`) menjadi command center data mandiri (live anomaly preview, live SLA ranking, fast search resi).
  - Kepatuhan penuh pengujian 48 Pest tests (305 assertions) 100% hijau, Pint format bersih, dan Larastan Level 5 bersih.

---

## [0.5.0] - 2026-10-30

### Added
- **Pembaruan Layout & Navigasi:**
  - Penggantian topbar/navbar dengan sidebar yang dapat diciutkan (*collapsible sidebar*), mendukung mode kompak dan drawer mobile.
  - Penyederhanaan seluruh teks antarmuka menjadi frasa 1 hingga 2 kata yang padat, lugas, dan bebas basa-basi.
  - Pembuatan seluruh ikon secara manual berformat SVG murni tanpa dependensi eksternal.
  - Penetapan font **Plus Jakarta Sans** sebagai tipografi primer seluruh halaman.
  - Penyempurnaan footer minimalis dan terstruktur.
  - Penghapusan toggle tema (penguncian pada light theme yang bersih).
  - Penghapusan seluruh elemen badge ber-dot (Image #2), banner kuning simulasi (Image #3), dan blok logo H (Image #4).
  - Penambahan `robots.txt`, `sitemap.xml`, OpenGraph tags, Twitter cards, dan visual OG image mandiri (`public/og-image.svg`).
  - Pembersihan total em dash (`—`) dan pemeliharaan 48 Pest tests (100% hijau).

---

## [0.4.0] - 2026-10-30

### Added
- **Adopsi Penuh Starline Design System v2.4.0 (NeedMCP):**
  - **Identitas Visual Starline:** Aksen singular Luminous Lime-Yellow (`#e6ff94`) yang energik pada aksi utama, dipadukan dengan kanvas sejuk soft blue-gray (`#f0f4f8`), permukaan frosted glass 70% opacity dengan subtle backdrop-blur, serta secondary slate (`#64748b`).
  - **Tipografi Geist & Geist Mono:** Integrasi Google Fonts Geist (display & body) dengan Tight Display Rule (negative letter-spacing `-0.025em`) dan Geist Mono untuk angka tabular finansial, kode resi `HWR-`, dan kode tiket `HWT-`.
  - **Rombak Total Komponen UI:**
    - Navbar 60px frosted glass dengan Starline pill tabs (`rounded-full`) dan tombol aksi utama `btn-starline-primary`.
    - Kartu Starline Glass (`starline-card`): efek kaca buram translucent dengan hairline border tipis dan bayangan level 1 halus.
    - Input Starline (`input-starline`): rounded 0.75rem, backdrop-blur, dengan border halus dan ring fokus slate/lime.
    - Footer bertekstur translucent (`surface-deep`) dengan tipografi metadata rapi.
  - **Sinkronisasi Seluruh Halaman:**
    - Beranda (`/`): formulir pencarian resi Starline, kartu preview interaktif, dan kartu modul berselubung frosted glass.
    - Resi Tracker (`/lacak` & `/lacak/{receipt}`): kartu rincian hak, stepper vertikal, tombol salin, bagikan, dan cetak kartu hak.
    - Peta Anomali (`/peta`): kontrol segmented pill tabs, kontainer peta terintegrasi, dan kartu wilayah ber-accent Starline.
    - Lapor Pungli & Sanggah (`/lapor`, `/tiket`): wizard bertahap, kotak kredensial kode rahasia Starline lime, dan form pengaduan anonim.
    - Scorecard SLA (`/scorecard`, `/data`): papan peringkat tabel interaktif dengan baris detail expandable, grafik benchmark garis target 100%, dan kalkulator kebijakan interaktif.
  - **Kepatuhan Anti-Slop Mutlak:**
    - Zero AI cliches (tanpa sparkle palsu, tanpa gradien ungu/pink generik).
    - Zero em dash (`—`) pada seluruh teks UI antarmuka (100% lulus audit R-02).
  - **Pengujian & Validasi Kualitas:**
    - 48 Pest tests (305 assertions) 100% lolos.
    - Pint PSR-12 format bersih & Larastan level 5 bersih.

## [0.3.0] - 2026-10-30

### Added
- **Total Frontend Redesign & Enhanced Interactivity (Anti-Slop):**
  - **Hero Desktop 2-Kolom Beranda:** Kolom kiri interaktif dengan pencarian resi validasi format langsung; kolom kanan menampilkan pratinjau produk hidup (*live animated 5-stage timeline*) berputar otomatis dengan jeda saat hover/fokus.
  - **Peta Anomali Dua Arah (MapLibre GL JS):** FitBounds otomatis ke 5 kabupaten pilot Jawa Tengah, interaksi dua arah (klik poligon menyorot baris tabel/kartu dan sebaliknya), segmented control filter tersinkronisasi ke peta, kartu, tabel, dan donut chart.
  - **Lapor Pungli Multi-step Wizard:** Stepper 3 tahap interaktif, auto prefill nomor resi dari pelacak, penyimpanan draf di `sessionStorage`, dan indikator privasi 100% anonim.
  - **Keterbukaan Data Publik & Kalkulator Interaktif:** Pratinjau 5 baris pertama data dalam tabel, kamus kolom data lengkap, serta dua kalkulator rumus interaktif (Kalkulator Anomali & Kalkulator Kepatuhan SLA).
  - **Scorecard SLA Interaktif:** Garis target kepatuhan 100% putus-putus pada grafik benchmark Chart.js, filter tipe instansi, pengurutan kolom, dan baris detail expand transparan rumus skor.
  - **Design System & Dark Mode:** Palet warna deep teal berkarakter, fluid typography, angka tabular (`tabular-nums`), layered cards, dan tombol toggle mode gelap tersimpan di `localStorage`.
  - **Keamanan CSV:** Sanitasi pencegahan serangan CSV Formula Injection pada seluruh ekspor data publik.
  - **Audit & Kepatuhan Keamanan:** Laporan audit komprehensif 6 pilar di `docs/AUDIT.md` dan `docs/AUDIT-SECURITY.md`.
  - **Pengujian & Kualitas:** 48 Pest tests (305 assertions) 100% hijau, Pint PSR-12 bersih, Larastan Level 5 bersih, bebas em dash (`—`).

## [0.2.0] - 2026-10-30

### Added
- **Panel Admin Filament (`/admin`):**
  - Integrasi Filament Admin Panel Provider di `/admin` dengan dukungan autentikasi dan peran (`UserRole`: `SuperAdmin`, `Moderator`, `AgencyOfficer`).
  - Implementasi kontrak `FilamentUser` pada model `User`.
  - Resource `ShipmentResource`: pengelolaan log penyaluran resi, pembaruan status, dan penelusuran penerima ter-masking.
  - Resource `ReportResource`: moderasi aduan warga, penugasan ke instansi, input respon tindak lanjut, dan proteksi rahasia (`secret_hash` tidak pernah ditampilkan).
  - Akun demo resmi: `admin@hakwarga.test`, `moderator@hakwarga.test`, `petugas.bms@hakwarga.test` (password: `hakwarga2026`).
  - Pengujian Pest untuk alur autentikasi admin dan akses dashboard (47 tests, 303 assertions 100% lolos).
- **Modul D: Scorecard Kepatuhan SLA Instansi & Keterbukaan Data Publik (`/scorecard`, `/data`):**
  - Layanan `App\Services\SlaScoreService`: perhitungan skor komposit kepatuhan instansi berdasarkan target respon awal 72 jam (bobot 50%) dan batas penyelesaian 14 hari (bobot 50%).
  - Penentuan nilai mutu instansi (Grade A &ge; 85, Grade B &ge; 70, Grade C &ge; 55, Grade D &lt; 55) dengan syarat minimal 5 laporan jatuh tempo evaluasi.
  - Halaman papan peringkat Scorecard SLA (`/scorecard`): leaderboard instansi, filter wilayah/tipe instansi, dan rincian performa kecepatan tindak lanjut.
  - Halaman profil detail instansi (`/scorecard/{agency:slug}`): riwayat aduan terkait dan persentase keberhasilan SLA.
  - Halaman Keterbukaan Data Publik (`/data`): penjelasan metodologi dan rumus analisis matematis transparan.
  - Fitur ekspor dataset publik format CSV ber-stream (`/data/unduh/sla` dan `/data/unduh/anomali`).
  - Endpoint API publik `/api/v1/scorecard` berformat JSON.
  - Pengujian Pest 8 skenario pengujian baru (44 tests, 297 assertions 100% lolos).
- **Modul B: Peta Anomali & Deteksi Red-Flag (`/peta`, `/api/v1/map/choropleth`):**
  - View analitik PostgreSQL 16 `v_anomaly_scores` dengan CTE kalkulasi rasio penerima terhadap estimasi kemiskinan dan fungsi jendela `percentile_cont(0.5)`.
  - PHP Backed Enum: `AnomalyFlag` (`under_coverage`, `over_coverage`, `normal`).
  - Layanan `App\Services\AnomalyService`: klasifikasi rasio alokasi terhadap batas ambang dinamis (`config/hakwarga.php`) dan penentuan tingkat keparahan (severity).
  - Endpoint API Choropleth `/api/v1/map/choropleth` dengan caching GeoJSON berversi.
  - Halaman interaktif Peta Anomali (`/peta`) dengan strip metrik ringkasan (wilayah terpantau, potensi defisit, potensi surplus, alokasi normal).
  - Komponen aksesibel Tabel Red-Flag Wilayah (alternatif penuh yang ramah pembaca layar).
  - Dataset GeoJSON statis mandiri di `public/geo/central_java.geojson`.
  - Seeder data riil kemiskinan BPS dan kuota bansos untuk wilayah pilot Jawa Tengah (Banyumas, Cilacap, Purbalingga, Banjarnegara, Kebumen).
- **Modul C: Kanal Lapor Pungli, Sanggah Bansos & Tiket Rahasia (`/lapor`, `/tiket`):**
  - Migrasi database tabel `reports`, `report_updates`, dan `report_attachments` dengan proteksi integritas FK cascade.
  - PHP Backed Enums: `ReportType`, `ReportStatus`, `ExtortionCategory`, `DisputeCategory`.
  - Layanan `App\Services\TicketCodeFactory`: generator nomor tiket resmi `HWT-YYYY-XXXXXX` dan kode rahasia 12 karakter berpembanding `hash_equals` (sha256).
  - Layanan `App\Services\PiiMasker`: sensor otomatis 16-digit angka NIK (`[NIK DISAMARKAN]`) dan format nomor telepon Indonesia (`[NOMOR TELEPON DISAMARKAN]`) pada deskripsi aduan bebas.
  - Alur Lapor Pungli 100% anonim (`/lapor/pungli`) tanpa kolom identitas pelapor dan tanpa pencatatan IP/user-agent.
  - Alur Sanggah Kelayakan Bansos (`/lapor/sanggah`) dengan referensi program dan wilayah kelurahan/desa.
  - Halaman sukses tiket satu kali tampil (`/lapor/sukses`) dengan peringatan keamanan pencatatan kode rahasia.
  - Portal pelacakan tiket warga (`/tiket` & `/tiket/{ticket}`): tampilan status publik terlindungi dan sesi pelapor terverifikasi untuk membaca isi aduan serta mengirim tanggapan susulan.
  - Pengujian Pest 12 skenario pengujian baru (32 tests, 138 assertions 100% lolos).
- **Paket Tangkapan Layar Lengkap:**
  - `screenshot_peta_desktop_1440.png`, `screenshot_lapor_desktop_1440.png`, `screenshot_scorecard_desktop_1440.png`, `screenshot_admin_desktop_1440.png`.
  - Alur Sanggah Kelayakan Bansos (`/lapor/sanggah`) dengan referensi program dan wilayah kelurahan/desa.
  - Halaman sukses tiket satu kali tampil (`/lapor/sukses`) dengan peringatan keamanan pencatatan kode rahasia.
  - Portal pelacakan tiket warga (`/tiket` & `/tiket/{ticket}`): tampilan status publik terlindungi dan sesi pelapor terverifikasi untuk membaca isi aduan serta mengirim tanggapan susulan.
  - Pengujian Pest 12 skenario pengujian baru (32 tests, 138 assertions 100% lolos).

---

## [0.1.0] - 2026-10-30

### Added
- Inisialisasi repositori terisolasi mandiri untuk `hakwarga`.
- Konfigurasi toolchain lokal: Docker PostgreSQL 16 (`compose.yaml`), PHP 8.3 dengan ekstensi `pdo_pgsql`, `pgsql`, `openssl`, `mbstring`, `curl`.
- Scaffolding proyek: Laravel 12, Livewire 3, Tailwind CSS v4, Alpine.js, Pest 3, Larastan level 5, Pint.
- Migrasi database Phase 1 (10 tabel): `regions`, `poverty_stats`, `aid_programs`, `aid_allocations`, `agencies`, `beneficiaries`, `shipments`, `shipment_events`, `users`.
- PHP Backed Enums: `ShipmentStatus`, `EligibilityStatus`, `RegionLevel`, `AgencyType`, `UserRole`.
- Domain Services & Helpers:
  - `App\Support\Money`: format standar mata uang Rupiah (`Rp750.000`).
  - `App\Services\NikHasher`: enkripsi satu arah HMAC-SHA256 ber-pepper untuk NIK 16 digit sesuai amanat UU PDP No. 27/2022.
  - `App\Services\ReceiptCodeFactory`: generator & validator format nomor resi resmi `HWR-{PROGRAM}-{YYMM}-{6_CHAR}`.
  - `App\Services\ShipmentTrackingService`: pencarian resi teroptimasi dengan eager loading relasi.
- Seeder demo sintetis (`DemoScenarioSeeder`):
  - Wilayah pilot: Jawa Tengah -> Banyumas -> Patikraja -> Desa Kedungwringin.
  - Instansi: Dinsos Banyumas & PT Pos Indonesia Purwokerto.
  - 3 Resi Emas: `HWR-PKH-2610-DEMO01` (Dalam Pengiriman), `HWR-BPNT-2610-DEMO02` (Penjadwalan Sembako), `HWR-PKH-2610-DEMO03` (Diterima di Titik Salur).
  - Perintah artisan `php artisan hw:demo-reset` untuk reset bersih data demo (diproteksi di production).
- Antarmuka Publik Anti-Slop (Dial `ENERGY 1 / RHYTHM 1 / MOTION 1`):
  - Banner sticky permanen: "DATA SIMULASI: Situs dalam tahap evaluasi MIA 2026."
  - Layout responsif dengan skip-to-content link, target sentuh ≥ 44px, dan focus-visible ring.
  - Landing page (`/`): hero hak bansos, form pencarian resi instan, pintasan 3 resi demo, 3 langkah kawal bansos, dan kartu pratinjau modul.
  - Resi Tracker (`/lacak` & `/lacak/{receipt}`): rate limiter 10 req/menit, kartu rincian hak warga (tunai & komoditas sembako), linimasa vertikal 5 tahap penyaluran, jaminan perlindungan NIK, tombol pelaporan kejanggalan.
  - Halaman edukasi & privasi (`/tentang`) dan placeholder roadmap (`/peta`, `/lapor`, `/scorecard`).
  - Berkas tangkapan layar resolusi tinggi di `docs/img/m1/` (Desktop 1440px & Mobile 390px).
- Pengujian & Jaminan Kualitas:
  - 20 Pest tests (90 assertions) 100% lolos (fungsional, rate limiter, routing, dan zero NIK leakage test).
  - Verifikasi Larastan level 5: 0 error.
  - Verifikasi Pint PSR-12: 0 pelanggaran format.
  - Verifikasi Antislop R-02: 0 em dash (`—`) pada teks antarmuka publik.
