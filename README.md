# RESTful API + Frontend Consumer

Project sederhana RESTful API menggunakan Laravel + Frontend untuk konsumsi API.

## Project Overview

-   **Backend (Laravel 12)** → Laravel (`localhost:8000`)
-   **Frontend Consumer** → Laravel + jQuery (`localhost:8005`)

---

## Instalasi

Clone project:

```bash
git clone https://github.com/kamto-s/restful-api.git
cd restful-api
```

Composer install

```bash
composer install
```

Copy `.env`:

```bash
cp .env.example .env
```

Generate app key:

```bash
php artisan key:generate
```

Set konfigurasi database di file `.env`, lalu jalankan migrasi:

```bash
php artisan migrate
```

## Menjalankan Project

Backend API (port 8000)

```bash
php artisan serve --port=8000
```

Frontend Consumer (port 8005)

```bash
php artisan serve --port=8005
```

## API Endpoint

| Method | URL             | Keterangan                |
| ------ | --------------- | ------------------------- |
| GET    | /api/users      | Ambil semua user          |
| GET    | /api/users/{id} | Ambil user berdasarkan ID |
| POST   | /api/users      | Tambah user baru          |
| PUT    | /api/users/{id} | Update user               |
| DELETE | /api/users/{id} | Hapus user                |

## Arsitektur & Alur Kerja
- **Frontend** mengirimkan request AJAX ke **Backend API**.
- **Backend API** memproses request dan merespon dalam format **JSON**.
- **Frontend** akan:
  - Menampilkan data user (GET),
  - Menampilkan error validasi di form (POST/PUT gagal),
  - Mereset form dan refresh daftar user jika operasi berhasil.
