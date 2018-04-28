<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of Dochazka
 *
 * @author King
 */
class Dochazka implements \JsonSerializable {

    //attrs
    private $id;
    private $prichod;
    private $odchod;
    //objects
    private $Uzivatel;
    private $TypPraceUzivatele;
    private $StavUzivatele;
    private $Auto;

    function __construct($prichod, $odchod, $Uzivatel, $TypPraceUzivatele, $StavUzivatele, $Auto, $id = null) {
        $this->id = $id;
        $this->prichod = $prichod;
        $this->odchod = $odchod;
        $this->Uzivatel = $Uzivatel;
        $this->TypPraceUzivatele = $TypPraceUzivatele;
        $this->StavUzivatele = $StavUzivatele;
        $this->Auto = $Auto;
    }

    function getPrichod() {
        return $this->prichod;
    }

    function getOdchod() {
        return $this->odchod;
    }

    function getUzivatel() {
        return $this->Uzivatel;
    }

    function getTypPraceUzivatele() {
        return $this->TypPraceUzivatele;
    }

    function getStavUzivatele() {
        return $this->StavUzivatele;
    }

    function getAuto() {
        return $this->Auto;
    }

    function getId() {
        return $this->id;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
