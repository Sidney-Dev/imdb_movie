<?php

require_once __DIR__ . '/vendor/autoload.php';

use Core\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = Database::connection();

$migrations = glob(__DIR__ . '/migrations/*.php');
sort($migrations);

foreach ($migrations as $migration) {
    echo "Running: " . basename($migration) . PHP_EOL;
    $run = require $migration;
    $run($pdo);
}
