<?php

use App\Services\UzivatelService;
use App\Services\RoleUzivateleService;
use App\Services\DochazkaService;
use App\Services\AutoService;
use App\Services\StavUzivateleService;
use App\Services\TypPraceUzivateleService;
use App\Services\ObjednavkaService;
use App\Services\StavObjednavkyService;
use App\Services\LogStavuService;

require '../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db']['host'] = 'sql.endora.cz:3306';
$config['db']['user'] = 'libtaxicz';
$config['db']['pass'] = '8Dek5koh6';
$config['db']['dbname'] = 'libtaxidb';

$app = new \Slim\App(['settings' => $config]);


require '../app/routes/routes.php';

/*//middleware - check APIkey
$mw = function ($request, $response, $next) {
    $uri = $request->getUri();

    //Before
    //$response->getBody()->write($uri);

    $response = $next($request, $response);
    //$response->getBody()->write('AFTER');
    return $response->withHeader(
                    'Content-Type', 'application/json'
    );
};

$app->add($mw);
*/
//Dependency injection container

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('./', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};


// pair controller and service class
$container['AutoService'] = function($c) {
    return new AutoService($c);
};

$container['ObjednavkaService'] = function($c) {
    return new ObjednavkaService($c);
};

$container['StavUzivateleService'] = function($c) {
    return new StavUzivateleService($c);
};

$container['StavObjednavkyService'] = function($c) {
    return new StavObjednavkyService($c);
};

$container['LogStavuService'] = function($c) {
    return new LogStavuService($c);
};


$container['TypPraceUzivateleService'] = function($c) {
    return new TypPraceUzivateleService($c);
};

$container['DochazkaService'] = function($c) {
    return new DochazkaService($c);
};

$container['RoleUzivateleService'] = function($c) {
    return new RoleUzivateleService($c);
};

$container['UzivatelService'] = function($c) {
    return new UzivatelService($c);
};


$container['UzivatelController'] = function($c) {
    return new UzivatelController($c);
};

$container['DochazkaController'] = function($c) {
    return new DochazkaController($c);
};

$container['OthersController'] = function($c) {
    return new OthersController($c);
};






