<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;

/**
 * Description of OthersController
 *
 * @author King
 */
class OthersController extends ApiController {

    //Role uzivatele, stav uzivatele a typ prace uzivatel jsou výčty
    //pro ně potřebuji jenom GET metody

    protected $role_service;
    protected $stav_service;
    protected $typPrace_service;
    protected $stav_obj_service;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->typPrace_service = $container->TypPraceUzivateleService;
        $this->stav_service = $container->StavUzivateleService;
        $this->role_service = $container->RoleUzivateleService;
        $this->stav_obj_service = $container->StavObjednavkyService;
    }

    /**
     * Vsechny RoleUzivatele
     */
    public function getAllTypPRaceUzivatele(Request $request, Response $response, array $args) {
        $dochazky = $this->typPrace_service->getAllTypPraceUzivatele();
        $response->getBody()->write(json_encode($dochazky, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Vsechny StavUzivatele
     */
    public function getAllStavUzivatele(Request $request, Response $response, array $args) {
        $dochazky = $this->stav_service->getAllStavUzivatele();
        $response->getBody()->write(json_encode($dochazky, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Vsechny TypPRaceUzivatele
     */
    public function getAllRoleUzivatele(Request $request, Response $response, array $args) {
        $dochazky = $this->role_service->getAllRoleUzivatele();
        $response->getBody()->write(json_encode($dochazky, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    /**
     * Vsechny TypPRaceUzivatele
     */
    public function getAllStavObjednavky(Request $request, Response $response, array $args) {
        $dochazky = $this->stav_obj_service->getAllStavObjednavky();
        $response->getBody()->write(json_encode($dochazky, JSON_UNESCAPED_UNICODE));
        return $response;
    }

}
