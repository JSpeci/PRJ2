<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Models\TypPraceUzivatele;
use PDO;

/**
 * Description of TypPraceUzivateleService
 *
 * @author King
 */
class TypPraceUzivateleService extends AService {

    public function getTypPraceUzivateleById($id) {
        $sql = "
            SELECT * FROM TypPraceUzivatele
            WHERE TypPraceUzivatele.idTypPraceUzivatele = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $this->assemblyDTO($result);
    }

    public function getAllTypPraceUzivatele() {
        $sql = "
        SELECT * 
        FROM TypPraceUzivatele";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $typy = [];
        foreach ($results as $obj) {
            $t = $this->getTypPraceUzivateleById($obj['idTypPraceUzivatele']);
            $typy[] = $t;
        }
        return $typy;
    }

    protected function assemblyDTO($body) {
        if ($body == null) {
            return null;
        }
        //povinne
        if ($body['typPrace'] != null || $body['typPrace'] == "") {
            $typPrace = $body['typPrace'];
        } else {
            return null;
        }

        //ID
        $id = null;
        if (isset($body['idTypPraceUzivatele'])) {
            if ($body['idTypPraceUzivatele'] != null || $body['idTypPraceUzivatele'] == "") {
                $id = $body['idTypPraceUzivatele'];
            }
        }

        return new TypPraceUzivatele($typPrace, $id);
    }

}
