# استخدم صورة PHP الرسمية مع Apache
FROM php:8.1-apache

# تثبيت PostgreSQL ودعم pg_connect
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# نسخ ملفات المشروع إلى مجلد السيرفر
COPY . /var/www/html/

# إعطاء صلاحيات للمجلد
RUN chown -R www-data:www-data /var/www/html
