<?php

require_once __DIR__ . '/../autoload.php';

use CarClub\Router;

$router = new Router();

$router->resolveRequest();
