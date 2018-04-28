<?php

namespace App\Services;

use PDO;
use App\Services\AService;
use App\Models\Dochazka;

/**
 * Description of DochazkaService
 *
 * @author King
 */
class DochazkaService extends AService {

    public function getAllDochazka() {
        $sql = "
        SELECT * 
        FROM Dochazka";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $dochazky = [];
        foreach ($results as $obj) {
            $d = $this->assemblyDTO($this->getDochazkaById($obj['idDochazka']));
            $dochazky[] = $d;
        }
        return $dochazky;
    }

    public function getDochazkaDetailById($id) {
        $sql = "        
            SELECT * 
            FROM Dochazka
            WHERE Dochazka.idDochazka = ?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $d = $this->assemblyDTO($this->getDochazkaById($result['idDochazka']));
        return $d;
    }

    public function saveNewDochazka($body) {
        $u = $this->assemblyDTO($body);
        if ($u == null) {
            return null;
        }
        //vlozeni do databaze
        $sql = "INSERT INTO `libtaxidb`.`Dochazka` 
                (`idDochazka`, `prichod`, `odchod`, `idUzivatel`, 
                 `idTypPraceUzivatele`, `idStavUzivatele`, `idAuto`) 
                VALUES 
                (NULL, '2018-02-21 07:58:03.000', NULL, 
                '5', '1', '4', '3')";
        $stmt = $this->container->db->prepare($sql);

        $nick = $u->getNickName();
        $cele = $u->getCeleJmeno();
        $role_id = $u->getRole()->getId();
        $login = $u->getLogin();
        try {
            $stmt->bindParam(1, $nick, PDO::PARAM_STR);
            $stmt->bindParam(2, $cele, PDO::PARAM_STR);
            $stmt->bindParam(3, $role_id, PDO::PARAM_INT);
            $stmt->bindParam(4, $login, PDO::PARAM_STR);
            $stmt->execute();
            //assembly output DTO from db - now has id
            $user_complete = $this->getUserByLogin($login);
            //$user_complete ma vsecky pole, my osadime DTO, 
            //abychom zverejnili jen to co chceme
            $u = $this->assemblyDTO($user_complete);
            return $u;
        } catch (PDOException $e) {
            //neulozeny uzivatel 
            return null;
        }
    }

    public function updateDochazka($body, $id) {
        if ($id == null) {
            return null;
        }
        //update for each key
        foreach ($body as $key => $val) {
            try {
                $sql = 'UPDATE Dochazka SET ' . $key . '=? WHERE idDochazka = ?';
                $stmt = $this->container->db->prepare($sql);
                $stmt->bindParam(1, $val, PDO::PARAM_STR);
                $stmt->bindParam(2, $id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }
        }
        return $this->getUserById($id);
    }

    public function deleteDochazka($id) {
        $user_complete = $this->getUserById($id);
        if ($user_complete == null) {
            return null;
        }
        $sql = 'DELETE FROM Dochazka WHERE idDochazka = ?';
        $id_int = intval($id);
        $stmt = $this->container->db->prepare($sql);
        try {
            $stmt->bindParam(1, $id_int, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $this->assemblyDTO($user_complete);
    }

    protected function getDochazkaById($id) {
        if ($id == null || $id == "") {
            return null;
        }
        $id_int = intval($id);
        $sql = "SELECT * FROM Dochazka WHERE Dochazka.idDochazka=?";
        $stmt = $this->container->db->prepare($sql);
        $stmt->bindParam(1, $id_int, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    /** Funkce pro osazeni modelu validovanymi parametry
     * 
     * @param type $body - repsponsed body of post from controller
     * @return Dochazka - DTO
     */
    protected function assemblyDTO($body) {
        if ($body == null) {
            return null;
        }
        if ($body['idUzivatel'] != null || $body['idUzivatel'] == "") {
            $idUzivatel = $body['idUzivatel'];
        } else {
            return null;
        }
        if ($body['idTypPraceUzivatele'] != null || $body['idTypPraceUzivatele'] == "") {
            $idTypPraceUzivatele = $body['idTypPraceUzivatele'];
        } else {
            return null;
        }
        if ($body['idStavUzivatele'] != null || $body['idStavUzivatele'] == "") {
            $idStavUzivatele = $body['idStavUzivatele'];
        } else {
            return null;
        }
        if ($body['idAuto'] != null || $body['idAuto'] == "") {
            $idAuto = $body['idAuto'];
        } else {
            return null;
        }
        if ($body['prichod'] != null) {
            $prichod = $body['prichod'];
        } else {
            $prichod = null;
        }
        if ($body['odchod'] != null) {
            $odchod = $body['odchod'];
        } else {
            $odchod = null;
        }

        /* z controlleru neprichazi ID, ale vnitrne v service objektu muze byt,
         *  priklad - saveNewDochazka */

        $id = null;
        if (isset($body['idDochazka'])) {
            if ($body['idDochazka'] != null || $body['idDochazka'] == "") {
                $id = $body['idDochazka'];
            }
        }

        //objects related
        $stav = $this->container->StavUzivateleService->getStavUzivateleById($idStavUzivatele);
        $typPrace = $this->container->TypPraceUzivateleService->getTypPraceUzivateleById($idTypPraceUzivatele);
        $auto = $this->container->AutoService->getAutoById($idAuto);
        $uzivatel = $this->container->UzivatelService->getUzivatelDetailById($idUzivatel);

        $d = new Dochazka($prichod, $odchod, $uzivatel, $typPrace, $stav, $auto, $id);
        
        return $d;
        //null - databaze resi id autoinkrementem
    }

}
