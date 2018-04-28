<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Models\RoleUzivatele;
/**
 * Description of RoleUzivateleService
 *
 * @author King
 */
class RoleUzivateleService extends AService {
    
    public function getRoleUzivateleById($id){
        $sql = "
            SELECT * FROM RoleUzivatele
            WHERE RoleUzivatele.idRoleUzivatele = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $role = new RoleUzivatele($result['nazevRole'], $result['idRoleUzivatele']);
        return $role;
    }
    
}
