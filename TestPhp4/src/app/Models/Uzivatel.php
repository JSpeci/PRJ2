<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Models\RoleUzivatele;

class Uzivatel{
    
    private $id;
    private $nickName;
    private $login;
    private $celeJmeno;
    private $role;
    
    function __construct($id, $nickName, $login, $celeJmeno, RoleUzivatele $role) {
        $this->id = $id;
        $this->nickName = $nickName;
        $this->login = $login;
        $this->celeJmeno = $celeJmeno;
        $this->role = $role;
    }
    
    function getId() {
        return $this->id;
    }

    function getNickName() {
        return $this->nickName;
    }

    function getLogin() {
        return $this->login;
    }

    function getCeleJmeno() {
        return $this->celeJmeno;
    }

    function getRole() {
        return $this->role;
    }

    
    
}