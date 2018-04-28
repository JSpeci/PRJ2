<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of Auto
 *
 * @author King
 */
class Auto implements \JsonSerializable {

    //attrs only in this entity
    private $id;
    private $znacka;
    private $typ;
    private $barva;
    private $rokVyroby;
    private $pocetMist;
    private $idVysilacka;
    private $cisloMagistratni;
    private $registracniZnacka;

    function __construct($znacka, $typ, $barva, $rokVyroby, $pocetMist, $idVysilacka, $cisloMagistratni, $registracniZnacka, $id = null) {
        $this->id = $id;
        $this->znacka = $znacka;
        $this->typ = $typ;
        $this->barva = $barva;
        $this->rokVyroby = $rokVyroby;
        $this->pocetMist = $pocetMist;
        $this->idVysilacka = $idVysilacka;
        $this->cisloMagistratni = $cisloMagistratni;
        $this->registracniZnacka = $registracniZnacka;
    }

    function getId() {
        return $this->id;
    }

    function getZnacka() {
        return $this->znacka;
    }

    function getTyp() {
        return $this->typ;
    }

    function getBarva() {
        return $this->barva;
    }

    function getRokVyroby() {
        return $this->rokVyroby;
    }

    function getPocetMist() {
        return $this->pocetMist;
    }

    function getIdVysilacka() {
        return $this->idVysilacka;
    }

    function getCisloMagistratni() {
        return $this->cisloMagistratni;
    }

    function getRegistracniZnacka() {
        return $this->registracniZnacka;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
