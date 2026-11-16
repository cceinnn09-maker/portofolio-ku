FROM php:8.2-apache

# Install ekstensi sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    git \
    unzip

# Install Composer resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www/html

# Salin seluruh file project
COPY . .

# Install dependencies composer tanpa dev
RUN composer install --no-dev --optimize-autoloader

# Atur Document Root Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Berikan izin akses folder storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Gunakan port dinamis dari Railway atau default 80
EXPOSE 80

# Jalankan Apache dalamforeground agar container tetap aktif
CMD ["apache2-foreground"]