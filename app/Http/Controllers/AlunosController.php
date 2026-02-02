<?php 
namespace App\Http\Controllers;

use App\models\Alunos;

class AlunosController extends Controller{
    private $alunos;

    public function __construct()
    {
        $this->alunos = new Alunos();
    }

    public function index(){
        $aluno = $this->alunos->getAlunosWhere("id_aluno",$_SESSION["aluno_id"]);
        return parent::view("view/conta.html",[
            'aluno' => $aluno
        ]);
    }

}