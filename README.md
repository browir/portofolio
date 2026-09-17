# Portofolio — Wira Marr

Website portofolio bertema **RPG fantasy**, dibangun dengan Laravel 12 + Tailwind CSS v4 (Vite), di-deploy ke Vercel lewat runtime komunitas [`vercel-php`](https://github.com/vercel-community/php).

Demo lokal: character sheet (hero), stats (skill bar), quest log (pengalaman kerja), achievements (proyek), guild hall (pendidikan/sertifikasi), dan form kontak "Send a Raven".

## Struktur konten

Semua isi (nama, bio, skill, pengalaman, proyek, pendidikan, link) ada di satu file:

```
config/portfolio.php
```

Edit file itu untuk mengganti data placeholder dengan data aslimu — tidak perlu menyentuh file Blade.

## Menjalankan lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run dev        # jalankan Vite (terminal terpisah)
php artisan serve  # buka http://127.0.0.1:8000
```

Aplikasi ini **tidak butuh database** — session pakai driver `cookie`, cache pakai `array`, queue pakai `sync`. Jadi tidak perlu `php artisan migrate`.

## Deploy ke Vercel

Vercel tidak native mendukung PHP/Laravel (dibuat untuk Node/serverless static). Project ini dikonfigurasi memakai runtime komunitas `vercel-php`, dengan:

- `api/index.php` — entrypoint serverless function, cukup me-require `public/index.php`.
- `vercel.json` — mendefinisikan dua build: `@vercel/static-build` (menjalankan `npm run build` lalu men-serve isi folder `public/`) dan `vercel-php` (menjalankan `composer install` lalu menjalankan Laravel per-request).
- `bootstrap/app.php` — saat env `VERCEL=1`, storage path Laravel dialihkan ke `/tmp/storage` karena filesystem Vercel read-only kecuali `/tmp`.

### Langkah deploy

1. Push repo ini ke GitHub (lihat bagian Git di bawah).
2. Buka [vercel.com](https://vercel.com) → **Add New Project** → import repo `browir/portofolio`.
3. Saat konfigurasi awal, Vercel akan mendeteksi `vercel.json` dan memakai build config di dalamnya — kamu tidak perlu mengubah Framework Preset.
4. Tambahkan **Environment Variables** di Project Settings (wajib, karena `.env` sengaja tidak ikut ter-commit):
   - `APP_KEY` — generate dengan `php artisan key:generate --show` lalu tempel hasilnya (termasuk prefix `base64:`).
   - `APP_URL` — isi dengan domain Vercel-mu, mis. `https://portofolio-kamu.vercel.app`.
   - (Opsional, untuk form kontak benar-benar mengirim email) `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS` — pakai provider seperti Resend, Mailgun, Postmark, atau Brevo. Tanpa ini, form tetap jalan tapi pesan tidak benar-benar terkirim (karena `MAIL_MAILER` default `log`).

   `APP_ENV`, `APP_DEBUG`, `LOG_CHANNEL`, `CACHE_STORE`, `SESSION_DRIVER`, dan `VERCEL` sudah diisi lewat `vercel.json`, tidak perlu diulang.
5. Deploy. Build pertama akan menjalankan `npm install && npm run build` (untuk aset Tailwind/Vite) dan `composer install` (untuk dependency Laravel) secara otomatis.

### Batasan mode serverless (perlu diketahui)

Karena berjalan sebagai fungsi serverless stateless, beberapa fitur Laravel yang butuh state persisten **tidak dipakai** di project ini secara sengaja:
- Tidak ada queue worker (`QUEUE_CONNECTION=sync`, job dijalankan langsung).
- Tidak ada scheduler/cron bawaan Laravel.
- Tidak ada session/cache berbasis file atau database — pakai `cookie`/`array`.
- Upload file permanen butuh storage eksternal (S3, dsb), bukan disk lokal.

Untuk website portofolio (konten + form kontak), batasan ini tidak berpengaruh.

## Git

Jika belum, hubungkan ke repo GitHub:

```bash
git init
git remote add origin https://github.com/browir/portofolio.git
git add .
git commit -m "Initial commit: portofolio RPG fantasy"
git branch -M main
git push -u origin main
```
