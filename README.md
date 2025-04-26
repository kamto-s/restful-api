# RESTful API - Laravel 12

---

## Instruksi Instalasi

### 1. Clone Repository

```sh
git clone https://github.com/kamto-s/restful-api.git
cd restful-api
```

### 2. Install Dependency

```bash
composer install
```

### 3. Setup Environment

Copy file `env.example` enjadi `.env`:

```sh
cp .env.example .env
```

### 4. Generate Application Key

```sh
php artisan migrate
```

### 5. Migrasi Database

```sh
php artisan key:generate
```

## Cara Menjalankan Aplikasi

Jalankan server lokal Laravel:

```sh
php artisan serve --port=8000
```

### Daftar API Endpoint

| Method | URL             | Keterangan                       |
| ------ | --------------- | -------------------------------- |
| GET    | /api/users      | Ambil semua user                 |
| GET    | /api/users/{id} | Ambil detail user berdasarkan ID |
| POST   | /api/users      | Tambah user baru                 |
| PUT    | /api/users/{id} | Update user berdasarkan ID       |
| DELETE | /api/users/{id} | Hapus user berdasarkan ID        |
