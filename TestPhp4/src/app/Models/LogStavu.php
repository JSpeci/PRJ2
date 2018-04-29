<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;
/**
 * Description of LogStavu
 *
 * @author King
 */
class LogStavu implements \JsonSerializable {

    //attrs
    private $id;
    private $cas;
    //objects
    private $StavUzivatele;
    private $Uzivatel;

    function __construct($cas, $StavUzivatele, $Uzivatel, $id = null) {
        $this->id = $id;
        $this->cas = $cas;
        $this->StavUzivatele = $StavUzivatele;
        $this->Uzivatel = $Uzivatel;
    }

    function getId() {
        return $this->id;
    }

    function getCas() {
        return $this->cas;
    }

    function getStavUzivatele() {
        return $this->StavUzivatele;
    }

    function getUzivatel() {
        return $this->Uzivatel;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
