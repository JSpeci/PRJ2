<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use PDO;
use App\Services\AService;
use App\Models\Objednavka;

/**
 * Description of ObjednavkaService
 *
 * @author King
 */
class ObjednavkaService extends AService {

    public function getAllObjednavka() {
        $sql = "
        SELECT * 
        FROM Objednavka";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $objednavky = [];
        foreach ($results as $obj) {
            $o = $this->assemblyDTO($this->getObjednavkaById($obj['idObjednavka']));
            $objednavky[] = $o;
        }
        return $objednavky;
    }

    public function getObjednavkaDetailById($id) {
        $sql = "        
            SELECT * 
            FROM Objednavka
            WHERE Objednavka.idObjednavka = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $o = $this->assemblyDTO($this->getObjednavkaById($result['idObjednavka']));
        return $o;
    }

    public function saveNewObjednavka($body) {
        $o = $this->assemblyDTO($body);
        if ($o == null) {
            return null;
        }
        //vlozeni do databaze
        $sql = "INSERT INTO `libtaxidb`.`Objednavka` 	
                (`idObjednavka`, `idStavObjednavky`, `idDochazka`, `adresaKam`, 
                `pocetAut`, `casVzniku`, `casPristaveniVozu`, `casVyrizeni`, `kontaktNaKlienta`) 
                VALUES 
                (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->container->db->prepare($sql);

        $id_stav = $o->getStavObjednavky()->getId();
        $id_dochazka = $o->getDochazka()->getId();
        $kam = $o->getAdresaKam();
        $pocetAut = $o->getPocetAut();
        $casVzniku = $o->getCasVzniku();
        $cas_pristaveni = $o->getCasPristaveniVozu();
        $cas_vyrizeni = $o->getCasVyrizeni();
        $kontakt = $o->getKontaktNaKlienta();

        try {
            $stmt->bindParam(1, $id_stav, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_dochazka, PDO::PARAM_INT);
            $stmt->bindParam(3, $kam, PDO::PARAM_STR);
            $stmt->bindParam(4, $pocetAut, PDO::PARAM_INT);
            $stmt->bindParam(5, $casVzniku, PDO::PARAM_STR);
            $stmt->bindParam(6, $cas_pristaveni, PDO::PARAM_STR);
            $stmt->bindParam(7, $cas_vyrizeni, PDO::PARAM_STR);
            $stmt->bindParam(8, $kontakt, PDO::PARAM_STR);

            $stmt->execute();
            //assembly output DTO from db 
            $objednavka_complete = $this->getObjednavkaByAttrs($casVzniku, $id_dochazka, $kam);
            //$user_complete ma vsecky pole, my osadime DTO, 
            //abychom zverejnili jen to co chceme
            $o = $this->assemblyDTO($objednavka_complete);
            return $o;
        } catch (PDOException $e) {
            //neulozeny uzivatel 
            return null;
        }
    }

    protected function getObjednavkaByAttrs($casVzniku, $id_dochazka, $kam) {
        $sql = "        
            SELECT * 
            FROM Objednavka
            WHERE   Objednavka.casVzniku = ? 
                AND Objednavka.idDochazka = ? 
                AND Objednavka.adresaKam = ?";
        $stmt = $this->container->db->prepare($sql);
        try {
            $stmt->bindParam(1, $casVzniku, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_dochazka, PDO::PARAM_INT);
            $stmt->bindParam(3, $kam, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            //neulozeny uzivatel 
            return null;
        }
    }

    public function updateObjednavka($body, $id) {
        if ($id == null) {
            return null;
        }
        $objednavka_complete = $this->getObjednavkaById($id);
        if ($objednavka_complete == null) {
            return null;
        }
        //update for each key
        foreach ($body as $key => $val) {
            try {
                $sql = 'UPDATE Objednavka SET ' . $key . '=? WHERE idObjednavka = ?';
                $stmt = $this->container->db->prepare($sql);
                $int_id = intval($id);
                $stmt->bindParam(1, $val, PDO::PARAM_STR);
                $stmt->bindParam(2, $int_id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }
        }
        return $this->assemblyDTO($this->getObjednavkaById($id));
    }

    public function deleteObjednavka($id) {
        $objednavka_complete = $this->objednavkaExistsById($id);
        if (!$objednavka_complete) {
            return null;
        }
        $sql = 'DELETE FROM Objednavka WHERE idObjednavka = ?';
        $id_int = intval($id);
        $stmt = $this->container->db->prepare($sql);
        try {
            $stmt->bindParam(1, $id_int, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $this->assemblyDTO($objednavka_complete);
    }

    protected function objednavkaExistsById($id) {
        if ($id == null) {
            return false;
        }
        $objednavka_complete = $this->getObjednavkaById($id);
        if ($objednavka_complete == null) {
            return false;
        }
        return $objednavka_complete;
    }

    protected function getObjednavkaById($id) {
        if ($id == null || $id == "") {
            return null;
        }
        $id_int = intval($id);
        $sql = "SELECT * FROM Objednavka WHERE Objednavka.idObjednavka=?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->bindParam(1, $id_int, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    /** Funkce pro osazeni modelu validovanymi parametry
     * 
     * @param type $body - repsponsed body of post from controller
     * @return Objednavka - DTO
     */
    protected function assemblyDTO($body) {
        if ($body == null) {
            return null;
        }

        //povinne
        if ($body['adresaKam'] != null || $body['adresaKam'] == "") {
            $adresaKam = $body['adresaKam'];
        } else {
            return null;
        }
        if ($body['pocetAut'] != null || $body['pocetAut'] == "") {
            $pocetAut = $body['pocetAut'];
        } else {
            return null;
        }
        if ($body['casVzniku'] != null || $body['casVzniku'] == "") {
            $casVzniku = $body['casVzniku'];
        } else {
            return null;
        }
        if ($body['casPristaveniVozu'] != null || $body['casPristaveniVozu'] == "") {
            $casPristaveniVozu = $body['casPristaveniVozu'];
        } else {
            return null;
        }

        //nepovinne
        if (isset($body['casVyrizeni']) && ($body['casVyrizeni'] != null || $body['casVyrizeni'] == "")) {
            $casVyrizeni = $body['casVyrizeni'];
        } else {
            $casVyrizeni = "0000-00-00 00:00:00";
        }
        if (isset($body['kontaktNaKlienta']) && ( $body['kontaktNaKlienta'] != null || $body['kontaktNaKlienta'] == "")) {
            $kontaktNaKlienta = $body['kontaktNaKlienta'];
        } else {
            $kontaktNaKlienta = "unsetted yet";
        }
        //objektove reference

        if (isset($body['idDochazka']) && ( $body['idDochazka'] != null || $body['idDochazka'] == "")) {
            $idDochazka = $body['idDochazka'];
        } else {
            return null;
        }

        if (isset($body['idStavObjednavky']) && ( $body['idStavObjednavky'] != null || $body['idStavObjednavky'] == "")) {
            $idStavObjednavky = $body['idStavObjednavky'];
        } else {
            return null;
        }
        
        /* z controlleru neprichazi ID, ale vnitrne v service objektu muze byt,
         *  priklad - saveNewObjednavka */
        $id = null;
        if (isset($body['idObjednavka'])) {
            if ($body['idObjednavka'] != null || $body['idObjednavka'] == "") {
                $id = $body['idObjednavka'];
            }
        }

        //objects related
        
        $StavObjednavky = $this->container->StavObjednavkyService->getStavObjednavkyById($idStavObjednavky);
        $Dochazka = $this->container->DochazkaService->getDochazkaDetailById($idDochazka);

        $o = new Objednavka($adresaKam, $pocetAut, $casVzniku, $casPristaveniVozu, 
                $casVyrizeni, $kontaktNaKlienta, $StavObjednavky, $Dochazka, $id);
        return $o;
    }

}
