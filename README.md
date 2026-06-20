---
title: Bgify
emoji: 🖼️
colorFrom: blue
colorTo: purple
sdk: docker
app_port: 7860
pinned: false
---
# Bgify

Bgify adalah aplikasi web modern untuk menghapus background foto secara otomatis menggunakan AI. Frontend dibangun dengan Blade, Tailwind CSS, dan JavaScript; backend Laravel memvalidasi upload lalu menjalankan script Python berbasis `rembg` dan `pillow`.

## Fitur

- Upload gambar dengan drag and drop atau file picker.
- Validasi JPG, JPEG, PNG, WEBP dengan ukuran maksimal 10 MB.
- Preview gambar asli, hasil AI, dan before/after slider.
- Background removal otomatis menggunakan Python `rembg`.
- Output PNG transparan dengan tombol Download PNG Transparan dan Download HD.
- Dark mode/light mode dengan preferensi tersimpan di LocalStorage.
- Loading spinner, upload progress bar, toast notification, dan error handling.
- Tanpa database.

## Struktur Penting

```text
app/Http/Controllers/BackgroundRemovalController.php
app/Services/BackgroundRemovalService.php
config/bgify.php
resources/views/home.blade.php
resources/css/app.css
resources/js/app.js
routes/web.php
routes/api.php
scripts/remove_background.py
public/favicon.svg
public/images/og-bgify.svg
```

## Persyaratan

- PHP 8.1+ untuk project saat ini. Untuk Laravel 12 gunakan PHP 8.2+ dan dependency Laravel 12.
- Composer
- Node.js 18+
- Python 3.10+
- Ekstensi PHP yang umum untuk Laravel: `fileinfo`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`

## Instalasi

1. Install dependency PHP.

```bash
composer install
```

2. Install dependency frontend.

```bash
npm install
```

3. Siapkan environment.

```bash
cp .env.example .env
php artisan key:generate
```

4. Buat symbolic link storage publik.

```bash
php artisan storage:link
```

5. Install dependency Python.

```bash
python -m pip install "rembg[cpu]" pillow
```

Jika memakai virtual environment, set binary Python di `.env`.

```env
BGIFY_PYTHON_BINARY=C:\path\to\venv\Scripts\python.exe
BGIFY_PROCESS_TIMEOUT=180
```

6. Jalankan frontend dan Laravel.

```bash
npm run dev
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Build Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Pastikan folder berikut writable oleh web server:

```text
storage/app
storage/app/public
storage/logs
bootstrap/cache
```

## API

### POST `/api/remove-background`

Request multipart:

```text
image: file JPG/JPEG/PNG/WEBP, max 10 MB
```

Response sukses:

```json
{
  "message": "Background berhasil dihapus.",
  "data": {
    "job_id": "uuid",
    "result_url": "http://localhost/storage/bgify/uuid/bgify-transparent.png",
    "download_url": "http://localhost/download/uuid/standard",
    "hd_download_url": "http://localhost/download/uuid/hd"
  }
}
```

## Catatan Laravel 12

Kode aplikasi ini memakai API Laravel yang kompatibel dengan Laravel 10 sampai Laravel 12. Skeleton workspace yang tersedia saat ini masih menggunakan `laravel/framework` `^10.10`; untuk benar-benar menjalankan Laravel 12, upgrade dependency framework sesuai panduan resmi Laravel dan pastikan PHP minimal 8.2.

## Footer

Created by Maskuari.2026

