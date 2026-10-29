# PRD — HakWarga (hakwarga.web.id)

> Product Requirements Document · v0.2 · 30 Okt 2026
> Pemilik: Ketua Tim (PM) · Terkait: `context.md` · `database.md` · `structure.md` · `design.md` · `backlog.md`

---

## 1. Ringkasan

**HakWarga** (`hakwarga.web.id`) adalah platform web transparansi bantuan sosial dan pemenuhan hak publik. Warga dapat **melacak** penyaluran bantuan dengan resi unik, **menelaah** anomali alokasi di peta interaktif, **melaporkan** pungli dan menyanggah data penerima secara anonim, serta melihat **scorecard** kecepatan respon instansi.

> Tagline: *Bansos adalah hak warga. Pastikan sampai utuh tanpa potongan.*

| Item | Nilai |
|---|---|
| Domain | `https://hakwarga.web.id` |
| Kompetisi | Multimedia In Action (MIA) 2026, cabang Web In Action (WIA) |
| Tema | Designing Digital Futures – Powering Public Transparency |
| Subtema | **Public Service Tracking** + **Data-Driven Decision Support** |
| Platform | Web responsif (mobile-first), Laravel full-stack (Self-Hosted VPS) |

---

## 2. Masalah

| # | Masalah | Dampak |
|---|---|---|
| 1 | Penerima tidak tahu persis nominal/jenis haknya (asimetri informasi) | Celah pemotongan ilegal (pungli) |
| 2 | Data salah sasaran dan penerima ganda tanpa jalur koreksi publik | Warga yang berhak terlewat |
| 3 | Tidak ada pelacakan status penyaluran yang bisa diakses warga | Bantuan tertahan tanpa diketahui |
| 4 | Kanal aduan tidak spesifik bansos dan kinerja respon instansi tidak terukur | Tidak ada tekanan akuntabilitas |

> **Aturan konten:** setiap angka di latar belakang masalah wajib punya rujukan resmi (BPS, Kemensos, BPK, KPK, ICW, dll.) dan dicatat di `context.md` §8. Jangan menulis statistik tanpa sumber.

### Diferensiasi

| Pembanding | Fokus mereka | Yang ditambahkan HakWarga |
|---|---|---|
| Cek Bansos Kemensos | Mengecek status kepesertaan | Pelacakan distribusi per resi, rincian hak, deteksi anomali alokasi, pelaporan, scorecard |
| LAPOR! (SP4N-LAPOR!) | Kanal aduan layanan publik umum | Khusus bansos & hak warga, anonim, tiket publik, SLA instansi yang diperingkat terbuka |

*Deskripsi pembanding berdasarkan pengetahuan umum. **Verifikasi fitur terkini** di situs masing-masing sebelum dikutip di proposal.*

---

## 3. Tujuan & Metrik

### 3.1 Tujuan produk
1. Warga mengetahui status dan hak bantuan dalam ≤ 30 detik dari landing page.
2. Anomali alokasi antarwilayah terlihat dalam satu layar (peta + tabel).
3. Warga bisa melapor tanpa identitas dan memantau tindak lanjutnya.
4. Kinerja respon instansi terukur dan terbuka untuk publik.

### 3.2 Metrik keberhasilan

| Metrik | Target | Cara ukur |
|---|---|---|
| Landing → status resi | ≤ 30 detik (pengguna baru) | Uji 5 orang (B-804) |
| Lighthouse mobile, halaman inti | Perf ≥ 90 · A11y ≥ 95 · Best Practices ≥ 90 · SEO ≥ 90 | Lighthouse CI |
| Modul berfungsi end-to-end | 4 dari 4 | Skrip demo |
| Pelanggaran aksesibilitas kritis | 0 (axe DevTools), WCAG 2.1 AA | Audit B-802 |
| Tes otomatis | 100% lulus di CI | GitHub Actions |

---

## 4. Persona

| Persona | Konteks | Kebutuhan utama |
|---|---|---|
| **Ibu Sari**, 42, penerima PKH di desa | Android kelas menengah, kuota data terbatas, baca tulis dasar | Cek status dan hak dengan resi; bahasa sederhana; halaman ringan |
| **Pak Dedi**, ketua RT / relawan pengawas | Mengenal warga sekitar | Lihat kondisi wilayah di peta; sanggah data yang tidak layak; lapor tanpa risiko intimidasi |
| **Rina**, jurnalis data / analis kebijakan | Butuh bukti dan metodologi | Peta anomali, scorecard, metodologi transparan, unduh data |
| **Bu Lestari**, staf dinas sosial | Menindaklanjuti laporan | Panel untuk memperbarui status penyaluran dan membalas tiket |

---

## 5. Cakupan

