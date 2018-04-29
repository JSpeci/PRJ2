<?php
namespace App\Models;
/**
 * Description of Objednavka
 *
 * @author King
 */
class Objednavka implements \JsonSerializable {

    //attr
    private $id;
    private $adresaKam;
    private $pocetAut;
    private $casVzniku;
    private $casPristaveniVozu;
    private $casVyrizeni;
    private $kontaktNaKlienta;
    //objects
    private $StavObjednavky;
    private $Dochazka;  //kdo resil objednavku

    function __construct($adresaKam, $pocetAut, $casVzniku, $casPristaveniVozu, $casVyrizeni, $kontaktNaKlienta, $StavObjednavky, $Dochazka, $id = null) {
        $this->id = $id;
        $this->adresaKam = $adresaKam;
        $this->pocetAut = $pocetAut;
        $this->casVzniku = $casVzniku;
        $this->casPristaveniVozu = $casPristaveniVozu;
        $this->casVyrizeni = $casVyrizeni;
        $this->kontaktNaKlienta = $kontaktNaKlienta;
        $this->StavObjednavky = $StavObjednavky;
        $this->Dochazka = $Dochazka;
    }

    function getId() {
        return $this->id;
    }

    function getAdresaKam() {
        return $this->adresaKam;
    }

    function getPocetAut() {
        return $this->pocetAut;
    }

    function getCasVzniku() {
        return $this->casVzniku;
    }

    function getCasPristaveniVozu() {
        return $this->casPristaveniVozu;
    }

    function getCasVyrizeni() {
        return $this->casVyrizeni;
    }

    function getKontaktNaKlienta() {
        return $this->kontaktNaKlienta;
    }

    function getStavObjednavky() {
        return $this->StavObjednavky;
    }

    function getDochazka() {
        return $this->Dochazka;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
