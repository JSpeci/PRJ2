<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;

/**
 * Description of LogStavuController
 *
 * @author King
 */
class LogStavuController extends ApiController {

    protected $log_service;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->log_service = $container->LogStavuService;
    }

    /**
     * Vsechny obj
     */
    public function getAllLogStavu(Request $request, Response $response, array $args) {
        $uzivatele = $this->log_service->getAllLogStavu();
        $response->getBody()->write(json_encode($uzivatele, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * LogStavu podle zadaneho id
     */
    public function getLogStavuDetailById(Request $request, Response $response, array $args) {
        $id = $args["id"];  //important "" not ''
        $o = $this->log_service->getLogStavuDetailById($id);
        $response->getBody()->write(json_encode($o, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Ulozeni noveho
     */
    public function saveNewLogStavu(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        $saved_o = $this->log_service->saveNewLogStavu($body);
        if ($saved_o == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($saved_o, JSON_UNESCAPED_UNICODE));
        }
    }

}
