<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use PDO;
use App\Services\AService;
use App\Models\Auto;

/**
 * Description of AutoService
 *
 * @author King
 */
class AutoService extends AService {

    public function getAutoById($id) {
        $sql = "
            SELECT * FROM Auto
            WHERE Auto.idAuto = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $this->assemblyDTO($result);
    }

    public function getAllAuto() {
        $sql = "
            SELECT * 
            FROM Auto";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $auta = [];
        foreach ($results as $obj) {
            $a = $this->getAutoById($obj['idAuto']);
            $auta[] = $a;
        }
        return $auta;
    }

    public function saveNewAuto($body) {
        $a = $this->assemblyDTO($body);
        if ($a == null) {
            return null;
        }
        //vlozeni do databaze
        $sql = "INSERT INTO `libtaxidb`.`Auto` 
                (`idAuto`, `znacka`, `typ`, `barva`, `rokVyroby`, `pocetMist`, 
                `idVysilacka`, `cisloMagistratni`, `registracniZnacka`) 
                VALUES 
                (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->container->db->prepare($sql);

        $znacka = $a->getZnacka();
        $typ = $a->getTyp();
        $barva = $a->getBarva();
        $rokVyroby = $a->getRokVyroby();
        $pocetMist = $a->getPocetMist();
        $idVysilacka = $a->getIdVysilacka();
        $cisloMagistratni = $a->getCisloMagistratni();
        $registracniZnacka = $a->getRegistracniZnacka();

        try {
            $stmt->bindParam(1, $znacka, PDO::PARAM_STR);
            $stmt->bindParam(2, $typ, PDO::PARAM_STR);
            $stmt->bindParam(3, $barva, PDO::PARAM_STR);

            $stmt->bindParam(4, $rokVyroby, PDO::PARAM_INT);
            $stmt->bindParam(5, $pocetMist, PDO::PARAM_INT);
            $stmt->bindParam(6, $idVysilacka, PDO::PARAM_INT);
            $stmt->bindParam(7, $cisloMagistratni, PDO::PARAM_INT);

            $stmt->bindParam(8, $registracniZnacka, PDO::PARAM_STR);
            $stmt->execute();

            //assembly output DTO from db - now has id
            $auto_complete = $this->getAutoByAttrs($znacka, $typ, $barva, $pocetMist, $idVysilacka);
            $a = $this->assemblyDTO($auto_complete);
            return $a;
        } catch (PDOException $e) {
            //neulozeny uzivatel 
            return null;
        }
    }

    public function getAutoByAttrs($znacka, $typ, $barva, $pocetMist, $idVysilacka) {
        $sql = "
            SELECT * FROM Auto
            WHERE Auto.znacka = ? 
            AND Auto.typ = ?
            AND Auto.barva = ?
            AND Auto.pocetMist = ?
            AND Auto.idVysilacka = ?";
        $stmt = $this->container->db->prepare($sql);
        try {
            $stmt->bindParam(1, $znacka, PDO::PARAM_STR);
            $stmt->bindParam(2, $typ, PDO::PARAM_STR);
            $stmt->bindParam(3, $barva, PDO::PARAM_STR);
            $stmt->bindParam(4, $pocetMist, PDO::PARAM_INT);
            $stmt->bindParam(5, $idVysilacka, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            //neulozeny uzivatel 
            return null;
        }
    }

    public function updateAuto($body, $id) {
        if ($id == null) {
            return null;
        }
        $auto_complete = $this->getAutoById($id);
        if ($auto_complete == null) {
            return null;
        }
        //update for each key
        foreach ($body as $key => $val) {
            try {
                $sql = 'UPDATE Auto SET ' . $key . '=? WHERE idAuto = ?';
                $stmt = $this->container->db->prepare($sql);
                $int_id = intval($id);
                $stmt->bindParam(1, $val, PDO::PARAM_STR);
                $stmt->bindParam(2, $int_id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }
        }
        return $this->getAutoById($id);
    }

    public function deleteAuto($id) {
        $auto_complete = $this->getAutoById($id);
        if (!$auto_complete) {
            return null;
        }
        $sql = 'DELETE FROM Auto WHERE idAuto = ?';
        $id_int = intval($id);
        $stmt = $this->container->db->prepare($sql);
        try {
            $stmt->bindParam(1, $id_int, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $auto_complete;
    }

    public function assemblyDTO($body) {
        if ($body == null) {
            return null;
        }
        //povinne
        if ($body['znacka'] != null || $body['znacka'] == "") {
            $znacka = $body['znacka'];
        } else {
            return null;
        }
        if ($body['barva'] != null || $body['barva'] == "") {
            $barva = $body['barva'];
        } else {
            return null;
        }

        if ($body['pocetMist'] != null || $body['pocetMist'] == "") {
            $pocetMist = $body['pocetMist'];
        } else {
            return null;
        }

        //nepovine
        if (isset($body['typ']) && ($body['typ'] != null || $body['typ'] == "")) {
            $typ = $body['typ'];
        } else {
            $typ = "unsetted yet";
        }
        if (isset($body['rokVyroby']) && ( $body['rokVyroby'] != null || $body['rokVyroby'] == "")) {
            $rokVyroby = $body['rokVyroby'];
        } else {
            $rokVyroby = "unsetted yet";
        }
        if (isset($body['idVysilacka']) && ($body['idVysilacka'] != null || $body['idVysilacka'] == "")) {
            $idVysilacka = $body['idVysilacka'];
        } else {
            $idVysilacka = "unsetted yet";
        }
        if (isset($body['cisloMagistratni']) && ( $body['cisloMagistratni'] != null || $body['cisloMagistratni'] == "")) {
            $cisloMagistratni = $body['cisloMagistratni'];
        } else {
            $cisloMagistratni = "unsetted yet";
        }
        if (isset($body['registracniZnacka']) && ( $body['registracniZnacka'] != null || $body['registracniZnacka'] == "")) {
            $registracniZnacka = $body['registracniZnacka'];
        } else {
            $registracniZnacka = "unsetted yet";
        }

        //ID
        $id = null;
        if (isset($body['idAuto'])) {
            if ($body['idAuto'] != null || $body['idAuto'] == "") {
                $id = $body['idAuto'];
            }
        }

        return new Auto($znacka, $typ, $barva, $rokVyroby, $pocetMist, $idVysilacka, $cisloMagistratni, $registracniZnacka, $id);
    }

}
