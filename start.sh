#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "--- Running Composer Install ---"
composer install --no-dev --optimize-autoloader

echo "--- Setting Write Permissions for Storage ---"
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage 
chmod -R 775 /var/www/html/bootstrap/cache

echo "--- Clearing all caches ---"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "--- Caching Configuration ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Running Migrations ---"
php artisan migrate --force

echo "--- Starting Web Server (Supervisord) ---"
exec /usr/bin/supervisord -n
```

### 3. In Render Dashboard - Add Environment Variables:

Go to your service in Render and manually add:
```
DB_PASSWORD=K0hDpIvicXpvPQNu
MAIL_PASSWORD=qwkh flrc arsm ihep