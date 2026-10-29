# CLAUDE.md

@AGENTS.md

## Tambahan khusus Claude Code

- **Bahasa:** jawab dan jelaskan ke tim dalam Bahasa Indonesia; kode & komentar kode dalam Bahasa Inggris.
- **Mulai sesi:** baca `docs/context.md` §1 (status) dan butir terkait di `docs/todos.md` sebelum mengedit apa pun.
- **Mode rencana:** gunakan untuk perubahan yang menyentuh skema, route, lebih dari 3 berkas, atau aturan privasi. Setujui rencana dulu, baru eksekusi.
- **Frontend & UI (Anti-Slop):** Setiap pengerjaan frontend/UI **WAJIB memanggil dan mematuhi skill `antislop`** (`antislop`, `antislop-ui`, `antislop-copywriting`, `antislop-human`, `antislop-layoutmobile`). Hindari slop AI (sparkle generik, gradien klise, metrik kosong, copywriting robotik).
- **Infrastruktur Mandiri (Sovereign & Self-Hosted):** Sistem 100% independen tanpa PaaS proprietary (bebas Vercel, Railway, Supabase, dll). Deployment target: VPS mandiri (Ubuntu + Docker Compose / Nginx + PostgreSQL 16). Model AI bersifat **opsional** (hanya digunakan jika ada use-case yang benar-benar membutuhkan LLM; default MVP berbasis PHP native & regex). Bila diperlukan, akses via direct API / proxy mandiri (`9router`).
- **Verifikasi sebelum menyatakan selesai:** jalankan `./vendor/bin/pint`, `./vendor/bin/phpstan analyse`, dan `php artisan test`. Jangan mengatakan "selesai" bila ada yang merah.
- **Data demo:** saat diminta membuat data, hanya sintetis (`is_simulated = true`). Jangan membuat NIK/nama/alamat yang menyerupai orang nyata.
- **Dependensi & skema:** tanya sebelum menambah paket Composer/npm atau mengubah skema yang sudah di-merge.
- **Perintah destruktif** (`migrate:fresh`, `db:wipe`, `rm -rf`, `git reset --hard`): hanya di lingkungan lokal dan setelah konfirmasi.
- **Dokumentasi hidup:** setelah menyelesaikan butir, centang `docs/todos.md`, perbarui Status Progres di `README.md`, dan `docs/context.md` §1 bila status modul berubah.
- **Kejujuran:** laporkan apa yang *tidak* selesai atau tidak diuji. Jangan mengarang hasil tes atau angka performa.
- **Subagent / eksplorasi:** boleh dipakai untuk menelusuri banyak berkas; hasil yang dipakai tetap diverifikasi sendiri sebelum diubah.
