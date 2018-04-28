<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Models\TypPraceUzivatele;

/**
 * Description of TypPraceUzivateleService
 *
 * @author King
 */
class TypPraceUzivateleService extends AService{
    
    public function getTypPraceUzivateleById($id){
        $sql = "
            SELECT * FROM TypPraceUzivatele
            WHERE TypPraceUzivatele.idTypPraceUzivatele = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $this->assemblyDTO($result);
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
