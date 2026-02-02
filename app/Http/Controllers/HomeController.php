<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\models\Livro;



class HomeController extends Controller{
    private $livro;

    public function __construct()
    {
        $this->livro = new Livro();
    }

    public function index(){

        $livros = array(
        $this->livro->all()
        );
        
        return parent::view("view/home.html",[
            'livros' => $livros
        ]);
    }
}