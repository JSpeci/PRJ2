<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use App\Models\Uzivatel;
use App\Models\RoleUzivatele;
use App\Services\UzivatelService;

/*
  LAYERED STRUCTURE !!!
 * https://www.toptal.com/php/maintain-slim-php-mvc-frameworks-with-a-layered-structure
 * using of controllrs, model, and services class
 */

/**
 * Controller pro Uzivatele
 * Pracuje s tridou UzivatelService
 * Otestovany
 */
class UzivatelController extends ApiController {

    protected $uzivatel_serv;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->uzivatel_serv = $container->UzivatelService;
    }

    /**
     * Vsechny uzivatele uzivatele
     */
    public function getAllUzivatel(Request $request, Response $response, array $args) {
        $uzivatele = $this->uzivatel_serv->getAllUzivatel();
        $response->getBody()->write(json_encode($uzivatele, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Uzivatel podle zadaneho id
     */
    public function getUzivatelDetailById(Request $request, Response $response, array $args) {
        $id = $args["id"];  //important "" not ''
        $u = $this->uzivatel_serv->getUzivatelDetailById($id);
        $response->getBody()->write(json_encode($u, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Ulozeni noveho uzivatele do db
     */
    public function saveNewUzivatel(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        $saved_u = $this->uzivatel_serv->saveNewUzivatel($body);
        if ($saved_u == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($saved_u, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Put Patch existujiciho uzivatele
     */
    public function updateUzivatel(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $updated_u = $this->uzivatel_serv->updateUzivatel($request->getParsedBody(), $id);
        if ($updated_u == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($updated_u, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Delete request
     */
    public function deleteUzivatel(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $deleted_u = $this->uzivatel_serv->deleteUzivatel($id);
        if ($deleted_u == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($deleted_u, JSON_UNESCAPED_UNICODE));
        }
    }

}
