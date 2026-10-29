# Design — Design System, Wireframe & Aksesibilitas

> Pemilik: D (Designer) · Pelaksana kode: F (Frontend). Terkait: `prd.md` · `structure.md`
> Kontras & ukuran di dokumen ini adalah **target**. Verifikasi dengan alat (axe, WebAIM Contrast Checker) — jangan hanya percaya angka di sini.

---

## 1. Prinsip Desain & Standar Anti-Slop

> **PENTING UNTUK SEMUA AI & BUILDER:** Setiap pengerjaan UI/Frontend **wajib memanggil dan mematuhi skill `antislop`** (`antislop`, `antislop-ui`, `antislop-copywriting`, `antislop-human`, `antislop-layoutmobile`). 

1. **Anti-Slop AI (Zero AI Cliché):**
   - **Haram:** sparkle/bintang berkilau (`✨`), gradien ungu/pink khas template AI, border glow neon berlebih, kartu bertumpuk mengambang tanpa fungsi (*glassmorphism* berat), dan metrik palsu seperti "99.9% Kepuasan".
   - **Copywriting Otentik:** Gunakan Bahasa Indonesia yang lugas, natural, dan membumi. Dilarang memakai jargon robotik AI ("Merevolusi masa depan bantuan sosial", "Solusi mutakhir terintegrasi", "Selamat datang di era baru").
2. **Tepercaya & tenang** — ini soal hak dan uang warga; hindari kesan "startup berisik" atau "crypto/web3 landing".
3. **Jelas sebelum cantik** — satu tujuan per halaman, bahasa sehari-hari.
4. **Mobile-first, hemat data** — pengguna utama memakai HP kelas menengah dan kuota terbatas.
5. **Aksesibel bawaan** — WCAG 2.1 AA, bukan tambahan di akhir.
6. **Jujur soal data** — label SIMULASI, rumus terlihat, ketidakpastian dinyatakan.
7. **Tidak menuduh** — bahasa indikator ("perlu ditelaah"), bukan vonis.

---

## 2. Token (Tailwind v4 `@theme` di `resources/css/app.css`)

```css
@theme {
  /* Merek */
  --color-brand-50:  #f0fdfa;
  --color-brand-100: #ccfbf1;
  --color-brand-500: #14b8a6;
  --color-brand-600: #0d9488;
  --color-brand-700: #0f766e;   /* tombol, tautan (teks putih di atasnya) */
  --color-brand-800: #115e59;
  --color-brand-900: #134e4a;

  /* Netral */
  --color-ink:       #0f172a;   /* teks utama */
  --color-ink-muted: #475569;   /* teks sekunder */
  --color-line:      #e2e8f0;
  --color-surface:   #ffffff;
  --color-canvas:    #f8fafc;

  /* Status */
  --color-info:    #1d4ed8;
  --color-success: #15803d;
  --color-warning: #b45309;
  --color-danger:  #b91c1c;

  /* Peta/anomali (tidak mengandalkan warna saja: selalu ada ikon + label) */
  --color-flag-under: #c2410c;  /* oranye */
  --color-flag-over:  #4338ca;  /* indigo */
  --color-flag-ok:    #94a3b8;

  /* Banner simulasi */
  --color-sim-bg: #fef3c7;
  --color-sim-fg: #78350f;

  --font-sans:    "Inter", ui-sans-serif, system-ui, sans-serif;
  --font-display: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;

  --radius-card: 0.75rem;
  --radius-control: 0.5rem;
}
```
Opsional dark mode ditunda (Icebox).

**Skala peta (divergen):** oranye ← abu netral → indigo, ditambah pola arsir untuk red-flag tinggi agar terbaca bagi buta warna.

---

## 3. Tipografi

| Peran | Font | Ukuran/leading |
|---|---|---|
| H1 | Plus Jakarta Sans 700 | 36–48 / 1.15 |
| H2 | Plus Jakarta Sans 700 | 28–30 / 1.2 |
| H3 | Plus Jakarta Sans 600 | 20–24 / 1.3 |
| Body | Inter 400 | **16–18** / 1.6 |
| Caption | Inter 400 | 14 / 1.5 |

- Self-host woff2 subset latin, `font-display: swap`, preload font body.
- Panjang baris 60–75 karakter. Hindari teks rata kanan-kiri (justify).
- Periksa lisensi font (OFL untuk keduanya) dan catat di `database/data/SOURCES.md` atau `docs/ATTRIBUTION.md`.

