<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;
/**
 * Description of Hodnoceni
 *
 * @author King
 */
class Hodnoceni implements \JsonSerializable {

    //attrs
    private $id;
    private $text;
    private $znamka;
    //object
    private $Objednavka;

    function __construct($text, $znamka, $Objednavka, $id = null) {
        $this->id = $id;
        $this->text = $text;
        $this->znamka = $znamka;
        $this->Objednavka = $Objednavka;
    }

    function getId() {
        return $this->id;
    }

    function getText() {
        return $this->text;
    }

    function getZnamka() {
        return $this->znamka;
    }

    function getObjednavka() {
        return $this->Objednavka;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
