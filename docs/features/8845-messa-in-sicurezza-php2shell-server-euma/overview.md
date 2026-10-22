> Ticket: oc:8845

# Messa in sicurezza PHP2Shell (CVE-2026-109618/109619) sul server euma

## Cosa cambia

Il motore PHP di euma esce dall'host ed entra in un container: oggi i siti girano come
mod_php 8.1.26 dentro Apache (vulnerabile a PHP2Shell, e per il ramo 8.1 non esiste
versione corretta), domani girano su `php:8.2.35-fpm` in container (`network_mode: host`),
con i vhost Apache di prod e dev passati a `proxy_fcgi` e mod_php disabilitato per sempre.
Il terzo vhost, `eumatest.webmapp.it`, viene spento: resta un vhost minimale a risposta
fissa 410, per evitare che le sue richieste cadano sul vhost di prod. Il pool FPM viene
ripulito in modo permanente (`session.upload_progress.enabled=off`, limiti di upload
commisurati ai dati reali) e le richieste oversize ricevono un 413 pulito tramite guard
rewrite. Script di deploy e workflow GitHub vengono adeguati al container. Prima di
toccare il server: snapshot Hetzner e raccolta evidenze; a valle, verifica di
compromissione sulle evidenze raccolte.

## Perché

Il 21/10/2026 sono state pubblicate due vulnerabilità critiche del motore PHP
(«PHP2Shell», CVE-2026-109618/109619, CVSS 9.2): RCE non autenticata, exploit pubblico,
attacchi osservati in rete. La falla è nel motore, non nel codice applicativo. Le versioni
corrette partono da 8.2.35; euma è su 8.1 (nessuna patch per quel ramo) e il PPA ondrej
per focal arriva al massimo a 8.2.28: via apt non si arriva alla versione corretta. Il
container è l'unica strada per avere il motore patchato, ed è lo stesso percorso già
collaudato su portapporta (oc:8843, quadro quasi identico: focal, Apache 2.4.41, mod_php).
Strategia completa nel tag `php2shell` (706); procedura di riferimento
`wm-package/docs/howto/messa-in-sicurezza-php-shard.md` (v1.6.0 — euma non usa
wm-package, la procedura si usa come documento di riferimento).

## Requisiti

- [x] Motore PHP 8.2.35 in container su prod e dev; verifica con `php -v` **dentro** il
      container, mai l'esito della build; build sempre con `--pull`.
- [x] Container FPM in `network_mode: host`: Postgres (12.22) e Meilisearch restano su
      `127.0.0.1` senza alcun rebind né modifica a `pg_hba`; il `.env` dell'app resta
      invariato; FPM ascolta solo su `127.0.0.1:9000` (prod) e `127.0.0.1:9001` (dev);
      `restart: unless-stopped`.
- [x] Il codice è montato nel container **allo stesso path assoluto dell'host**
      (`/var/www/html/...`): cache Laravel (`config:cache`, `route:cache`) e sessioni su
      file restano valide attraverso il confine host/container.
- [x] Vhost Apache di prod (`database.european-mountaineers.eu`) e dev
      (`dev.eumadb.webmapp.it`) su `proxy_fcgi` verso FPM; mod_php disabilitato in modo
      permanente; zero porte nuove esposte.
- [x] Vhost `eumatest.webmapp.it` spento: risposta fissa **410** (vhost minimale senza
      PHP), così le richieste non cadono sul primo vhost definito (prod). Nulla viene
      cancellato.
- [x] Pool FPM: `session.upload_progress.enabled=off`; limiti di upload commisurati ai
      dati reali (misura sugli storage prima di scegliere i valori).
- [x] Oversize: 413 pulito tramite guard rewrite (su Apache 2.4.41 `LimitRequestBody`
      non si applica alle richieste proxate).
- [x] Immagine container con tutto ciò che il codice richiede: estensioni `pdo_pgsql`,
      `gd`, `zip`, `pdo_sqlite`/`sqlite3` (tntsearch) e standard; binari
      `postgresql-client` (`psql`/`pg_dump` usati da Dump/Download/RestoreDbCommand).
      `storage/` segue il codice montato (dischi locali `importer`, `exporter`); il
      disco `wmdumps` è **S3** (`config/filesystems.php:58`): servono le env
      `AWS_DUMPS_*` nel `.env` montato e uscita di rete dal container (garantita dalla
      rete host). **`auth.json` non entra mai nei layer dell'immagine**: composer gira
      nel container sul codice montato (dove `auth.json` già vive), l'immagine contiene
      solo PHP ed estensioni.
- [x] Nessun `composer update` in questo ticket: si installa dal `composer.lock`
      esistente (risolto per `php ^8.0.2`). Il punto di non ritorno verso il PHP 8.1
      dell'host (primo update risolto per 8.2) va dichiarato esplicitamente in
      `notes.md` quando avverrà, non subito.
- [x] Ordine vincolante sul server: snapshot Hetzner → raccolta evidenze fuori dalla
      macchina (log Apache dal 20/10, stato webroot, cron, utenti) → patch. In più,
      **backup puntuale dei file server toccati** (vhost, conf Apache, pool) prima di
      modificarli: il ripristino fine deve essere possibile senza restore dell'intero
      snapshot (che riporterebbe indietro anche i dati).
