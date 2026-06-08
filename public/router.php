<?php

// On vérifie si on est en CLI (php -S) pour servir les fichiers statiques
if (php_sapi_name() === 'cli-server') {
    $path = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($path)) {
        return false;
    }
}

// Sinon, on charge index.php
require __DIR__ . '/index.php';
