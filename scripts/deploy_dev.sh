#!/bin/bash
set -e

# oc:8845 — deploy container-aware: artisan e composer girano SOLO nel container
# phpfpm_dev (PHP 8.2.35), mai col PHP dell'host.

REPO_DIR="/var/www/html/dev.eumadb.webmapp.it"
COMPOSE="docker compose -f $REPO_DIR/server.compose.yml"
PHP_DEV="$COMPOSE exec -T phpfpm_dev php"
COMPOSER_DEV="$COMPOSE exec -T phpfpm_dev composer"

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
($PHP_DEV artisan down) || true

cd "$REPO_DIR"

# Pull the latest version of the app
git pull origin develop

# Install composer dependencies (nel container, dal lock esistente)
$COMPOSER_DEV install --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
$PHP_DEV artisan migrate:fresh --force --seed

# Clear caches
$PHP_DEV artisan cache:clear

# Clear and cache routes
$PHP_DEV artisan route:clear
$PHP_DEV artisan route:cache

# Clear and cache config
$PHP_DEV artisan config:clear
$PHP_DEV artisan config:cache

# Clear the old cache
$PHP_DEV artisan clear-compiled

$COMPOSER_DEV dump-autoload
$PHP_DEV artisan optimize

# Exit maintenance mode
$PHP_DEV artisan up

echo "Deployment finished!"
