# oc:8845 — motore PHP patchato PHP2Shell (CVE-2026-109618/109619)
# Pin esatto: mai tag mobile (un rebuild senza --pull sarebbe un no-op silenzioso).
FROM php:8.2.35-fpm

# Dipendenze per le estensioni richieste dal codice (dossier oc:8845):
# pdo_pgsql/pgsql (DB), gd (phpspreadsheet/Nova thumbnails), zip (maatwebsite/excel),
# pdo_sqlite (tntsearch). postgresql-client per psql/pg_dump usati dai comandi
# Dump/Download/RestoreDbCommand. git+unzip per composer.
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libpng-dev \
        libzip-dev \
        libsqlite3-dev \
        postgresql-client \
        git \
        unzip \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer: binario ufficiale. Nessun COPY del codice né di auth.json:
# composer gira sul codice montato, l'immagine contiene solo PHP ed estensioni.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY php/zz-security.ini /usr/local/etc/php/conf.d/zz-security.ini

# I pool (prod/dev) vengono montati dal compose: l'immagine resta unica.
# Via i pool di default dell'immagine (www + il [www] di docker.conf): in rete host
# collidarebbero su 9000 col pool prod. Le direttive globali tornano con global.conf.
RUN rm -f /usr/local/etc/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf.default /usr/local/etc/php-fpm.d/docker.conf
COPY php-fpm/global.conf /usr/local/etc/php-fpm.d/aa-global.conf
