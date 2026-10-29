# Submission Guide — Semua Deliverable Lomba WIA

> Spesifikasi, penamaan, dan outline untuk seluruh berkas yang wajib dikumpulkan.
> Checklist harian ada di `todos.md`; butir kerja di `backlog.md` (Epik E9).
> Jika panduan resmi berbeda dari dokumen ini, **panduan resmi menang** — perbarui dokumen ini.

---

## 0. Ringkasan Deliverable

| MS | Tanggal | Berkas | Aturan utama |
|---|---|---|---|
| **M1** | 1 Nov 2026 | Link repo publik + `README.md` | README: judul & deskripsi 1–2 kalimat, tech stack, cara menjalankan (clone → install → run), status progres |
| **M1** | 1 Nov 2026 | PDF Drafter `WIA_FSDMIA2026_NamaTim` | ≤ 10 halaman, ≤ 10 MB; konsep singkat, sitemap, wireframe/tampilan utama, penjelasan fitur, **screenshot ≥ 2 halaman (wajib Landing + 1 halaman lain)** |
| **M2** | 11 Nov 2026 | Link Google Drive publik berisi Proposal PDF `WIA_PenyisihanMIA2026_NamaTim` | ≤ 30 halaman |
| **M2** | 11 Nov 2026 | Surat Orisinalitas Karya bermaterai Rp10.000 | Di folder Drive yang sama |
| **M2** | 11 Nov 2026 | Link video pitching YouTube | ≤ 5 menit, **Public**; perkenalan tim & peran, demo fitur utama, rencana pengembangan, deskripsi menarik |
| **M3** | 28 Nov 2026 | Pitch Deck `.pptx` atau `.pdf` | ≤ 15 halaman (ID/EN); urutan wajib di §4 |
| **M3** | 28 Nov 2026 | Presentasi onsite | 10 menit presentasi + 5 menit Q&A |

> Catatan: teks panduan menyebut "Surat Pernyataan" di satu tempat dan "Surat Keterangan" di tempat lain. **Gunakan template resmi panitia** bila ada (Q-03 di `context.md`).

### Aturan umum
- Ganti `NamaTim` dengan nama tim persis (tanpa spasi; pakai `_` bila perlu) dan **konsisten** di semua berkas.
- Uji semua tautan di **jendela incognito** (tanpa login).
- Simpan salinan semua yang dikirim di folder `submitted/` (lokal, bukan di repo).
- Kirim **≥ 3 jam sebelum batas**; simpan bukti kirim (tangkapan layar).

---

## 1. M1 — First Draft (1 Nov)

### 1.1 Checklist repo
- [ ] Repo **publik** (GitHub/GitLab), terbuka tanpa login
- [ ] `README.md` memuat: judul + deskripsi 1–2 kalimat · tech stack · cara menjalankan · status progres
- [ ] Cara menjalankan **diuji dari nol** di folder baru (`git clone` → install → run)
- [ ] Ada commit dari **ketiga anggota** (riwayat commit terlihat juri)
- [ ] Tidak ada `.env`, kunci API, atau data pribadi di repo
- [ ] Status progres jujur (yang belum jadi ditandai "wireframe saja")

### 1.2 Outline PDF Drafter (10 halaman)

Nama berkas: `WIA_FSDMIA2026_NamaTim.pdf` · ≤ 10 MB (kompres gambar ke ±150 dpi, simpan PNG→JPG bila perlu).

| Hal | Isi | Menjawab kriteria |
|---|---|---|
| 1 | Cover: nama tim & anggota + peran, judul, tagline, tema/subtema, link repo (+ demo bila ada) | Kesesuaian tema |
| 2 | Latar belakang & problem statement (angka + sumber resmi) | Konten & Informasi |
| 3 | Konsep singkat, value proposition, diferensiasi vs Cek Bansos & LAPOR! | Orisinalitas |
| 4 | Persona + 4 user flow ringkas | UX |
| 5 | **Sitemap** (diagram) | Struktur |
| 6 | **Wireframe** Landing + Tracker | Desain |
| 7 | **Wireframe** Peta + Lapor + Scorecard | Desain |
| 8 | Penjelasan 4 fitur utama (tabel: masalah → cara kerja → status *Jadi / Wireframe*) | Fungsionalitas |
| 9 | **Screenshot ≥ 2 halaman nyata** (Landing + Tracker) + ringkasan arsitektur & tech stack | Fungsionalitas |
| 10 | Roadmap ke 11 Nov & 28 Nov, risiko (privasi, kualitas data) & mitigasi | Kesiapan |

