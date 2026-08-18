<?php

require_once __DIR__ . '/../src/layouts/image_mapper.php';
require_once __DIR__ . '/../src/layouts/map_mapper.php';
require_once __DIR__ . '/../src/core/Router.php';

$router = new Router();
$router->dispatch();
