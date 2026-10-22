> Ticket: oc:8845

# Notes — Messa in sicurezza PHP2Shell sul server euma

## Deviazioni dal piano

(nessuna finora)

## Bug trovati

- **`php artisan serve` scavalca gli override di ambiente del compose** (Task 4): il
  comando rilegge il `.env` e lo inietta nell'ambiente del processo figlio `php -S`,
  quindi nel container l'app puntava a `DB_HOST=127.0.0.1` (500 su ogni login) anche
  con `DB_HOST=postgis` correttamente presente nell'env di PID 1. Fix: `php -S -t
  public docker/local-router.php` al posto di `artisan serve` in `local.compose.yml`.
  Secondo sintomo correlato: senza `-t public` gli asset Nova andavano in 404
  (schermata bianca).

## Decisioni

- **Limiti upload FPM: 16M/32M** (Task 1). Misura reale su prod (23/10): file più
  grande in `storage/app` escluso `last_dump.sql` (dump DB interno, 179MB, non un
  upload HTTP) = geojson 2,6MB da import artisan; `public/member` vuoto. Gli upload
  HTTP sono PNG icona e xlsx, pochi MB: 16M/32M è ≥2× il massimo osservato, stesso
  schema di oc:8843.
- **eumatest.webmapp.it si spegne** (challenge/dialogo): vhost minimale a risposta
  fissa 410, niente migrazione — come geomixer2 su oc:8837.
- **Verifica locale su dump di produzione**, non su seed (dialogo, scelta delegata al
  piano).
- **Finestra prod = subito** (notte del 23/10, fuori orario d'ufficio): la mitigazione
  interim su mod_php non serve perché l'intervento è contestuale.
- **Nessuna rotazione segreti senza evidenze** (decisione dev); requisito condizionale:
  evidenze di exploit riuscito ⇒ bonifica + rotazione prima di riaprire.
- **Niente freeze dei workflow GitHub**: i push li fa solo il dev, che non pusha fino a
  riallineamento deploy completato.
- **Rete container: `network_mode: host`** (challenge, Rischio 4): Postgres e
  Meilisearch restano su 127.0.0.1, zero rebind, FPM su 127.0.0.1:9000/9001.
- **Step `cd vendor/laravel/nova && npm install` rimosso dal deploy di dev** (challenge,
  Rischio 5): residuo senza effetto (`npm run prod` già commentato); eventuali asset con
  `nova:publish`.
- **Stima saltata** su richiesta esplicita del dev («salta stima e associazione tag»);
  fasi tag-ambiente e tag-contenuto saltate per lo stesso motivo (il ticket è stato
  comunque associato al tag php2shell, parte della strategia).
- **Trascrizioni delle call**: consultate per il contesto generale (EUMA mai nominata
  nelle call del 22/10); approfondimento saltato su richiesta del dev.

## Verifica di compromissione (Task 9, 23/10)

**Esito: nessuna evidenza di compromissione.** Dettaglio dei controlli:

- 67 richieste con pattern exploit (`auto_prepend_file`, `allow_url_include`,
  `php://input`, `%AD`; scanner `libredtail-http`) hanno avuto 2xx, ma tutte sul
  **vhost di default via IP**, dove `index.php` era un `phpinfo()` (risposte ~86KB =
  output phpinfo, ~11KB = index.html statico). Campagna attiva dal 9/10, prima del leak
  PHP2Shell (20/10): è il vettore CGI storico, inefficace su mod_php — i parametri
  iniettati non hanno avuto effetto. Sul vhost del sito gli stessi pattern: solo
  404/405. Zero 2xx riconducibili a esecuzione del payload.
- Nessun file `.php` nuovo o modificato dal 1/10 in webroot, `storage/`, docroot;
  `/tmp` pulito; nessun cron root/www-data; processi regolari (meilisearch, mysqld,
  uuidd); utenti con shell: solo root, postgres, meilisearch.
- Il requisito condizionale (bonifica + rotazione) **non scatta**.

**Esposizione emersa e chiusa (con ok del dev):** il vhost di default serviva via IP
il phpinfo e gli zip di backup del vecchio sito 2022 (`eumaweb-*.zip`, scaricabili).
Fix: vhost di default → `Require all denied` (403 su tutto; originale salvato in
`/root/000-default.conf.pre-8845`), zip spostati in `/root/eumaweb-zip-2022/`.

## Follow-up

- Upload autenticato end-to-end via Nova non collaudato (scelta dev, come nei gemelli).
- PHP 8.2 EOL 31/12/2026: aprire ticket dedicato per upgrade a 8.3/8.4 + Laravel 10/11.
- Host in oc:8835 (focal fuori supporto, no Ubuntu Pro, ufw inattivo, OpenSSH datato,
  Postgres 12 locale; in più: `mysqld` attivo da censire e 11 chiavi in
  `authorized_keys` di root da attribuire a persone note).
- Gli zip `eumaweb-*.zip` (2022) ora in `/root/eumaweb-zip-2022/`: valutare se
  servono ancora o si cancellano.
- `scripts/deploy_first_prod.sh` e `scripts/deploy_local_with_prod.sh` usano ancora il
  PHP dell'host (rilievo wm-context-guard): da adattare al container o marcare superati.
