<?php

// oc:8845 — router per il server PHP built-in nell'ambiente locale containerizzato.
// Si usa php -S al posto di `artisan serve` perché quest'ultimo rilegge il .env e lo
// inietta nell'ambiente del figlio, scavalcando gli override del compose (DB_HOST ecc.).

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/../public' . $path;

if ($path !== '/' && is_file($file)) {
    return false; // file statico: lo serve php -S
}

require __DIR__ . '/../public/index.php';
