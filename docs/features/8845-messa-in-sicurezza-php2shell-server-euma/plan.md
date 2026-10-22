> Ticket: oc:8845

# Messa in sicurezza PHP2Shell sul server euma — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Portare il motore PHP di euma da mod_php 8.1 (host, vulnerabile PHP2Shell) a `php:8.2.35-fpm` in container su prod e dev, con pool FPM ripulito, deploy riallineato e verifica di compromissione.

**Architecture:** Container FPM in `network_mode: host` sul server (Postgres 12 e Meilisearch restano su `127.0.0.1`, zero rebind); vhost Apache su `proxy_fcgi`; mod_php disabilitato per sempre; `eumatest` → 410. In locale, compose su bridge con PostGIS 12 + Meilisearch per la verifica su dump di prod.

**Tech Stack:** Laravel 9 / Nova 4.32.6, PHP 8.2.35-fpm, Apache 2.4.41 (host), PostgreSQL 12.22 + PostGIS (host), Meilisearch (processo host), Docker Compose.

**Spec:** `docs/features/8845-messa-in-sicurezza-php2shell-server-euma/overview.md`

## Global Constraints

- Commit convention: `feat(oc:8845): ...` / `fix(oc:8845): ...`. **I commit sono istruzioni per il dev: nessun commit/push/branch senza sua conferma esplicita, uno per uno.**
- Ordine vincolante sul server: snapshot → evidenze fuori macchina → patch. Backup puntuale di ogni file server prima di modificarlo.
- Verifica del motore sempre con `php -v` **dentro** il container; build sempre con `--pull`.
- `auth.json` mai nei layer dell'immagine; composer gira sul codice montato.
- Nessun `composer update`: solo `composer install` dal lock esistente.
- Il codice nel container è montato allo stesso path assoluto dell'host.
- Nessun push su develop/main finché gli script di deploy non sono riallineati.
- FPM solo su `127.0.0.1` (9000 prod, 9001 dev); zero porte nuove esposte.

## Review Focus

- POST `Transfer-Encoding: chunked` senza `Content-Length` supera la guard 413 → deve comunque morire sui limiti FPM senza uccidere il worker (Task 2: test `php-fpm -tt` + POST chunked in smoke locale).
- Richiesta a `eumatest.webmapp.it` dopo lo spegnimento → 410, mai contenuto di prod (Task 8: smoke esterno con `curl -H "Host:"`).
- `pg_dump` del backup pre-deploy che si connette ma dumpa vuoto → lo script deve fallire su dump sotto una soglia minima (Task 5: check dimensione nel nuovo `deploy_prod.sh`).
- Upload Nova oltre il limite scelto → 413 pulito e worker vivo (Task 7/8: POST oversize negli smoke).
- Artisan via cron/CLI dell'host dopo la migrazione (se mai aggiunto) userebbe PHP 8.1 → gli script riallineati sono l'unica via documentata per artisan (Task 5: commento in testa agli script).

---

### Task 1: Misura dei dati reali e scelta dei limiti upload

**Files:**
- Modify: `docs/features/8845-messa-in-sicurezza-php2shell-server-euma/notes.md` (sezione Decisioni)

**Interfaces:**
- Produces: valori `upload_max_filesize` / `post_max_size` usati dal Task 2.

- [x] **Step 1: Misura sul server (sola lettura)**

Run: `ssh euma 'find /var/www/html/database.european-mountaineers.eu/storage/app -type f -printf "%s\n" 2>/dev/null | sort -n | tail -5; find /var/www/html/database.european-mountaineers.eu/public/member -type f -printf "%s\n" 2>/dev/null | sort -n | tail -5'`
Expected: lista delle dimensioni massime reali dei file caricati (icone PNG, xlsx import).

- [x] **Step 2: Scegli i limiti**

Regola: limite ≥ 2× il massimo reale osservato, arrotondato alla potenza comoda (gli upload euma sono PNG icona e xlsx: attesi pochi MB → candidati `16M`/`32M`, stile oc:8843). Registra misura e scelta in `notes.md`.

### Task 2: Dockerfile e pool FPM nel repo

**Files:**
- Create: `docker/Dockerfile`
- Create: `docker/php-fpm/prod.conf`, `docker/php-fpm/dev.conf`
- Create: `docker/php/zz-security.ini`

**Interfaces:**
- Produces: immagine `euma-phpfpm:8.2.35` (build context `docker/`); pool `euma-prod` su `127.0.0.1:9000`, pool `euma-dev` su `127.0.0.1:9001`.

- [x] **Step 1: Scrivi `docker/Dockerfile`**

Base `php:8.2.35-fpm` (pin esatto). Estensioni: `pdo_pgsql pgsql gd zip pdo_sqlite` (+ `sqlite3` già nel core), via `docker-php-ext-install` con le lib di build (`libpq-dev libpng-dev libzip-dev libsqlite3-dev`). Pacchetti: `postgresql-client git unzip`. Composer copiato da `composer:2`. Nessun `COPY` del codice né di `auth.json`.

- [x] **Step 2: Scrivi i pool e l'ini**

`prod.conf`: pool `euma-prod`, `listen = 127.0.0.1:9000`, user www-data. `dev.conf`: pool `euma-dev`, `listen = 127.0.0.1:9001`. `zz-security.ini`: `session.upload_progress.enabled=off`, `expose_php=off`, `upload_max_filesize` e `post_max_size` dal Task 1, `memory_limit=512M`.

- [x] **Step 3: Build locale e verifica**

Run: `docker build --pull -t euma-phpfpm:8.2.35 docker/ && docker run --rm euma-phpfpm:8.2.35 php -v && docker run --rm euma-phpfpm:8.2.35 php -m | grep -E "pdo_pgsql|gd|zip|pdo_sqlite" && docker run --rm euma-phpfpm:8.2.35 which psql pg_dump`
Expected: `PHP 8.2.35`, le 4 estensioni elencate, path di psql e pg_dump.

- [x] **Step 4: Verifica config FPM**

Run: `docker run --rm -v $PWD/docker/php-fpm/prod.conf:/usr/local/etc/php-fpm.d/zz-pool.conf euma-phpfpm:8.2.35 php-fpm -tt`
Expected: `configuration file ... test is successful`.

- [x] **Step 5: Commit (chiedere conferma al dev)**

`feat(oc:8845): add php 8.2.35 fpm image and hardened pools`

### Task 3: Compose locale e per il server

**Files:**
- Create: `local.compose.yml` (PostGIS 12 + Meilisearch + phpfpm su bridge, per la verifica locale)
- Create: `server.compose.yml` (solo phpfpm, `network_mode: host`, `restart: unless-stopped`)
- Modify: `docker-compose.yml` resta com'è (Meilisearch locale storico) — nessuna modifica se non un commento di rimando.

**Interfaces:**
- Consumes: immagine del Task 2.
- Produces: servizio `phpfpm` (server) montato su `/var/www/html/<vhost>` allo stesso path host; servizio locale `php` + `postgis` (postgis/postgis:12-3.x) + `meilisearch`.

- [x] **Step 1: Scrivi `server.compose.yml`**

Due servizi dall'immagine del Task 2: `phpfpm_prod` (pool prod, volume `/var/www/html/database.european-mountaineers.eu:/var/www/html/database.european-mountaineers.eu`) e `phpfpm_dev` (pool dev, volume analogo su `dev.eumadb.webmapp.it`); entrambi `network_mode: host`, `restart: unless-stopped`.

- [x] **Step 2: Scrivi `local.compose.yml`**

`postgis` (postgis/postgis:12-3.4, env eumadb), `meilisearch` (come compose attuale), `php` (immagine Task 2, volume `.:/var/www/html/euma`, bridge). In locale `.env` punta a `DB_HOST=postgis`, `MEILISEARCH_HOST=http://meilisearch:7700`.

- [x] **Step 3: Validazione sintassi**

Run: `docker compose -f local.compose.yml config -q && docker compose -f server.compose.yml config -q`
Expected: nessun output (exit 0).

- [x] **Step 4: Commit (chiedere conferma al dev)**

`feat(oc:8845): add local and server compose for containerized fpm`

### Task 4: Verifica locale su dump di produzione

**Files:**
- Modify: `docs/features/8845-messa-in-sicurezza-php2shell-server-euma/notes.md` (esiti)

**Interfaces:**
- Consumes: compose locale del Task 3.

- [x] **Step 1: Recupera il dump di prod**

Via `scp` dall'host (`~/backup/<ultima data>.backup.gz`, prodotto dal deploy) — più diretto del giro S3 `wmdumps`.

- [x] **Step 2: Restore nel PostGIS locale**

Run: `docker compose -f local.compose.yml up -d postgis && gunzip -c <dump>.gz | docker compose -f local.compose.yml exec -T postgis psql -U postgres eumadb` (prima `create extension postgis` se il dump non la porta).
Expected: restore senza errori fatali.

- [x] **Step 3: App su 8.2.35 con dati veri**

Run: `docker compose -f local.compose.yml up -d && docker compose -f local.compose.yml exec php composer install && docker compose -f local.compose.yml exec php php artisan config:clear`, poi smoke: home via FPM, `php artisan tinker --execute='App\Models\Trail::count()'`.
Expected: nessun errore di estensione/deprecation fatale; count coerente col dump.

- [x] **Step 4: Registra l'esito in `notes.md`** (incompatibilità trovate, o «nessuna»).

### Task 5: Riallineamento deploy (script + workflow)

**Files:**
- Modify: `scripts/deploy_dev.sh`, `scripts/deploy_prod.sh`
- Modify: `.github/workflows/dev_deploy.yml`, `.github/workflows/prod_deploy.yml`

**Interfaces:**
- Consumes: servizio `phpfpm_*` di `server.compose.yml` (Task 3). Alias di esecuzione: `docker compose -f server.compose.yml exec -T phpfpm_<env> php ...`.

- [x] **Step 1: Riscrivi `deploy_prod.sh`**

`pg_dump` resta host-side (invariato) ma con check: dump < 1MB ⇒ `exit 1`. Tutte le chiamate `php`/`composer` passano al container `phpfpm_prod` (`docker compose ... exec -T`). Rimuovi `php artisan nova:install` commentato. Commento in testa: «artisan solo via container, mai col PHP host».

- [x] **Step 2: Riscrivi `deploy_dev.sh`**

Stesso schema su `phpfpm_dev`. **Rimuovi** `cd vendor/laravel/nova && npm install` (righe 37-39). Mantieni `migrate:fresh --force --seed` (comportamento storico di dev).

- [x] **Step 3: Aggiorna i workflow**

In entrambi: `php-version: "8.2"`; `postgis/postgis:12-3.4` al posto di `postgis/postgis:10-2.5`. Lo step SSH di deploy resta identico (gli script ora sono container-aware).

- [x] **Step 4: Verifica statica**

Run: `bash -n scripts/deploy_dev.sh scripts/deploy_prod.sh && grep -c "npm" scripts/deploy_dev.sh`
Expected: exit 0 e `0` occorrenze npm.

- [x] **Step 5: Commit (chiedere conferma al dev)**

`feat(oc:8845): realign deploy scripts and CI to containerized php 8.2`

### Task 6: Preparazione server — snapshot, evidenze, immagine

**Files:** nessuno nel repo (operazioni server; esiti in `notes.md`).

- [x] **Step 1: Snapshot Hetzner** — lo avvia il dev dal pannello; si aspetta il completamento prima di toccare qualsiasi cosa.
- [x] **Step 2: Evidenze fuori macchina** — `tar` di `/var/log/apache2` (rotazioni dal 20/10 incluse), `crontab -l` di root/www-data, `ls -laR /tmp`, elenco processi; `scp` in locale sotto `~/evidenze-8845/` (fuori dal repo).
- [x] **Step 3: Backup puntuale dei file che verranno toccati** — `tar` di `/etc/apache2/sites-available`, `mods-enabled`, conf PHP; copia fuori macchina.
- [x] **Step 4: Docker sul server** — verifica `docker --version`; se assente, installa docker-ce + compose plugin (conferma dev prima di installare).
- [x] **Step 5: Porta repo e immagine sul server** — `git fetch` del branch feature nelle due webroot **senza checkout** (il checkout avviene nei Task 7/8 per ambiente); build `--pull` dell'immagine da `docker/`; `docker save euma-phpfpm:8.2.35 | gzip` e `scp` fuori host.

### Task 7: Migrazione di dev (`dev.eumadb.webmapp.it`)

**Files:** server (vhost, container); esiti in `notes.md`.

- [x] **Step 1: Checkout del branch feature nella webroot di dev** e `composer install` **nel container** (primo avvio con `docker compose -f server.compose.yml up -d phpfpm_dev`).
- [x] **Step 2: Switch vhost** — backup del vhost, poi `SetHandler "proxy:fcgi://127.0.0.1:9001"` per i `.php`, disattiva mod_php **solo quando anche prod è pronto a migrare** (mod_php e proxy_fcgi convivono per vhost fino al Task 8); `apachectl configtest && systemctl reload apache2`.
- [x] **Step 3: Smoke dev** — `curl -sI https://dev.eumadb.webmapp.it/` → 200; `docker compose -f server.compose.yml exec phpfpm_dev php -v` → 8.2.35; header `x-powered-by` assente; POST oversize → 413; pagina login Nova carica gli asset.
- [x] **Step 4: Registra esito in `notes.md`.**

### Task 8: Migrazione di prod + eumatest + mod_php off

**Files:** server; esiti in `notes.md`.

- [x] **Step 1: 503 statico** — attiva la pagina di manutenzione con `Retry-After: 600` sul vhost prod.
- [x] **Step 2: Checkout branch + `composer install` nel container prod**; `config:clear` + `optimize` via container.
- [x] **Step 3: Switch vhost prod** su `proxy:fcgi://127.0.0.1:9000`; `a2dismod php8.1` (mod_php muore qui, per tutti); vhost `eumatest.webmapp.it` sostituito con risposta fissa `410` senza PHP; `apachectl configtest && systemctl reload apache2`; rimuovi il 503.
- [x] **Step 4: Smoke prod** — `curl -sI https://database.european-mountaineers.eu/` → 200; `php -v` nel container → 8.2.35; `curl -sI -H "Host: eumatest.webmapp.it" https://157.90.232.94/ -k` → 410; POST oversize → 413; ricerca Meilisearch dal sito funzionante; niente `x-powered-by`.
- [x] **Step 5: Guard rewrite oversize** — regola `RewriteCond %{HTTP:Content-Length} > <limite>` → 413 su entrambi i vhost (Apache 2.4.41: `LimitRequestBody` inefficace sulle richieste proxate).

### Task 9: Verifica di compromissione

**Files:** esiti in `notes.md` (e nel ticket); **non nel repo pubblico se emergono evidenze**.

- [x] **Step 1: Analisi evidenze** — sui log raccolti al Task 6: pattern PHP2Shell (`auto_prepend_file`, `allow_url_include`, `php://input`, `%AD`) con esito 2xx; file PHP nuovi/modificati dal 20/10 nelle webroot, `storage/`, `/tmp`; cron, utenti, `authorized_keys`, processi anomali.
- [x] **Step 2: Esito negativo** → si registra «nessuna evidenza» con il dettaglio dei controlli; **esito positivo** → scatta il requisito condizionale: bonifica + rotazione segreti prima di dichiarare chiuso (si ferma il piano e si decide col dev).

### Task 10: Chiusura — merge, notes, ticket

**Files:**
- Modify: `docs/features/8845-messa-in-sicurezza-php2shell-server-euma/notes.md`

- [x] **Step 1: Verifica che i rimandi divergenza plan↔notes funzionino** (script `comm` della skill).
- [ ] **Step 2: PR verso `develop`** (conferma dev), poi allineamento `main` (il deploy prod parte da main: coordinarsi col dev — nessun push senza conferma).
- [ ] **Step 3: Censimento host in oc:8835** — `update_story` con `prepend`: euma (157.90.232.94, Hetzner) — Ubuntu 20.04.4 focal fuori supporto, no Ubuntu Pro, ufw inattivo, OpenSSH datato, Postgres 12 locale (vincolo upgrade OS, come pap). Anteprima + conferma dev.
- [ ] **Step 4: Checklist wm-plan** — update-context, bozze note dev + risposta cliente, status ticket (proposto: `done` dopo smoke; decide il dev).
