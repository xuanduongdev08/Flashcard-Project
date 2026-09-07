#!/bin/bash
set -e

# Ensure SQLite file exists if using sqlite driver
if [ "${DB_CONNECTION}" = "sqlite" ]; then
    mkdir -p /var/www/html/database
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
    fi
    chown -R www-data:www-data /var/www/html/database
fi

# Execute database migrations
php artisan migrate --force || true

# Create storage symlink
php artisan storage:link || true

# Cache configuration, routes, and views
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
