<?php 
namespace App\models;

use \App\Config\Connection as conn;

class Livro{
    private $db;

    public function __construct()
    {   
        $this->db = conn::getInstance()->getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM livro");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM livro INNER JOIN autor ON livro.fk_autor = autor.id_autor");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getLivroWhere(string $coluna,$filtro): array
    {
        $stmt = $this->db->prepare("SELECT * FROM livro WHERE ". $coluna ."= :filtro");
        $stmt->bindParam(":filtro",$filtro);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getLivroAutorWhere(string $coluna,$filtro): array
    {
        $stmt = $this->db->prepare("SELECT * FROM livro INNER JOIN autor ON livro.fk_autor = autor.id_autor WHERE ". $coluna ."= :filtro");
        $stmt->bindParam(":filtro",$filtro);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getAutor(int $id): string
    {
        $stmt = $this->db->prepare('SELECT autor.nome FROM livro JOIN autor ON livro.fk_autor = autor.id_autor WHERE livro.id_livro = :id');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = implode($stmt->fetch(\PDO::FETCH_ASSOC));
        return $result ? $result : "";        
    }

    public function searchLivro(string $query): array
    {
        $stmt = $this->db->prepare("SELECT * FROM livro INNER JOIN autor ON livro.fk_autor = autor.id_autor WHERE livro.titulo LIKE :query OR autor.nome LIKE :query");
        $likeQuery = "%" . $query . "%";
        $stmt->bindParam(":query",$likeQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function create(string $titulo,int $id_autor, int $id_bibliotecaria,string $categoria,string $caminho_capa,string $editora,int $ano_publicacao,int $quantidade){
        $stmt = $this->db->prepare("INSERT INTO livro(titulo,fk_autor,fk_bibliotecaria,categoria,url,editora,ano_publicacao,quantidade) value (:titulo,:autor,:bibliotecaria,:categoria,:caminho_imagem,:editora,:ano_publicacao,:quantidade)");

        $url = "http://localhost/php%20projects/prjGerencia-biblioteca" . $caminho_capa;

        $stmt->bindParam(':titulo',$titulo);
        $stmt->bindParam(':autor',$id_autor);
        $stmt->bindParam(':bibliotecaria',$id_bibliotecaria);
        $stmt->bindParam(':categoria',$categoria);
        $stmt->bindParam(':caminho_imagem',$url);
        $stmt->bindParam(':editora',$editora);
        $stmt->bindParam(':ano_publicacao',$ano_publicacao);
        $stmt->bindParam(':quantidade',$quantidade);
        $stmt->execute();

    }
}