### 1.3 Template README (isi jujur)
Lihat `README.md` di repo. Perbarui bagian **Status Progres** pada hari pengumpulan.

---

## 2. M2 — Penyisihan (11 Nov)

### 2.1 Struktur folder Google Drive
```
WIA_PenyisihanMIA2026_NamaTim/            ← akses: "Siapa saja yang memiliki link" · Pelihat
├── WIA_PenyisihanMIA2026_NamaTim.pdf     ← proposal (≤ 30 hal)
└── Surat_Orisinalitas_NamaTim.pdf        ← scan jelas, materai terlihat & ditandatangani
```
Uji akses di incognito. Pastikan ukuran berkas wajar dan teks dapat dibaca.

### 2.2 Outline Proposal (≤ 30 halaman)

| Bab | Hal. | Isi | Kriteria utama |
|---|---|---|---|
| Cover, Abstrak, Daftar Isi | 3 | Ringkasan 1 halaman, daftar isi | — |
| 1. Pendahuluan | 3 | Latar belakang (data bersumber), rumusan masalah, tujuan, manfaat, **kesesuaian tema & subtema** | Kesesuaian Tema |
| 2. Analisis & Diferensiasi | 2 | Cek Bansos, LAPOR!, praktik lain; celah yang diisi | Orisinalitas |
| 3. Konsep & Fitur | 5 | 4 modul: masalah → solusi → alur → tangkapan layar | Fungsionalitas, Orisinalitas |
| 4. Desain UI/UX | 4 | Persona, sitemap, user flow, design system, wireframe→mockup, aksesibilitas, responsif | Desain & Estetika |
| 5. Arsitektur & Implementasi | 3 | Tech stack & alasan, arsitektur, ERD, struktur kode, CI, deployment | Fungsionalitas |
| 6. Data & Metodologi | 3 | Sumber & lisensi, data simulasi (transparan), rumus anomali & SLA, batasan | Konten & Informasi |
| 7. Keamanan, Privasi & Etika | 2 | Rujukan UU PDP/KIP, desain anonim, disclaimer jujur | Konten, Orisinalitas |
| 8. Pengujian & Kualitas | 2 | Lighthouse, axe, uji perangkat, uji pengguna, tes otomatis | Fungsionalitas |
| 9. Dampak & Rencana Pengembangan | 2 | Dampak, keberlanjutan, roadmap, model operasional | Orisinalitas |
| 10. Tim & Pembagian Peran | 1 | Peran, kontribusi | — |
| Penutup, Daftar Pustaka, Lampiran | 2 | Kesimpulan, referensi, tautan | Konten |

Total ±32 → pangkas lampiran/ukuran gambar agar **≤ 30 halaman**.

### 2.3 Surat Orisinalitas
- [ ] Gunakan template resmi panitia (jika ada)
- [ ] Materai **Rp10.000** — beli lebih awal (Sen 2 Nov); bila e-meterai diperbolehkan, pastikan panduan menyebutnya
- [ ] Ditandatangani sesuai ketentuan (ketua/seluruh anggota — cek panduan), tanda tangan menimpa sebagian materai bila disyaratkan
- [ ] Scan/foto datar, terang, terbaca → PDF
- [ ] Isi surat sesuai kenyataan, termasuk bila lomba mewajibkan deklarasi penggunaan alat bantu (Q-02)

### 2.4 Video Pitching (≤ 5 menit)

Target durasi **4:30–4:45** (sisakan margin). Resolusi 1080p, audio jernih (mikrofon eksternal/earphone), subtitle Bahasa Indonesia, **YouTube: Public**.