---

## 4. Komponen

| Komponen | Status wajib | Catatan aksesibilitas |
|---|---|---|
| Button (primer/sekunder/bahaya/ghost) | default · hover · focus · active · disabled · loading | Fokus terlihat (ring ≥ 2 px), target ≥ 44 px |
| Input / Select / Textarea | default · fokus · galat · disabled | `<label>` terlihat, galat via `aria-describedby`, `autocomplete` benar |
| Receipt input | + contoh resi, tombol "Pakai resi demo" | Normalisasi huruf besar & spasi |
| Badge status | 5 status penyaluran, 6 status laporan | Ikon + teks, bukan warna saja |
| Flag badge | under · over · normal · tinggi | Ikon + label; legend |
| Card, Stat | – | Heading hierarki benar |
| Timeline vertikal | selesai · saat ini · menunggu | `<ol>`, `aria-current="step"`, waktu dalam `<time>` |
| Stepper (wizard) | langkah n dari N | `aria-live` untuk perubahan langkah |
| Table | sortir, kosong, memuat | `<caption>`, `scope`, sortir lewat tombol |
| Alert | info · sukses · peringatan · galat | `role="status"` / `role="alert"` |
| Ticket card | kode tiket + kode rahasia | Tombol salin dengan umpan balik terbaca pembaca layar; tombol cetak |
| Simulated banner | selalu ada di halaman data | Tidak dapat ditutup |
| Skip link | – | Muncul saat fokus, melompat ke `<main>` |
| Peta + legenda | – | Alternatif tabel; fokus keyboard; label wilayah terpilih diumumkan |

Tiap komponen dibuat di Figma (varian lengkap) **sebelum** di-slicing.

---

## 5. Wireframe per Halaman (struktur & urutan)

### 5.1 Landing `/`
1. Header: logo · Lacak · Peta · Lapor · Scorecard · Data · (menu burger di HP)
2. Banner SIMULASI
3. **Hero**: H1 *"Pastikan bantuan sampai utuh ke tangan Anda"* · input resi (besar) · tautan "Coba resi demo" · tombol sekunder *Laporkan pungutan*
4. Strip angka: wilayah dipantau · resi dilacak · laporan ditindaklanjuti · median waktu respon *(berlabel simulasi)*
5. Cara kerja (3 langkah)
6. 4 kartu modul (ikon + 1 kalimat + tautan)
7. Pratinjau peta (gambar statis ringan → tombol *Buka peta*)
8. Blok kepercayaan: privasi, metodologi, sumber data
9. CTA akhir + Footer (tautan, kontak, atribusi data)

### 5.2 Tracker `/lacak/{resi}`
1. Form resi (tetap tampil di atas)
2. Kartu ringkasan: program · periode · badge status · instansi
3. **Timeline** 5 tahap (waktu + instansi)
4. **Rincian Hak**: tabel (tunai, barang, total) + catatan "Hak ini menurut program; bila yang Anda terima berbeda…"
5. Titik salur & jadwal
6. CTA *Ada yang tidak sesuai?* → `/lapor/pungli`
7. Catatan privasi (nama disamarkan, NIK tidak ditampilkan)

### 5.3 Peta `/peta`
- **Toolbar:** program · periode · lapisan (Rasio Sasaran / Kemiskinan / Kuota / Red Flag) · tombol *Lihat sebagai tabel*
- **Desktop:** peta (±70%) + panel detail kanan · **HP:** peta di atas, detail sebagai *bottom sheet*
- **Panel detail:** nama wilayah · metrik · badge flag + penjelasan rumus · grafik batang vs median · jumlah laporan · tautan ke scorecard instansi
- **Legenda** + disclaimer "Indikator untuk ditelaah, bukan putusan pelanggaran" + banner SIMULASI
- **Tab Tabel Red-Flag** (sortir) = padanan aksesibel

### 5.4 Lapor `/lapor`
1. Pilih jenis: dua kartu besar *Laporkan Pungutan* · *Sanggah Data Penerima*
2. Wizard: Jenis → Lokasi → Instansi (opsional) → Kronologi → Bukti (opsional) → Tinjau → Kirim
3. Kotak peringatan: *"Jangan tulis NIK, nomor telepon, atau identitas Anda"* + disclaimer anonimitas jujur
4. **Halaman sukses:** kode tiket + kode rahasia (besar, mono) · *Simpan sekarang — kode rahasia tidak akan ditampilkan lagi* · salin · cetak · tautan ke `/tiket`

