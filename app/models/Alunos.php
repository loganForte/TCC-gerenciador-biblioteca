<?php 
namespace App\models;

use \App\Config\Connection as conn;

class Alunos{
    private $db;

    public function __construct(){
        $this->db = conn::getInstance()->getConnection();
    }
    
    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM alunos");
        $stmt->execute();        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAlunosWhere(string $colunm,$filter)
    {
        $stmt = $this->db->prepare("SELECT * FROM alunos WHERE ". $colunm ."= :filter");
        $stmt->bindParam(":filter",$filter);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function create(string $RM,string $email,string $senha){
       $stmt = $this->db->prepare("INSERT INTO alunos(RM,email_institucional,senha) VALUE (:RM,:email,:senha)");
       $stmt->bindParam(":RM",$RM);
       $stmt->bindParam(":email",$email);
       $stmt->bindParam(":senha",$senha);
       return $stmt->execute();
    }

    public function update(int $id,string $RM,string $email,string $senha){
       $stmt = $this->db->prepare("UPDATE alunos SET RM = :RM,email_institucional = :email, senha = :senha WHERE id_aluno = :id");
       $stmt->bindParam(":RM",$RM);
       $stmt->bindParam(":email",$email);
       $stmt->bindParam(":senha",$senha);
       $stmt->bindParam(":id",$id);
       return $stmt->execute();
    }

    public function delete(int $id){
       $stmt = $this->db->prepare("DELETE FROM alunos WHERE id_aluno = :id");
       $stmt->bindParam(":id",$id);
       return $stmt->execute();
    }
}