- [x] Verifica di compromissione sulle evidenze raccolte (pattern exploit nei log con
      esito 2xx, file PHP anomali nelle webroot e in /tmp, cron, utenti,
      `authorized_keys`). **Se emergono evidenze di exploit riuscito, bonifica e
      rotazione dei segreti entrano nel ticket prima di riaprire il sito**; senza
      evidenze, nessuna rotazione (decisione dev).
- [x] Verifica locale prima del server: compose locale con `phpfpm` 8.2.35 + PostGIS
      (immagine allineata a Postgres 12) + Meilisearch, app funzionante su **dump della
      produzione** (comandi del repo).
- [x] Deploy riallineato: `scripts/deploy_dev.sh` e `scripts/deploy_prod.sh` eseguono
      composer/artisan **nel container**; lo step `cd vendor/laravel/nova && npm
      install` viene rimosso (residuo senza effetto: `npm run prod` è già commentato;
      eventuali asset mancanti si pubblicano con `nova:publish`); il backup pre-deploy
      (`pg_dump`) resta **sull'host** (client 12 presente, auth locale). Workflow GitHub
      su PHP 8.2 e PostGIS allineato alla 12. Nessun push fino a riallineamento fatto
      (i push li fa solo il dev).
- [x] Intervento su prod fuori orario d'ufficio con 503 statico e `Retry-After`
      (esecuzione: notte del 23/10, decisa col dev).
- [x] Immagine buildata salvata fuori dall'host (`docker save`) come punto di
      ricostruzione.
- [x] Chiusura con smoke esterno: siti 200, `php -v` 8.2.35 nei container, POST oversize
      → 413, ricerca Meilisearch funzionante, eumatest → 410.
- [ ] Host censito in oc:8835: Ubuntu 20.04.4 focal fuori supporto senza Ubuntu Pro,
      firewall inattivo, OpenSSH datato (key exchange non post-quantum), Postgres 12
      locale (vincolo per l'upgrade OS, come pap).

## Rischi

Dalla Fase: challenge (rischi REALI discussi col dev, mitigazione tra parentesi):

- **Intervallo scoperto prima della patch** (chiuso: l'intervento si esegue subito,
  nessuna mitigazione interim necessaria).
- **Compromissione pregressa che sopravvive alla migrazione**: su maphub (oc:8842) è
  successo davvero. (Verifica di compromissione con piano d'azione condizionale:
  evidenze ⇒ bonifica + rotazione prima di riaprire.)
- **Push durante la migrazione** fa partire il vecchio deploy con PHP host. (I push li
  fa solo il dev; nessun push fino a riallineamento completato.)
- **Raggiungibilità di Postgres/Meilisearch dal container**: entrambi solo su
  `127.0.0.1` host; il rebind notturno «su 0.0.0.0 per far prima» esporrebbe il DB su
  host senza firewall. (`network_mode: host`: zero rebind, zero porte nuove.)
- **Parità estensioni/permessi mod_php→FPM**: differenze emergono solo esercitando
  l'app. (Verifica locale su dump di prod prima del server.)
- **Rollback avvelenato**: tornare a mod_php = tornare vulnerabili; lo snapshot Hetzner
  ripristina l'intero host, dati compresi. (I problemi post-migrazione si risolvono **in
  avanti** — piano B: 503 prolungato; backup puntuale dei file server per il ripristino
  fine; repo e server si revertono insieme o non si revertono.)
- **Cache/sessioni attraverso il confine host/container**. (Mount allo stesso path
  assoluto; sessioni su `file` sopravvivono.)

Ipotetici dichiarati e accettati: guard 413 non scatta su `chunked` senza
`Content-Length`; restart policy e `docker save` coperti a costo zero nei requisiti.

## Out of scope

- Rotazione dei segreti **in assenza di evidenze di compromissione** (decisione dev; il
  caso con evidenze è nel requisito condizionale).
- Collaudo upload autenticato end-to-end via Nova (resta al dev, come nei ticket
  gemelli; va dichiarato nel ticket come «resta aperto»).
- Aggiornamento OS dell'host (focal fuori supporto) → censimento e pianificazione in
  oc:8835.
- Upgrade a PHP 8.3/8.4 con upgrade Laravel 9 → 10/11 (PHP 8.2 va in EOL il
  31/12/2026, tra ~10 settimane: il follow-up va aperto come ticket a sé, non dentro
  questo).
- Rimozione delle versioni PHP stratificate sull'host (5.6→8.1): restano installate e
  inutilizzate, come su oc:8843.

## Moduli toccati

Feature interamente custom, un solo repo (nessun submodule). Tutto in
`webmappsrl/euma`:

- `docker/` (nuovo): Dockerfile `php:8.2.35-fpm` con estensioni e postgresql-client;
  config pool FPM (prod e dev).
- `docker-compose.yml`: servizio phpfpm (`network_mode: host`, `restart:
  unless-stopped`) accanto a Meilisearch, più il compose locale con PostGIS 12 per la
  verifica su dump.
- `scripts/deploy_dev.sh`, `scripts/deploy_prod.sh`: composer/artisan nel container,
  step npm rimosso, `pg_dump` resta host-side.
- `.github/workflows/dev_deploy.yml`, `prod_deploy.yml`: PHP 8.2, PostGIS 12.
- `docs/features/8845-messa-in-sicurezza-php2shell-server-euma/`: artefatti.

Fuori repo (server `euma`, 157.90.232.94): vhost Apache (prod, dev su proxy_fcgi;
eumatest → 410), pool FPM, pagina 503 statica, backup puntuale dei file toccati,
snapshot Hetzner, evidenze.
