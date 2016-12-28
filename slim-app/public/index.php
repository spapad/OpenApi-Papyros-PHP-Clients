<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

$autoloader = require __DIR__ . '/../vendor/autoload.php';

session_name('MineduOsteamApp');
session_start();

date_default_timezone_set('Europe/Athens');

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

//
// setup the app 
//
$container['autoloader'] = $autoloader;
$autoloader->addPsr4('Gr\\Gov\\Minedu\\Osteam\\', __DIR__ . '/../src/osteam');
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['response']->withJson([
                'message' => 'Προέκυψε λάθος',
                'in' => $exception->getMessage()
                ], $exception->getCode()
        );
    };
};
//
// end setup the app
//
// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
