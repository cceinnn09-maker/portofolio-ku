#!/bin/sh

# ============================================================
# Startup script untuk Railway / Docker.
# Menjalankan migrasi & membersihkan cache setiap deploy,
# lalu menyalakan server PHP.
# ============================================================

set -e

echo "=============================================="
echo " Portfolio Nurhaina - container starting"
echo " APP_ENV       : ${APP_ENV:-production}"
echo " APP_DEBUG     : ${APP_DEBUG:-false}"
echo " APP_URL       : ${APP_URL:-<belum diset>}"
echo " DB_CONNECTION : ${DB_CONNECTION:-<belum diset>}"
echo " DB_HOST       : ${DB_HOST:-${MYSQLHOST:-<belum diset>}}"
echo " DB_DATABASE   : ${DB_DATABASE:-${MYSQLDATABASE:-<belum diset>}}"
echo " LOG_CHANNEL   : ${LOG_CHANNEL:-stderr}"
echo "=============================================="

# APP_KEY wajib ada. Jika belum diset di Railway, buat kunci sementara
# supaya aplikasi tidak 500 karena cookie tidak bisa dienkripsi.
# Untuk produksi, set APP_KEY permanen di Railway Variables agar session
# tidak hilang setiap redeploy.
if [ -z "${APP_KEY:-}" ]; then
  echo "PERINGATAN: APP_KEY belum diset. Membuat APP_KEY sementara untuk container ini."
  echo "            Set APP_KEY di Railway Variables agar session tetap stabil."
  APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
  export APP_KEY
fi

# Bersihkan cache konfigurasi agar variabel environment Railway terbaca.
php artisan config:clear || true

# Jalankan semua migrasi yang belum diterapkan (termasuk tabel sessions,
# settings, educations, dan seed konten default).
# Jangan hentikan container kalau database sedang belum siap: aplikasi tetap
# dinyalakan, dan AppServiceProvider akan mencoba migrasi lagi pada request
# pertama (lihat ensurePortfolioSchemaIsReady()).
if ! php artisan migrate --force; then
  echo "PERINGATAN: migrasi gagal. Aplikasi tetap dijalankan dan akan mencoba lagi otomatis."
fi

# Bersihkan cache route/view/config agar perubahan terbaru langsung dipakai.
php artisan optimize:clear || true

echo "Startup selesai. Menjalankan server di port ${PORT:-8000}..."
exec php -S 0.0.0.0:${PORT:-8000} -t public