### 5.1 Termasuk (In scope)
- 4 modul publik: Resi Tracker, Peta Anomali, Lapor (pungli + sanggah) dengan Tiket, Scorecard SLA.
- Halaman pendukung: Landing, Data & Metodologi, Tentang & Privasi.
- Panel admin instansi/moderator (Filament) mulai Milestone 2.
- Data demo: **kemiskinan & wilayah = riil**, **data penerima/penyaluran/laporan = sintetis berlabel "SIMULASI"**.

### 5.2 Tidak termasuk (Out of scope)
- Integrasi API resmi Kemensos/Dukcapil, verifikasi NIK ke sumber resmi.
- Aplikasi mobile native, notifikasi WhatsApp, chat real-time.
- Prediksi machine learning (indikator anomali berbasis aturan sederhana saja).
- Pencarian penerima berdasarkan NIK secara publik (lihat §7 Privasi).

---

## 6. Kebutuhan Fungsional

Prioritas: **M** = Must · **S** = Should · **C** = Could. Milestone: M1 (1 Nov) · M2 (11 Nov) · M3 (28 Nov).

### 6.1 Modul A — Resi Tracker (`/lacak`)

| ID | Kebutuhan | Prio | MS |
|---|---|---|---|
| TRK-01 | Input resi di landing dan `/lacak`; format divalidasi dengan pesan galat jelas | M | M1 |
| TRK-02 | Timeline 5 tahap: Pendataan → Verifikasi Kelayakan → Penjadwalan → Dalam Pengiriman → Diterima di Titik Salur, lengkap waktu dan instansi | M | M1 |
| TRK-03 | **Rincian Hak Penerima**: tunai, nilai barang, deskripsi barang, total | M | M1 |
| TRK-04 | Titik salur dan periode penyaluran | M | M1 |
| TRK-05 | Identitas tersamar: nama inisial, **tidak menampilkan NIK** | M | M1 |
| TRK-06 | Resi tidak ditemukan → pesan generik; throttle 10 permintaan/menit | M | M1 |
| TRK-07 | Tombol "Ada yang tidak sesuai?" → `/lapor/pungli` dengan konteks (program, wilayah, instansi, periode) terisi, **tanpa membawa resi/identitas** | S | M2 |
| TRK-08 | Konfirmasi penerimaan nominal oleh penerima (bandingkan hak vs diterima) | C | M3 |
| TRK-09 | Stylesheet cetak "Kartu Hak" | C | M3 |

**Kriteria penerimaan inti:** memasukkan `HWR-PKH-2610-DEMO01` menampilkan timeline, rincian hak, dan label "Data Simulasi" tanpa NIK.

### 6.2 Modul B — Peta Demografi & Anomali (`/peta`)

| ID | Kebutuhan | Prio | MS |
|---|---|---|---|
| MAP-01 | Peta choropleth provinsi → kab/kota (drill-down saat klik) | M | M2 |
| MAP-02 | Pilihan lapisan: Rasio Sasaran, Tingkat Kemiskinan, Kuota, Red Flag | M | M2 |
| MAP-03 | Filter program dan periode | M | M2 |
| MAP-04 | Panel detail wilayah: metrik, flag + penjelasan rumus, perbandingan dengan median, jumlah laporan (agregat) | M | M2 |
| MAP-05 | **Tabel red-flag** yang dapat diurutkan sebagai alternatif aksesibel peta | M | M2 |
| MAP-06 | Legenda + disclaimer: "indikator untuk ditelaah, bukan putusan pelanggaran" | M | M2 |
| MAP-07 | Daftar penerima tersamar per desa untuk uji publik | S | M2 |
| MAP-08 | Pilih wilayah lewat keyboard / dropdown (tanpa perlu mouse) | M | M2 |

### 6.3 Modul C — Lapor & Tiket (`/lapor`, `/tiket`)

| ID | Kebutuhan | Prio | MS |
|---|---|---|---|
| RPT-01 | Form pungli bertahap: jenis → lokasi → instansi (opsional) → kronologi → nominal (opsional) → bukti (opsional) | M | M2 |
| RPT-02 | Form sanggah: wilayah → pilih penerima tersamar → alasan → penjelasan → bukti | M | M2 |
| RPT-03 | Hasilkan **kode tiket** (`HWT-2026-XXXXXX`) dan **kode rahasia** (`XXXX-XXXX-XXXX`), ditampilkan sekali, ada tombol salin/cetak | M | M2 |
| RPT-04 | `/tiket/{kode}`: status publik berupa timeline, **tanpa isi laporan** | M | M2 |
| RPT-05 | Pelapor memasukkan kode tiket + kode rahasia untuk melihat balasan dan menambah keterangan | M | M2 |
| RPT-06 | Bukti: JPG/PNG/PDF, maks 3 berkas × 5 MB, EXIF dibersihkan, disimpan privat | S | M2 |
| RPT-07 | Turnstile + throttle + honeypot | M | M2 |
| RPT-08 | Deteksi pola NIK (16 digit) dan nomor telepon pada teks bebas → otomatis disamarkan + peringatan | M | M2 |
| RPT-09 | Disclaimer anonimitas yang jujur (lihat §7) | M | M2 |

