<?php
namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;

use App\Services\DochazkaService;

/**
 * Description of DochazkaController
 *
 * @author King
 */
class DochazkaController extends ApiController {

    protected $dochazka_service;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->dochazka_service = $container->DochazkaService;
    }

    /**
     * Vsechny 
     */
    public function getAllDochazka(Request $request, Response $response, array $args) {
        $dochazky = $this->dochazka_service->getAllDochazka();
        
        $response->getBody()->write(json_encode($dochazky, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Dochazka podle zadaneho id
     */
    public function getDochazkaDetailById(Request $request, Response $response, array $args) {
        $id = $args["id"];  //important "" not ''
        $d = $this->dochazka_service->getDochazkaDetailById($id);
        $response->getBody()->write(json_encode($d, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Ulozeni noveho
     */
    public function saveNewDochazka(Request $request, Response $response, array $args) {
        $body = $request->getParsedBody();
        $saved_d = $this->dochazka_service->saveNewDochazka($body);
        if ($saved_d == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($saved_d, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Put Patch existujiciho
     */
    public function updateDochazka(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $updated_d = $this->dochazka_service->updateDochazka($request->getParsedBody(), $id);
        if ($updated_d == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($updated_d, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Delete request
     */
    public function deleteDochazka(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $deleted_d = $this->dochazka_service->deleteDochazka($id);
        if ($deleted_d == null) {
            return $response->withStatus(400);
        } else {
            return $response->getBody()->write(json_encode($deleted_d, JSON_UNESCAPED_UNICODE));
        }
    }
}
