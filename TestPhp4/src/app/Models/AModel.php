<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of AModel
 *
 * @author King
 */

class AModel implements \JsonSerializable {
   
    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