### 6.4 Modul D — SLA & Scorecard (`/scorecard`)

| ID | Kebutuhan | Prio | MS |
|---|---|---|---|
| SLA-01 | Peringkat instansi berdasarkan skor SLA, filter level/wilayah | M | M2 |
| SLA-02 | Metrik: laporan masuk, % direspon ≤ 72 jam, % selesai ≤ 14 hari, median waktu respon | M | M2 |
| SLA-03 | Minimal 5 laporan jatuh tempo agar masuk peringkat; selain itu "Belum cukup data" | M | M2 |
| SLA-04 | Detail instansi: tren bulanan + distribusi status | S | M2 |
| SLA-05 | Halaman metodologi skor yang transparan (`/data`) | M | M2 |
| SLA-06 | Ekspor CSV | S | M2 |

### 6.5 Admin & Umum

| ID | Kebutuhan | Prio | MS |
|---|---|---|---|
| ADM-01 | Login admin (Filament) dengan peran: `super_admin`, `moderator`, `agency_officer` | M | M2 |
| ADM-02 | Petugas instansi memperbarui status penyaluran (menambah `shipment_events`) | M | M2 |
| ADM-03 | Menanggapi tiket: ubah status, pesan publik/internal; `first_response_at` terisi otomatis saat tanggapan staf pertama | M | M2 |
| ADM-04 | Moderator memverifikasi atau menolak laporan | M | M2 |
| ADM-05 | Petugas hanya melihat data instansinya (Policy) | S | M2 |
| GEN-01 | Landing: hero + cari resi, statistik, cara kerja, 4 modul, CTA lapor | M | M1 |
| GEN-02 | Banner "DATA SIMULASI" di seluruh halaman demo | M | M1 |
| GEN-03 | `/data`: sumber data, rumus, lisensi, unduhan | M | M2 |
| GEN-04 | `/tentang`: misi, privasi, FAQ | S | M2 |

---

## 7. Privasi, Hukum & Etika

**Dasar rujukan** (verifikasi pasal sebelum dikutip): UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi; UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.

| Prinsip | Implementasi |
|---|---|
| Minimisasi data | Pelapor tidak diminta nama, kontak, atau NIK |
| NIK tidak pernah mentah | Disimpan sebagai `HMAC-SHA256(nik, pepper)`; tidak pernah ditampilkan |
| Tracker tanpa pencarian NIK | Hanya via resi acak, agar orang lain tidak bisa mengintip status warga. **Ini mengubah draf awal** yang mengizinkan pencarian NIK tersamar |
| Nama tersamar | Tampil sebagai inisial ("S*** W***") |
| Laporan tidak membawa resi | Konteks program/wilayah/instansi saja, agar pelapor tidak teridentifikasi |
| Isi laporan tidak publik | Publik hanya melihat kategori, wilayah, instansi, status |
| Tanpa penyebutan oknum di publik | Moderator menyunting; nama individu tidak ditampilkan |
| IP tidak disimpan aplikasi | Hanya throttle sementara di cache dengan kunci ter-hash |
| **Anonimitas tidak absolut** | Halaman lapor menyatakan: aplikasi tidak menyimpan IP, namun penyedia hosting/jaringan dapat memiliki log sendiri |
| Data demo ≠ temuan nyata | Anomali dari data sintetis **dilabeli SIMULASI** agar tidak terbaca sebagai tuduhan ke wilayah/instansi nyata |
| Bahasa indikator | "Perlu ditelaah", bukan "terbukti menyimpang" |

---

## 8. Aturan Bisnis

### 8.1 Indikator anomali (Red Flag)

```
poor_estimate   = poor_population (BPS)  ATAU  population × poverty_percent / 100
targeting_ratio = quota_recipients ÷ poor_estimate
relative_ratio  = targeting_ratio wilayah ÷ median targeting_ratio (level, program, periode sama)

relative_ratio < 0.5  → under_coverage  (kemungkinan warga miskin terlewat)
relative_ratio > 1.5  → over_coverage   (kemungkinan kuota berlebih / salah sasaran)
selain itu           → normal
severity high         : relative_ratio < 0.3 atau > 2.0
```
Ambang disimpan di `config/hakwarga.php`. **Catatan:** kuota bansos mencakup kelompok rentan/hampir miskin sehingga rasio > 1 bisa sah. Flag hanyalah penapis awal.

### 8.2 Skor SLA instansi

