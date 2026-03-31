# Stage 1 - Build Frontend (Vite)
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2 - Backend (Laravel + Apache)
FROM php:8.3-apache AS backend

# Cấu hình Apache trỏ vào thư mục public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Kích hoạt mod_rewrite để Laravel chạy được các route (đường dẫn)
RUN a2enmod rewrite

# Cài đặt extension cần thiết cho PHP
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Cài đặt Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy toàn bộ file dự án
COPY . .

# Copy các file frontend đã build từ Stage 1
COPY --from=frontend /app/public/build ./public/build

# Cài đặt thư viện PHP
RUN composer install --no-dev --optimize-autoloader

# Dọn dẹp cache Laravel
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# Cấp quyền cho các thư mục quan trọng
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Apache mặc định chạy ở cổng 80, Render sẽ tự nhận diện
CMD ["apache2-foreground"]
