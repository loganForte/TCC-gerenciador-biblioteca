<?php 
namespace App\models;

use \App\Config\Connection as conn;

class Bibliotecaria {
    private $db;

    public function __construct()
    {
        $this->db = conn::getInstance()->getConnection();
    }

    public function create(string $nome,string $email,string $senha,string $telefone){
        $stmt = $this->db->prepare("INSERT INTO bibliotecaria(nome,email_institucional,senha,telefone) value (:nome,:email,:senha,:telefone)");
        $stmt->bindParam(':nome',$nome);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':senha',$senha);
        $stmt->bindParam(':telefone',$telefone);
        $result = $stmt->execute();
        
        return $result;
    }

    public function getWhere(string $column,$value): array|bool {
        $stmt = $this->db->prepare("SELECT * FROM bibliotecaria WHERE ". $column ." = :value ");
        $stmt->bindParam(":value",$value);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }
}
