# استخدم صورة PHP مع Apache
FROM php:8.1-apache

# تثبيت PostgreSQL ودعم pg_connect
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# نسخ كل ملفات المشروع إلى مجلد السيرفر
COPY . /var/www/html/

# تغيير صلاحيات المجلد
RUN chown -R www-data:www-data /var/www/html
