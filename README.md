# Sistem Manajemen Perpustakaan Digital

UTS Backend Development (DT199). Aplikasi web **Modular Monolith** dengan Laravel 13, SQLite, Laravel Sanctum, RBAC, dan Blade.

## Modul

| Modul | Isi | Contract publik |
|---|---|---|
| `app/Modules/Catalog` | Buku, Penulis, Kategori | `Catalog\Contracts\BookCatalog` |
| `app/Modules/Membership` | Anggota, Jenis Keanggotaan | `Membership\Contracts\MemberDirectory` |
| `app/Modules/Circulation` | Peminjaman, Pengembalian, Denda | (konsumen kedua contract di atas) |

Setiap modul punya Service Provider sendiri (`loadMigrationsFrom`, `loadRoutesFrom`, `loadViewsFrom`) yang didaftarkan di `bootstrap/providers.php`.
Modul tidak boleh memakai Model/Service modul lain; aturan ini dicek otomatis oleh `tests/Feature/ModuleBoundaryTest.php`.

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite    # Windows: type nul > database\database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Buka http://127.0.0.1:8000

## Akun demo (password: `password`)

| Role | Email | Hak akses |
|---|---|---|
| Admin | admin@perpus.test | Semua fitur, termasuk CRUD buku, kategori, penulis, dan jenis keanggotaan |
| Pustakawan | pustakawan@perpus.test | Lihat katalog, CRUD anggota, peminjaman, pengembalian, denda |

Register publik selalu membuat akun **pustakawan**.

## Data demo dari seeder

- Buku **"Laravel 13 untuk Pemula (Stok Habis)"** punya stok 0, untuk demo error stok habis.
- **"Anggota Nonaktif (Demo)"** untuk demo error anggota nonaktif.
- 2 peminjaman sudah terlambat: satu sudah dikembalikan (ada denda), satu belum (kembalikan untuk melihat denda dihitung).

## Aturan bisnis

- Batas pinjam, lama pinjam, dan denda/hari diatur per jenis keanggotaan.
- Denda = hari terlambat × denda/hari × jumlah buku. Tarif denda disimpan saat peminjaman dibuat.
- Peminjaman dan pengembalian berjalan dalam `DB::transaction()`. Jika satu buku stoknya habis, seluruh peminjaman di-rollback.

## REST API (Sanctum token, rate limit)

```bash
curl -X POST http://127.0.0.1:8000/api/login -H "Accept: application/json" \
     -d "email=admin@perpus.test&password=password"
curl http://127.0.0.1:8000/api/catalog/books -H "Accept: application/json" -H "Authorization: Bearer <token>"
```

`/api/login` dibatasi 5 request/menit; endpoint lain 60 request/menit.

## Testing

```bash
php artisan test
vendor/bin/pint --test
```