| Waktu | Segmen | Isi | Pembicara |
|---|---|---|---|
| 0:00–0:20 | Hook | Satu skenario nyata: ibu penerima bansos yang tidak tahu haknya | D |
| 0:20–0:50 | Tim | Nama, peran masing-masing (K, F, D) | Semua |
| 0:50–1:30 | Masalah & tujuan | 3 masalah + data bersumber; apa yang kami ubah | D |
| 1:30–3:30 | **Demo** | Tracker (40 dtk) → Peta anomali (40 dtk) → Lapor pungli + tiket (30 dtk) → Scorecard (20 dtk) → Admin balas tiket (10 dtk) | F + K (narasi D) |
| 3:30–4:15 | Rencana pengembangan | Integrasi data resmi, kemitraan pemda, skala nasional, aksesibilitas lanjutan | K |
| 4:15–4:40 | Penutup | Dampak + ajakan + URL | D |

Checklist produksi: skrip tertulis → latihan → rekam layar (OBS) 1080p → edit (potong jeda) → subtitle → thumbnail → unggah → set **Public** → uji di incognito.

**Template deskripsi YouTube**
```
HakWarga — Bansos adalah hak warga. Pastikan sampai utuh tanpa potongan.

Platform transparansi bantuan sosial: lacak resi penyaluran, telaah anomali alokasi di peta,
laporkan pungli secara anonim, dan pantau kinerja respon instansi.

Karya <NamaTim> untuk Multimedia In Action (MIA) 2026 — Web In Action
Tema: Designing Digital Futures – Powering Public Transparency
Subtema: Public Service Tracking · Data-Driven Decision Support

⏱ Daftar isi
00:00 Pembukaan
00:20 Tim kami
00:50 Masalah & tujuan
01:30 Demo fitur
03:30 Rencana pengembangan
04:15 Penutup

🔗 Repo: <URL>   🌐 Domain: https://hakwarga.web.id
Catatan: data pada demo adalah SIMULASI.
#MIA2026 #WebInAction #TransparansiPublik #HakWarga #Bansos
```

---

## 3. Persiapan Sebelum Kirim M2 (H-1)
- [ ] Repo publik terbaru; README selaras proposal
- [ ] Demo live bisa dibuka dari jaringan lain/HP
- [ ] Lighthouse & axe dijalankan; hasil ada di proposal bab 8
- [ ] PDF proposal dibuka di 2 perangkat (tidak ada font/gambar rusak)
- [ ] Folder Drive & YouTube diuji incognito
- [ ] Salinan ke `submitted/`

---

## 4. M3 — Final Onsite (28 Nov)

### 4.1 Pitch Deck (≤ 15 halaman)

Urutan **wajib**: Cover → Latar Belakang & Masalah → Tujuan & Manfaat → Solusi/Fitur Utama → Demo Website → Rencana Pengembangan → Kesimpulan.

| Slide | Bagian wajib | Isi | Waktu |
|---|---|---|---|
| 1 | Cover | Nama, tagline, tim | 0:20 |
| 2 | Latar Belakang & Masalah | Cerita + 3 data bersumber | 1:00 |
| 3 | Latar Belakang & Masalah | Akar masalah (4 titik kebocoran) | 0:40 |
| 4 | Tujuan & Manfaat | Tujuan + manfaat untuk warga, relawan, instansi | 0:50 |
| 5 | Solusi/Fitur Utama | Gambaran 4 modul | 0:50 |
| 6 | Solusi/Fitur Utama | Keunikan: Resi + Anomali + Anonim + SLA | 0:40 |
| 7 | Solusi/Fitur Utama | Privasi & etika by design | 0:40 |
| 8 | Demo Website | Skenario & urutan demo (jaring pengaman) | 0:20 |
| 9–10 | Demo Website | **Demo live** (4 skenario) / tangkapan layar cadangan | 3:30 |
| 11 | Demo Website | Kualitas: performa, aksesibilitas, tes | 0:40 |
| 12 | Rencana Pengembangan | Roadmap 3/6/12 bulan | 0:50 |
| 13 | Rencana Pengembangan | Model operasional & kemitraan | 0:30 |
| 14 | Kesimpulan | Ringkasan dampak + ajakan | 0:30 |
| 15 | Penutup | Tim, kontak, QR ke repo/demo | 0:10 |

