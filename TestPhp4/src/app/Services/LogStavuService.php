<?php

namespace App\Services;

use App\Models\LogStavu;
use PDO;

/**
 * Description of LogStavuService - pouze get a post
 *
 * @author King
 */
class LogStavuService extends AService {

    public function getAllLogStavu() {
        $sql = "
            SELECT * 
            FROM LogStavu";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $logs = [];
        foreach ($results as $obj) {
            $o = $this->getLogStavuDetailById($obj['idLogStavu']);
            $logs[] = $o;
        }
        return $logs;
    }

    public function getLogStavuDetailById($id) {
        $sql = "        
            SELECT * 
            FROM LogStavu
            WHERE LogStavu.idLogStavu = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $o = $this->assemblyDTO($result);
        return $o;
    }

    public function saveNewLogStavu($body) {
        $log = $this->assemblyDTO($body);
        if ($log == null) {
            return null;
        }
        //vlozeni do databaze
        $sql = "INSERT INTO `libtaxidb`.`LogStavu` 
                    (`idLogStavu`, `idStavUzivatele`, `idUzivatel`, `cas`) 
                VALUES 
                    (NULL, ?, ?, ?)";
        $stmt = $this->container->db->prepare($sql);

        $idStavUzivatele = $log->getUzivatel()->getId();
        $idUzivatel = $log->getUzivatel()->getId();
        $cas = $log->getCas();

        try {
            $stmt->bindParam(1, $idStavUzivatele, PDO::PARAM_INT);
            $stmt->bindParam(2, $idUzivatel, PDO::PARAM_INT);
            $stmt->bindParam(3, $cas, PDO::PARAM_STR);

            $stmt->execute();
            //assembly output DTO from db 
            $log_complete = $this->getLogStavuByAttrs($idStavUzivatele, $idUzivatel, $cas);
            //$user_complete ma vsecky pole, my osadime DTO, 
            //abychom zverejnili jen to co chceme
            $l = $this->assemblyDTO($log_complete);
            return $l;
        } catch (PDOException $e) {
            //neulozeny uzivatel 
            return null;
        }
    }

    public function getLogStavuByAttrs($idStavUzivatele, $idUzivatel, $cas) {
        $sql = "        
            SELECT * 
            FROM LogStavu
            WHERE   LogStavu.idStavUzivatele = ? 
                AND LogStavu.idUzivatel = ? 
                AND LogStavu.cas = ?";
        $stmt = $this->container->db->prepare($sql);
        try {
            $stmt->bindParam(1, $idStavUzivatele, PDO::PARAM_INT);
            $stmt->bindParam(2, $idUzivatel, PDO::PARAM_INT);
            $stmt->bindParam(3, $cas, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            //neulozeny uzivatel 
            return null;
        }
    }

    protected function assemblyDTO($body) {
        if ($body == null) {
            return null;
        }

        //povinne
        if ($body['idUzivatel'] != null || $body['idUzivatel'] == "") {
            $idUzivatel = $body['idUzivatel'];
        } else {
            return null;
        }
        if ($body['idStavUzivatele'] != null || $body['idStavUzivatele'] == "") {
            $idStavUzivatele = $body['idStavUzivatele'];
        } else {
            return null;
        }
        if ($body['cas'] != null || $body['cas'] == "") {
            $cas = $body['cas'];
        } else {
            return null;
        }
        //objects related

        $id = null;
        if (isset($body['idLogStavu'])) {
            if ($body['idLogStavu'] != null || $body['idLogStavu'] == "") {
                $id = $body['idLogStavu'];
            }
        }

        $Uzivatel = $this->container->UzivatelService->getUzivatelDetailById($idUzivatel);
        $StavUzivatele = $this->container->StavUzivateleService->getStavUzivateleById($idStavUzivatele);

        $log = new LogStavu($cas, $StavUzivatele, $Uzivatel, $id);
        return $log;
    }

}
