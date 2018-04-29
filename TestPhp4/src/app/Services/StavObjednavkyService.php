<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;
use App\Services\AService;
use App\Models\StavObjednavky;
use PDO;

/**
 * Description of StavObjednavkyService
 *
 * @author King
 */
class StavObjednavkyService extends AService {

    public function getStavObjednavkyById($id) {
        $sql = "
            SELECT * FROM StavObjednavky
            WHERE StavObjednavky.idStavObjednavky = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $this->assemblyDTO($result);
    }

    public function getAllStavObjednavky() {
        $sql = "
        SELECT * 
        FROM StavObjednavky";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $stavy = [];
        foreach ($results as $obj) {
            $s = $this->getStavObjednavkyById($obj['idStavObjednavky']);
            $stavy[] = $s;
        }
        return $stavy;
    }

    protected function assemblyDTO($body) {
        if ($body == null) {
            return null;
        }
        //povinne
        if ($body['nazevStavu'] != null || $body['nazevStavu'] == "") {
            $nazevStavu = $body['nazevStavu'];
        } else {
            return null;
        }

        //ID
        $id = null;
        if (isset($body['idStavObjednavky'])) {
            if ($body['idStavObjednavky'] != null || $body['idStavObjednavky'] == "") {
                $id = $body['idStavObjednavky'];
            }
        }

        return new StavObjednavky($nazevStavu, $id);
    }

}
