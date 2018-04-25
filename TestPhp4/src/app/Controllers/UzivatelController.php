<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Interop\Container\ContainerInterface as ContainerInterface;
use PDO;

class UzivatelController extends ApiController{

    public function getUserDetailById(Request $request, Response $response, array $args) {
        $id = $args["id"];  //important "" not ''
        $sql = "SELECT * FROM Uzivatel WHERE Uzivatel.idUzivatel=?";


        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));
        return $response;
    }
    
    protected function getUserById($id) {
        $sql = "SELECT * FROM Uzivatel WHERE Uzivatel.idUzivatel=?";

        $stmt = $this->container->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));
        return $response;
    }

    public function uzivatele(Request $request, Response $response, array $args) {

        $sql = "SELECT * FROM Uzivatel";
        $stmt = $this->container->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();        
        $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));
        return $response;
    }
    
    public function saveNewUser(Request $request, Response $response, array $args) {
               
        $body = $request->getParsedBody();
        $nickName = $body['nickName'];
        $celeJmeno = $body['celeJmeno'];
        $idRoleUzivatele = $body['idRoleUzivatele'];
                
        //vlozeni do databaze
        $sql = 'INSERT INTO Uzivatel VALUES '
                . '(NULL, ?, ?, \'Adresa\', NOW(), 999999, ?, NULL, NULL, NULL, NULL)';

        $stmt = $this->container->db->prepare($sql);
        
        try{
            $stmt->bindParam(1,$body['nickName'], PDO::PARAM_STR);
            $stmt->bindParam(2,$body['celeJmeno'], PDO::PARAM_STR);
            $stmt->bindParam(3,$body['idRoleUzivatele'], PDO::PARAM_INT);

            $stmt->execute();
        
        } catch(PDOException $e) {
            return $response->withStatus(400);
        }
        
        //navratova hodnota
        return $response->getBody()->write("Inserted");
    }   
    
    public function updateUser(Request $request, Response $response, array $args) {
               
        $id = $args['id'];
        //vlozeni do databaze
        
        foreach ($request->getParsedBody() as $key => $val) {
            try {
                $sql = 'UPDATE Uzivatel SET '.$key.'=? WHERE idUzivatel = ?';
                $stmt = $this->container->db->prepare($sql);
                //$stmt->bindParam(1, $key, PDO::PARAM_STR);
                $stmt->bindParam(1, $val, PDO::PARAM_STR);
                $stmt->bindParam(2, $id, PDO::PARAM_INT);
                $stmt->execute();
                
            } catch (PDOException $e) {
                return $response->withStatus(400);
            }
        }

        //navratova hodnota
        return $response->getBody()->write("Updated");
    }   
    
    public function deleteUser(Request $request, Response $response, array $args) {
        
        echo "deleting user" . $request->getAttribute("id");
        
        $id = $args['id'];
        //vlozeni do databaze
        $sql = 'DELETE FROM Uzivatel WHERE idUzivatel = ?';
        $stmt = $this->container->db->prepare($sql);
        
        try{
            
            $stmt->bindParam(1,$id, PDO::PARAM_INT);
            $stmt->execute();
            
        } catch(PDOException $e) {
            return $response->withStatus(400);
        }
        //navratova hodnota
        return $response->getBody()->write("Deleted");
    }   
    
}
