#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

# backup database

echo "create gz backup"
pg_dump eumadb > ~/backup/$(date +%Y-%m-%d).backup
gzip  ~/backup/$(date +%Y-%m-%d).backup --force
echo "Clearing old backups. takes only the last 10"
cd ~/backup
rm `ls -t | awk 'NR>10'` -f
cd ~/prodeuma

# Pull the latest version of the app
git pull origin main

# Install composer dependencies
composer install  --no-interaction --prefer-dist --optimize-autoloader
# php artisan nova:install

# Clear caches
php artisan config:clear
php artisan optimize

# Migration
php artisan migrate --force

# Exit maintenance mode
php artisan up

echo "Deployment finished!"
