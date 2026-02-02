<?php 
namespace App\Http\Controllers;

use App\models\Bibliotecaria;

class BibliotecariaController extends Controller{

    private $bibliotecaria;

    public function __construct()
    {
        $this->bibliotecaria = new Bibliotecaria();    
    }

    public function store(string $nome,string $email,string $senha,string $telefone){
        $this->bibliotecaria->create($nome,$email,$senha,$telefone);

    }
}

