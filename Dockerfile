FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    git \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Berikan izin akses folder storage dan bootstrap cache agar tidak error 500
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8000

# Setiap container start: cek environment, jalankan migrasi,
# bersihkan cache, lalu nyalakan server. Lihat docker/start.sh.
CMD ["sh", "docker/start.sh"]
