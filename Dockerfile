FROM php:8.1-apache

# تثبيت امتدادات PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql pgsql

# نسخ ملفات المشروع
COPY . /var/www/html/

# تعيين صلاحيات المجلد
RUN chown -R www-data:www-data /var/www/html
