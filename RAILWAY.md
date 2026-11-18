# Deploy ke Railway

Dokumen singkat ini menjelaskan cara memperbaiki error `500 GET /` di Railway.

## 1. Variabel yang wajib diset di Railway

Buka **Service → Variables** lalu isi:

| Variable | Contoh / keterangan |
| --- | --- |
| `APP_NAME` | `Portofolio Nurhaina` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` (set `true` sementara jika masih debugging) |
| `APP_KEY` | hasil `php artisan key:generate --show` |
| `APP_URL` | `https://portofolio-ku-production.up.railway.app` |
| `LOG_CHANNEL` | `stderr` |
| `LOG_STACK` | `stderr` |
| `LOG_LEVEL` | `debug` |
| `SESSION_DRIVER` | `database` |
| `SESSION_SECURE_COOKIE` | `true` |
| `SESSION_SAME_SITE` | `lax` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `database` |

### Database MySQL

Cukup gunakan salah satu cara berikut:

1. **Paling mudah:** set `DB_URL` (atau biarkan `DATABASE_URL` / `MYSQL_URL` dari plugin MySQL).
   ```
   DB_URL=mysql://user:password@host:port/database
   ```
2. Atau set variabel `DB_*`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=...
   DB_PORT=3306
   DB_DATABASE=...
   DB_USERNAME=...
   DB_PASSWORD=...
   ```
3. Atau reference variabel plugin MySQL Railway (`MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`). `config/database.php` sudah otomatis membacanya sebagai fallback.

> Catatan: `DB_HOST` harus host **internal** Railway (mis. `mysql.railway.internal`), bukan `127.0.0.1`.

## 2. Yang terjadi saat deploy

`railway.json` memakai builder **Dockerfile** dan menjalankan `sh docker/start.sh`.
Script tersebut, setiap kali container start:

1. Mencetak ringkasan environment (tanpa password).
2. Membuat `APP_KEY` sementara jika belum diset (agar tidak 500).
3. `php artisan config:clear`
4. `php artisan storage:link` → symlink `public/storage` ke `storage/app/public`
   agar foto testimoni bisa diakses browser.
5. `php artisan migrate --force` → membuat tabel `sessions`, `settings`, `educations`, dll.
6. `php artisan optimize:clear`
7. Menjalankan `php -S 0.0.0.0:$PORT -t public`

Jika migrasi gagal, container tetap hidup dan aplikasi mencoba migrasi lagi otomatis
pada request pertama (lihat `AppServiceProvider`), sehingga gangguan database sesaat
tidak membuat situs mati total.

### Kenapa dulu `GET /` error 500?

`Dockerfile` lama hanya menjalankan `php -S ...` tanpa migrasi. Akibatnya tabel
`profiles`, `skills`, `experiences`, `posts`, `settings`, `educations`, dan
kolom-kolom baru tidak pernah dibuat. Halaman `/login` tetap jalan karena hanya
butuh tabel `users`, sedangkan `/` butuh tabel-tabel baru tersebut.

Sekarang semua migrasi bersifat **idempoten** (aman diulang):

- `Schema::hasTable()` / `Schema::hasColumn()` mencegah error
  "table/column already exists" pada database yang sudah termigrasi sebagian
  atau berasal dari import dump SQL.
- Seed konten default tidak menimpa konten yang sudah diedit admin; hanya
  mengisi kolom yang masih kosong.
- Testimoni tidak di-seed, jadi daftar testimoni dimulai kosong.

## 3. Setelah deploy

- Pastikan Deploy Logs menampilkan `Nothing to migrate` atau daftar migrasi yang berhasil.
- Buka `https://<domain>/up` → harus `Application up`.
- Buka `https://<domain>/` → halaman utama harus tampil.
- Jika masih 500, baca baris error terakhir di Deploy Logs; sekarang pesan detailnya sudah terlihat.

> Catatan: file yang di-upload lewat admin disimpan di folder `public/img/...`
> di dalam container. Foto testimoni pengunjung disimpan di
> `storage/app/public/testimonials` dan diakses lewat `public/storage` (symlink
> yang dibuat otomatis oleh `storage:link`).
> Tanpa Railway Volume, semua file tersebut hilang saat redeploy.
> Untuk produksi jangka panjang, tambahkan Volume dan mount ke
> `/var/www/html/storage/app/public` (foto testimoni) serta `/var/www/html/public/img`
> (foto admin).


## 4. Membuat APP_KEY

Jalankan lokal:

```bash
php artisan key:generate --show
```

Salin hasil `base64:...` ke variable `APP_KEY` di Railway, lalu redeploy.
