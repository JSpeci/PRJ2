<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Jednoduchy model pro RoliUzivatele
 *
 * @author King
 */
class RoleUzivatele implements \JsonSerializable {

    private $nazevRole;
    private $id;

    function __construct($nazevRole, $id) {
        $this->nazevRole = $nazevRole;
        $this->id = $id;
    }

    function getNazevRole() {
        return $this->nazevRole;
    }

    function getId() {
        return $this->id;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