### 5.5 Tiket `/tiket`
Form (kode tiket + kode rahasia) → tampilan publik: timeline status, instansi, tanggal; tampilan pelapor: balasan petugas + form tambahan keterangan.

### 5.6 Scorecard `/scorecard`
Filter (level, wilayah) · tabel peringkat (nama, skor + batang, % respon ≤ 72 jam, % selesai ≤ 14 hari, laporan) · "Belum cukup data" untuk < 5 laporan · tautan metodologi · ekspor CSV. Detail: tren bulanan + distribusi status.

### 5.7 Data `/data` & Tentang `/tentang`
Metodologi (rumus), sumber & lisensi, unduhan, privasi, FAQ.

---

## 6. Microcopy & Nada

- Bahasa Indonesia sehari-hari, kalimat pendek, **hindari jargon** ("resi bantuan", bukan "tracking ID").
- Menghormati dan menenangkan; jangan menyalahkan pengguna.
- Galat memberi solusi: *"Resi tidak ditemukan. Periksa kembali huruf dan angkanya. Contoh: HWR-PKH-2610-7K3M9Q."*
- Indikator: *"perlu ditelaah"*, *"kemungkinan"*; **jangan** *"korup"*, *"terbukti"*.
- Angka dalam format Indonesia: `Rp1.250.000`, tanggal `1 November 2026`.

---

## 7. Responsif

| Breakpoint uji | Catatan |
|---|---|
| 360 px | Target minimum; tidak ada scroll horizontal |
| 390 px | Ponsel umum |
| 768 px | Tablet; peta + panel mulai berdampingan bila muat |
| 1024 px | Layout 2 kolom penuh |
| 1440 px | Lebar maksimum konten ±1200 px |

Tabel lebar → kartu bertumpuk di HP atau scroll horizontal terkontrol dengan `<caption>` tetap.

---

## 8. Gerak (Motion)

Ringan dan bermakna: transisi 150–250 ms, animasi garis timeline saat memuat, fade panel. Hormati `prefers-reduced-motion` (matikan animasi non-esensial).

---

## 9. Checklist Aksesibilitas (wajib sebelum M2)

- [ ] `<html lang="id">`, judul halaman unik, satu `<h1>` per halaman, hierarki heading berurutan
- [ ] Landmark: `header` `nav` `main` `footer`; skip link
- [ ] Seluruh fungsi dapat dipakai **hanya dengan keyboard**; urutan fokus logis; tidak ada jebakan fokus
- [ ] Indikator fokus selalu terlihat
- [ ] Kontras teks ≥ 4,5:1 (teks besar ≥ 3:1); komponen UI ≥ 3:1
- [ ] Informasi tidak bergantung pada warna saja (ikon + label + pola)
- [ ] Gambar bermakna punya `alt`; dekoratif `alt=""`
- [ ] Formulir: label, petunjuk, galat terhubung (`aria-describedby`), `autocomplete`
- [ ] Pembaruan dinamis diumumkan (`aria-live`) — status resi, hasil kirim, wizard
- [ ] Peta punya alternatif tabel yang setara
- [ ] Zoom 200% tanpa kehilangan fungsi; reflow di 320 px
- [ ] `prefers-reduced-motion` dihormati
- [ ] Diuji dengan **axe DevTools**, **Lighthouse**, dan pembaca layar (NVDA atau VoiceOver/TalkBack) pada alur utama

---

## 10. Figma

**Struktur file:** `0 Cover` · `1 Foundations` (token, tipografi, ikon) · `2 Components` · `3 Wireframes (low-fi)` · `4 Mockups Desktop (1440)` · `5 Mockups Mobile (390)` · `6 Prototype` · `7 Export (PDF/Deck)`.

**Konvensi:** nama frame `Halaman/Keadaan/Perangkat` (mis. `Tracker/Hasil/Mobile`) · Auto Layout · Variables untuk warna & spasi (nama selaras token §2) · komponen punya varian status.

**Serah-terima D → F:** tautan frame + catatan interaksi + aset (SVG ikon, WebP gambar) + daftar komponen baru. F membuat komponen Blade, D meninjau hasil di browser sebelum PR digabung (cek pixel & aksesibilitas).

**Ekspor untuk PDF/Deck:** frame 1440 dan 390 sebagai PNG @2x → kompres (TinyPNG/Squoosh) → cek ukuran PDF < 10 MB (draft).
