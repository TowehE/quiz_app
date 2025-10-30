#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "--- Running Composer Install ---"
composer install --no-dev --optimize-autoloader

# --- CRITICAL FIX: Set directory permissions ---
echo "--- Setting Write Permissions for Storage ---"
# Give the web server group (www-data) ownership of storage and cache directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# Ensure the directories are writable by the group
chmod -R 775 /var/www/html/storage 
chmod -R 775 /var/www/html/bootstrap/cache
# ------------------------------------------------

echo "--- Caching Configuration ---"
# Run Laravel commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# If needed: php artisan migrate --force

echo "--- Starting Web Server (Supervisord) ---"
exec /usr/bin/supervisord -n