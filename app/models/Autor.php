<?php 
namespace App\models;

use \App\Config\Connection as conn;

class Autor{
    private $db;


    public function __construct()
    {
        $this->db = conn::getInstance()->getConnection();
    }

    public function create(string $nome){
        $stmt = $this->db->prepare("INSERT INTO autor(nome) VALUE (:nome)");
        $stmt->bindParam(":nome",$nome);
        $stmt->execute();
        
        $result = $this->getAutor($nome);

        return $result["id_autor"];
    }

    public function getAutor(string $nome){
        $stmt = $this->db->prepare("SELECT * FROM autor WHERE nome = :nome");
        $stmt->bindParam(":nome",$nome);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
}