<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db']['host']   = 'sql.endora.cz:3306';
$config['db']['user']   = 'libtaxicz';
$config['db']['pass']   = '8Dek5koh6';
$config['db']['dbname'] = 'libtaxidb';

$app = new \Slim\App(['settings' => $config]);


require '../app/routes/routes.php';

//middleware - check APIkey
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

//Dependency injection container

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['UzivatelController'] = function($c) {
    return new UzivatelController($c);
};





