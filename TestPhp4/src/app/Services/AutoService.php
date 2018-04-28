<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

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
        if ($body['typ'] != null || $body['typ'] == "") {
            $typ = $body['typ'];
        } else {
            $typ = "unsetted yet";
        }
        if ($body['rokVyroby'] != null || $body['rokVyroby'] == "") {
            $rokVyroby = $body['rokVyroby'];
        } else {
            $rokVyroby = "unsetted yet";
        }
        if ($body['idVysilacka'] != null || $body['idVysilacka'] == "") {
            $idVysilacka = $body['idVysilacka'];
        } else {
            $idVysilacka = "unsetted yet";
        }
        if ($body['cisloMagistratni'] != null || $body['cisloMagistratni'] == "") {
            $cisloMagistratni = $body['cisloMagistratni'];
        } else {
            $cisloMagistratni = "unsetted yet";
        }
        if ($body['registracniZnacka'] != null || $body['registracniZnacka'] == "") {
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

        return new Auto($znacka, $typ, $barva, $rokVyroby, $pocetMist, 
            $idVysilacka, $cisloMagistratni, $registracniZnacka, $id);
    }

}
