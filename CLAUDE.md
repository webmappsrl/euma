# euma

Database EUMA (European Union of Mountaineering Associations): Laravel 9 + Nova 4,
PostgreSQL/PostGIS, Meilisearch. Prod: database.european-mountaineers.eu; dev:
dev.eumadb.webmapp.it (stesso server, host «euma»).

## Regole del repo

- Sul server, `php`/`composer` si eseguono solo nel container FPM
  (`server.compose.yml`), mai col PHP dell'host; il deploy passa da
  `scripts/deploy_dev.sh` / `deploy_prod.sh`.
- I commit usano lo scope del ticket Orchestrator: `feat(oc:<ID>): ...`.
- La documentazione in `docs/` è in italiano.

## Comandi

- Ambiente locale: `docker compose -f local.compose.yml up -d` (app su
  http://127.0.0.1:8008, PostGIS su 5439, Meilisearch su 7708).
- Test: `php artisan test` (nel container locale:
  `docker compose -f local.compose.yml exec php php artisan test`).

## Trappole

- Avvio dell'ambiente locale: mai `artisan serve` — vedi
  [docs/knowledge/messa-in-sicurezza-php2shell-server-euma.md](docs/knowledge/messa-in-sicurezza-php2shell-server-euma.md).

## Conoscenza

| Argomento | Cosa copre | Pagina |
|---|---|---|
| Messa in sicurezza PHP2Shell | Motore PHP in container, rete host, vincoli deploy e upload | [docs/knowledge/messa-in-sicurezza-php2shell-server-euma.md](docs/knowledge/messa-in-sicurezza-php2shell-server-euma.md) |
