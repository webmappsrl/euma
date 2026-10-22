#!/bin/bash
set -e

# oc:8845 — deploy container-aware: artisan e composer girano SOLO nel container
# phpfpm_prod (PHP 8.2.35), mai col PHP dell'host. pg_dump resta host-side
# (client 12, auth locale).

REPO_DIR="/var/www/html/database.european-mountaineers.eu"
COMPOSE="docker compose -f $REPO_DIR/server.compose.yml"
PHP_PROD="$COMPOSE exec -T phpfpm_prod php"
COMPOSER_PROD="$COMPOSE exec -T phpfpm_prod composer"

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
($PHP_PROD artisan down) || true

# backup database (host-side). Un dump sotto 1MB è un dump rotto: ci si ferma.
echo "create gz backup"
BACKUP_FILE=~/backup/$(date +%Y-%m-%d).backup
pg_dump eumadb > "$BACKUP_FILE"
if [ "$(stat -c%s "$BACKUP_FILE")" -lt 1048576 ]; then
    echo "ERROR: dump sospetto (<1MB), deploy interrotto." >&2
    $PHP_PROD artisan up || true
    exit 1
fi
gzip "$BACKUP_FILE" --force
echo "Clearing old backups. takes only the last 10"
cd ~/backup
rm `ls -t | awk 'NR>10'` -f
cd "$REPO_DIR"

# Pull the latest version of the app
git pull origin main

# Install composer dependencies (nel container, dal lock esistente)
$COMPOSER_PROD install --no-interaction --prefer-dist --optimize-autoloader

# Clear caches
$PHP_PROD artisan config:clear
$PHP_PROD artisan optimize

# Migration
$PHP_PROD artisan migrate --force

# Exit maintenance mode
$PHP_PROD artisan up

echo "Deployment finished!"
