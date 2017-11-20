<?php

$container = $app->getContainer();

/** Database dependencies */
$container['db'] = function ($container) {
    $database = new Cahkampung\Landadb(Db());
    return $database;
};


$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('public', [
        'cache' => false,
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));
    $view['baseUrl'] = $c['request']->getUri()->getBaseUrl();
    $view['imageUrl'] = getenv('SITE_IMG');
    return $view;
};

//set_error_handler(function ($severity, $message, $file, $line) {
//    if (!(error_reporting() & $severity)) {
//        // This error code is not included in error_reporting, so ignore it
//        return;
//    }
//    throw new \ErrorException($message, 0, $severity, $file, $line);
//});