Total ±10:00 (latih dengan timer; target selesai **9:30**).

### 4.2 Pembagian bicara (usulan)
D: pembuka, masalah, tujuan, kesimpulan · F: fitur peta/UX, kualitas · K: arsitektur, privasi, roadmap · Demo: F mengoperasikan, D menarasikan, K siaga cadangan.

### 4.3 Bank Q&A (siapkan jawaban 1–2 kalimat, tentukan penjawab)

| # | Pertanyaan juri | Arah jawaban |
|---|---|---|
| 1 | Dari mana data penerima? | Sintetis berlabel; alasan UU PDP; jalur integrasi resmi bila bermitra |
| 2 | Bagaimana menjamin laporan tidak palsu/fitnah? | Moderasi, verifikasi bertahap, isi tidak publik, nama oknum tidak tampil |
| 3 | Apakah benar-benar anonim? | Tidak menyimpan IP & identitas; jujur bahwa hosting punya log sendiri |
| 4 | Apa bedanya dengan Cek Bansos / LAPOR!? | Tabel diferensiasi `prd.md` §2 |
| 5 | Bagaimana jika rasio tinggi itu sah? | Indikator penapis, bukan putusan; ada penjelasan rumus |
| 6 | Bagaimana instansi mau ikut? | Insentif reputasi scorecard, kemitraan pemda, panel mudah dipakai |
| 7 | Skalabilitas? | PostgreSQL, cache, GeoJSON per level, bisa horizontal; jalur ke job queue |
| 8 | Keamanan? | CSRF, throttle, Turnstile, hash NIK ber-pepper, EXIF dibersihkan, tes otomatis |
| 9 | Aksesibilitas? | WCAG 2.1 AA, tabel alternatif peta, uji keyboard & pembaca layar |
| 10 | Mengapa Laravel/PostgreSQL? | Produktivitas tim kecil, ekosistem matang, fitur analitik SQL |
| 11 | Keberlanjutan & biaya? | Biaya hosting rendah; opsi hibah/CSR/kemitraan lembaga pengawas |
| 12 | Bagaimana warga tanpa internet/HP? | Relawan/RT sebagai perantara; cetak Kartu Hak; roadmap kanal offline |
| 13 | Risiko penyalahgunaan? | Rate limit, moderasi, audit trail, kebijakan konten |
| 14 | Apa yang dikerjakan masing-masing anggota? | Jawab sesuai `context.md` §3 + contoh commit/desain |
| 15 | Apa langkah berikutnya setelah lomba? | Roadmap slide 12 |

### 4.4 Cadangan & Logistik
- [ ] Server lokal offline (Docker/Laragon) + **dump database** + `.env` demo
- [ ] Rekaman layar demo penuh (MP4, 1080p) di 2 perangkat
- [ ] Tangkapan layar tiap skenario dalam deck
- [ ] Hotspot ponsel sebagai jaringan cadangan
- [ ] Deck dalam `.pptx` **dan** `.pdf`, di USB + cloud
- [ ] Adaptor HDMI/USB-C, charger, mouse, kartu identitas
- [ ] `php artisan hw:demo-reset` dijalankan sesaat sebelum tampil

---

## 5. Gamifikasi Lomba (XP/Diamonds)

- Kerjakan kuis/misi harian bergilir (siapa yang online paling dulu).
- Tukar Diamonds dengan **tiket konsultasi mentor**; jadwalkan ≥ 1 konsultasi sebelum 11 Nov. Bawa daftar pertanyaan spesifik (privasi, peta, struktur proposal).
- Pantau leaderboard bila perlu untuk motivasi; jangan mengorbankan jadwal produk.
