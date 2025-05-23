<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use Core\Request;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router();

// Load routes
$router = require_once __DIR__ . '/../app/routes/web.php';

// Dispatch
$router->dispatch(Request::uri(), Request::method());