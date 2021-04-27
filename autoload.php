<?php

$classes = [
    'Router.php',
    'routes.php',
    'Controllers/BaseController.php',
    'Controllers/HomepageController.php',
    'Controllers/NameController.php',
    'Helpers/Input.php',
    'helpers.php'
];

foreach ($classes as $class) {
    /** @noinspection PhpIncludeInspection */
    require_once $class;
}
