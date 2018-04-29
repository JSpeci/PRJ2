<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;
/**
 * Description of StavObjednavky
 *
 * @author King
 */
class StavObjednavky implements \JsonSerializable {

    private $id;
    private $nazevStavu;

    function __construct($nazevStavu, $id = null) {
        $this->id = $id;
        $this->nazevStavu = $nazevStavu;
    }

    function getId() {
        return $this->id;
    }

    function getNazevStavu() {
        return $this->nazevStavu;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
