<?php
namespace App\models;

use \App\Config\Connection as conn;

class Reserva{

    private $db;

    public function __construct()
    {
        $this->db = conn::getInstance()->getConnection();
    }

    public function create($data_emprestimo,$data_devolucao,int $id_aluno,int $id_livro){
        $stmt = $this->db->prepare("INSERT INTO emprestimo(data_emprestimo,data_devolucao,fk_livro,fk_aluno) value(:emprestimo,:devolucao,:id_livro,:id_aluno)");
        
        $stmt->bindParam(":emprestimo",$data_emprestimo);
        $stmt->bindParam(":devolucao",$data_devolucao);
        $stmt->bindParam(":id_livro",$id_livro);
        $stmt->bindParam(":id_aluno",$id_aluno);

        $update = $this->db->prepare("UPDATE livro SET emprestado = true where id_livro = :id_livro");
        $update->bindParam(":id_livro",$id_livro);
        $update->execute();

        return $stmt->execute();
    }

    public function getReservaToAluno($id_aluno){
        $stmt = $this->db->prepare("SELECT emprestimo.id_emprestimo,livro.titulo,livro.url,livro.editora,autor.nome, DATE_FORMAT(emprestimo.data_emprestimo,'%d/%m/%Y') as emprestimo , DATE_FORMAT(emprestimo.data_devolucao,'%d/%m/%Y') as devolucao FROM livro INNER JOIN autor ON livro.fk_autor = id_autor INNER JOIN emprestimo ON emprestimo.fk_livro = id_livro INNER JOIN alunos ON alunos.id_aluno = emprestimo.fk_aluno WHERE alunos.id_aluno = :id_aluno");

        $stmt->bindParam("id_aluno",$id_aluno);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getReservaToBibliotecaria(){
        $stmt = $this->db->prepare("select livro.titulo,livro.url,autor.nome as autor ,livro.editora,DATE_FORMAT(emprestimo.data_devolucao,'%d/%m/%Y') as devolucao ,DATE_FORMAT(emprestimo.data_emprestimo,'%d/%m/%Y') as emprestimo ,alunos.nome,alunos.RM
    from livro inner join autor on livro.fk_autor = id_autor
    inner join emprestimo on emprestimo.fK_livro = id_livro
    inner join alunos on alunos.id_aluno = emprestimo.fk_aluno");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete(int $id_reserva){
        $stmt = $this->db->prepare("DELETE FROM emprestimo WHERE id_emprestimo = :id_reserva");

        $livro = $this->db->prepare("SELECT fk_livro FROM emprestimo WHERE id_emprestimo = :id_reserva");
        $livro->bindParam(":id_reserva",$id_reserva);
        
        $livro->execute();
        $livro = $livro->fetch(\PDO::FETCH_ASSOC);

        $update = $this->db->prepare("UPDATE livro SET emprestado = false where id_livro = :id_livro");
        $update->bindParam(":id_livro",$livro["fk_livro"]);
        $update->execute();

        $stmt->bindParam(":id_reserva",$id_reserva);
        $stmt->execute();
    }
}