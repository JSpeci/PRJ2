<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Models\RoleUzivatele;
use PDO;

/**
 * Description of RoleUzivateleService
 *
 * @author King
 */
class RoleUzivateleService extends AService {

    public function getRoleUzivateleById($id) {
        $sql = "
            SELECT * FROM RoleUzivatele
            WHERE RoleUzivatele.idRoleUzivatele = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $this->assemblyDTO($result);
    }

    public function getAllRoleUzivatele() {
        $sql = "
            SELECT * 
            FROM RoleUzivatele";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $roles = [];
        foreach ($results as $obj) {
            $r = $this->getRoleUzivateleById($obj['idRoleUzivatele']);
            $roles[] = $r;
        }
        return $roles;
    }

    protected function assemblyDTO($body) {
        if ($body == null) {
            return null;
        }
        //povinne
        if ($body['nazevRole'] != null || $body['nazevRole'] == "") {
            $nazevRole = $body['nazevRole'];
        } else {
            return null;
        }

        //ID
        $id = null;
        if (isset($body['idAuto'])) {
            if ($body['idAuto'] != null || $body['idAuto'] == "") {
                $id = $body['idAuto'];
            }
        }

        return new RoleUzivatele($nazevRole, $id);
    }

}
