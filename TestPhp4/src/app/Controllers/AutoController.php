<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;

use App\Services\AutoService;

/**
 * Description of AutoController
 *
 * @author King
 */
class AutoController extends ApiController {

    protected $auto_service;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->auto_service = $container->AutoService;
    }

    /**
     * Vsechny auta
     */
    public function getAllAuto(Request $request, Response $response, array $args) {
        $uzivatele = $this->auto_service->getAllAuto();
        $response->getBody()->write(json_encode($uzivatele, JSON_UNESCAPED_UNICODE));
        return $response;
    }
    
        /**
     * Auto podle zadaneho id
     */
    public function getAutoDetailById(Request $request, Response $response, array $args) {
        $id = $args["id"];  //important "" not ''
        $a = $this->auto_service->getAutoById($id);
        $response->getBody()->write(json_encode($a, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Ulozeni noveho
     */
    public function saveNewAuto(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        $saved_a = $this->auto_service->saveNewAuto($body);
        if ($saved_a == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($saved_a, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Put Patch existujiciho
     */
    public function updateAuto(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $updated_d = $this->auto_service->updateAuto($request->getParsedBody(), $id);
        if ($updated_d == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($updated_d, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Delete request
     */
    public function deleteAuto(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $deleted_d = $this->auto_service->deleteAuto($id);
        if ($deleted_d == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($deleted_d, JSON_UNESCAPED_UNICODE));
        }
    }

}
