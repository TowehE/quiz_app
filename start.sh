#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "--- Running Composer Install ---"
# Run composer install
composer install --no-dev --optimize-autoloader

echo "--- Caching Configuration ---"
# Run Laravel commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# You may also need to run migrations here if your app uses a database
# php artisan migrate --force

# Now, execute the container's original command (which starts Nginx/PHP-FPM)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf -n