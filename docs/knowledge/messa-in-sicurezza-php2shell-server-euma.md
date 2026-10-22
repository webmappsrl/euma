# Messa in sicurezza PHP2Shell sul server euma

## Come funziona oggi

Il motore PHP di euma gira in container: immagine e orchestrazione sono in
`docker/Dockerfile` e `server.compose.yml` (rete host, pool su loopback, codice montato
allo stesso path assoluto dell'host). Sul server, i vhost Apache di prod e dev
instradano i `.php` via `proxy_fcgi` ai pool del container; **mod_php è disabilitato**.
`eumatest.webmapp.it` è spento (risposta fissa 410) e il vhost di default via IP
risponde 403 su tutto. Vincoli:

- `php`/`composer` sul server si eseguono **solo nel container**: lo fanno
  `scripts/deploy_dev.sh` e `scripts/deploy_prod.sh`; `deploy_first_prod.sh` e
  `deploy_local_with_prod.sh` usano ancora il PHP dell'host e sono da considerare
  superati finché non vengono adattati.
- Limiti upload del pool: 16M/32M (produzione, 2026-10-23: il file più grande in
  `storage/app` è un geojson da import artisan, ~2,6MB; gli upload HTTP sono PNG e
  xlsx di pochi MB).
- Richieste oltre 32MB: 413 dal guard rewrite nei vhost (su Apache 2.4.41
  `LimitRequestBody` non vale sulle richieste proxate).

## Perché così

- **Container al posto del PPA** (oc:8845): per il ramo PHP 8.1 non esiste versione
  corretta per PHP2Shell (CVE-2026-109618/109619) e il PPA ondrej per focal si ferma a
  8.2.28: l'unico modo di avere la 8.2.35 patchata era il container.
- **PHP 8.2 e non 8.4** (oc:8845): Laravel 9 (`^9.19`) e `php ^8.0.2` nel composer.json;
  8.2.35 è la versione corretta più alta compatibile senza upgrade framework.
- **`network_mode: host`** (oc:8845): Postgres e Meilisearch ascoltano solo su
  `127.0.0.1` dell'host; la rete host evita rebind e nuove porte esposte su una macchina
  senza firewall.
- **Niente `composer update` fatto nel passaggio** (oc:8845): il lock resta risolto per
  `php ^8.0.2`; il primo update risolto per 8.2 renderà impossibile tornare al PHP host
  e va dichiarato quando avverrà.

## Come ci siamo arrivati

- **mod_php 8.1 sull'host** (fino a oc:8845, superata): era il setup storico; vulnerabile
  a PHP2Shell senza patch disponibile per quel ramo. Il rollback verso mod_php
  equivarrebbe a tornare vulnerabili: i problemi post-migrazione si risolvono in avanti.
- **`artisan serve` nel compose locale** (oc:8845, scartata): rilegge il `.env` e lo
  inietta nel processo figlio, scavalcando gli override di ambiente del compose — in
  container dava 500 su ogni login. Al suo posto: `php -S` con `docker/local-router.php`
  (bug documentato in
  `docs/features/8845-messa-in-sicurezza-php2shell-server-euma/notes.md`).
