#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "--- Running Composer Install ---"
composer install --no-dev --optimize-autoloader

echo "--- Caching Configuration ---"
# Run Laravel commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# If needed: php artisan migrate --force

echo "--- Starting Web Server (Supervisord) ---"
# Start the supervisor process, which manages Nginx and PHP-FPM
# Use the direct command expected by the richarvey/nginx-php-fpm image
exec /usr/bin/supervisord -n