```
response_ok = (first_response_at − created_at) ≤ 72 jam
resolve_ok  = (resolved_at − created_at) ≤ 14 hari

skor = 50% × %response_ok + 50% × %resolve_ok
```
- Laporan yang **belum jatuh tempo** (umur < batas SLA dan belum direspon) tidak masuk penyebut.
- Syarat masuk peringkat: ≥ 5 laporan jatuh tempo.
- Ambang (72 jam, 14 hari, 5 laporan) ada di `config/hakwarga.php`.

### 8.3 Kode

| Jenis | Format | Contoh |
|---|---|---|
| Resi | `HWR-{PROGRAM}-{YYMM}-{6 karakter}` | `HWR-PKH-2610-7K3M9Q` |
| Tiket | `HWT-{TAHUN}-{6 karakter}` | `HWT-2026-4HX72P` |
| Kode rahasia | 12 karakter, 3 kelompok | `7K3M-9Q4H-X72P` |

Alfabet acak: `23456789ABCDEFGHJKMNPQRSTVWXYZ` (tanpa 0/1/I/L/O/U). Kode demo (`DEMO01`–`DEMO03`) adalah pengecualian resmi untuk keperluan juri.

---

## 9. Kebutuhan Non-Fungsional

| Area | Kebutuhan |
|---|---|
| Performa | LCP ≤ 2,5 dtk · CLS ≤ 0,1 · JS landing ≤ 150 KB gzip · GeoJSON per level ≤ 1 MB gzip · MapLibre dimuat lazy hanya di `/peta` |
| Responsif | Diuji di 360, 390, 768, 1024, 1440 px; target sentuh ≥ 44 px |
| Aksesibilitas | WCAG 2.1 AA; navigasi keyboard penuh; kontras ≥ 4,5:1; `lang="id"`; skip link; label & pesan galat terhubung (`aria-describedby`); `aria-live` untuk status; hormati `prefers-reduced-motion`; peta selalu punya alternatif tabel |
| Keamanan | CSRF, validasi FormRequest, `$fillable`, escaping Blade (`{{ }}`), throttle, security headers, CSP (mulai report-only), HTTPS, secret hanya di `.env` |
| Keandalan | Seeder idempoten; perintah `php artisan hw:demo-reset` mengembalikan data demo ke kondisi awal; endpoint `/up` |
| Observabilitas | Log aplikasi tanpa PII; body `/lapor/*` tidak pernah dicatat |
| Bahasa | UI Bahasa Indonesia; identifier kode berbahasa Inggris |
| Pemeliharaan | Pint + Larastan + Pest di CI; README selalu mutakhir |

---

## 10. Pemetaan ke Kriteria Penilaian

### Babak Penyisihan
| Kriteria (bobot) | Jawaban kami | Bukti |
|---|---|---|
| Fungsionalitas Website (25%) | 4 modul end-to-end + admin; tes otomatis; responsif | Demo video, repo, CI |
| Orisinalitas Ide & Konsep (20%) | Resi tracker + peta anomali + pelaporan anonim + SLA publik dalam satu platform | Proposal bab 2–3 |
| Desain & Estetika Visual (20%) | Design system sendiri, aksesibel, mobile-first | Figma, `design.md` |
| Konten & Informasi (20%) | Data BPS riil + metodologi transparan + copy sederhana | `/data`, proposal bab 6 |
| Kesesuaian Tema & Subtema (15%) | Public Service Tracking (A, C, D) + Data-Driven Decision Support (B, D) | Proposal bab 1 |

### Babak Final
| Kriteria (bobot) | Fokus |
|---|---|
| Fungsionalitas & UX (25%) | Demo mulus, tanpa galat; alur 4 skenario |
| Desain & Kreativitas Visual (20%) | Polesan peta, timeline, micro-interaction ringan |
| Presentasi & Komunikasi (20%) | Cerita masalah → solusi → dampak; pembagian peran jelas |
| Orisinalitas & Konsep (15%) | Diferensiasi vs Cek Bansos/LAPOR! |

---

## 11. Rencana Rilis

| Milestone | Tanggal | Isi |
|---|---|---|
| **M1 — First Draft** | 1 Nov 2026 | Repo + README; Landing + Resi Tracker berjalan (data seed); wireframe modul lain; PDF Drafter |
| **M2 — Penyisihan** | 11 Nov 2026 | 4 modul + admin berfungsi; deploy; tes a11y/performa; proposal; surat; video |
| **M3 — Final** | 28 Nov 2026 | Polesan, stabilitas demo, deck, latihan presentasi, Q&A, cadangan offline |

Rincian tugas: `backlog.md` (prioritas) dan `todos.md` (jadwal harian).

---

## 12. Pertanyaan Terbuka

Dikelola di `context.md` §6. Yang paling berpengaruh pada PRD: wilayah pilot, ketersediaan data bansos agregat riil, dan ketentuan penggunaan AI pada panduan lomba.
