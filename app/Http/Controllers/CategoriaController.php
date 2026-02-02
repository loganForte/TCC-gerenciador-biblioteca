<?php 
namespace App\Http\Controllers;

use App\models\Livro;

class CategoriaController extends Controller{
    private $livro;

    public function __construct()
    {
        $this->livro = new Livro();    
    }

    public function index(){
        return parent::view("view/categorias.html");
    }

    public function show(string $categoria){
        $livros = $this->livro->getLivroWhere("categoria",$categoria);
        
        return parent::view("view/categoria-mostrar.html",[
            "categoria_atual" => $categoria,
            "livros" => $livros
        ]);
    }
}