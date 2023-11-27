## Meilisearch

per .env locale inserire:

```
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=masterKey
```

lanciare il comando:

```
docker compose up -d
```

```
php artisan scout:import "App\Models\ClimbingRockArea"
php artisan scout:import "App\Models\Hut"
php artisan scout:import "App\Models\Trail"
php artisan scout:import "App\Models\Member"
```
