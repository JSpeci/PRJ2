<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use App\Services\ObjednavkaService;

/**
 * Description of ObjednackaController
 *
 * @author King
 */
class ObjednavkaController extends ApiController {

    protected $obj_service;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->obj_service = $container->ObjednavkaService;
    }
    
    /**
     * Vsechny obj
     */
    public function getAllObjednavka(Request $request, Response $response, array $args) {
        $uzivatele = $this->obj_service->getAllObjednavka();
        $response->getBody()->write(json_encode($uzivatele, JSON_UNESCAPED_UNICODE));
        return $response;
    }
    
        /**
     * Objednavka podle zadaneho id
     */
    public function getObjednavkaDetailById(Request $request, Response $response, array $args) {
        $id = $args["id"];  //important "" not ''
        $o = $this->obj_service->getObjednavkaDetailById($id);
        $response->getBody()->write(json_encode($o, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Ulozeni noveho
     */
    public function saveNewObjednavka(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        $saved_o = $this->obj_service->saveNewObjednavka($body);
        if ($saved_o == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($saved_o, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Put Patch existujiciho
     */
    public function updateObjednavka(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $updated_o = $this->obj_service->updateObjednavka($request->getParsedBody(), $id);
        if ($updated_o == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($updated_o, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Delete request
     */
    public function deleteObjednavka(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $deleted_o = $this->obj_service->deleteObjednavka($id);
        if ($deleted_o == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($deleted_o, JSON_UNESCAPED_UNICODE));
        }
    }

}
