<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\models\Alunos;
use App\models\Bibliotecaria;

class LoginController extends Controller{
    private $aluno;
    private $bibliotecaria;

    public function __construct(){
        $this->aluno = new Alunos();
        $this->bibliotecaria = new Bibliotecaria();
    }

    public function index(){
        if (isset($_SESSION['aluno_id']) || isset($_SESSION['bibliotecario_id'])) {
            header("Location: " . PRJ_WEB_PATH . "/home"); 
        }

        if (isset($_SESSION["error_msg"])) {
            return parent::view("view/login.html",[
                'error_msg' => $_SESSION['error_msg'],
                'message' => $_SESSION['error_msg']["msg"]
            ]);
        }
        
        return parent::view("view/login.html");
    }

    public function check(){
        $tipo = $_POST["tipo"];
        $email = $_POST['email'];
        $nome = $_POST['nome'] ?? 0;
        $senha = $_POST['senha'];
        
        if ($tipo === "aluno") {
            
            $aluno = $this->aluno->getAlunosWhere("email_institucional",$email);
            
            if (!$aluno) {
                $_SESSION["error_msg"] = array("msg" => "Email não encontrado", 'count' => 0);
                header("Location: " . PRJ_WEB_PATH . "/");
                
            }else if (!password_verify($senha,$aluno["senha"])) {
                $_SESSION["error_msg"] = array("msg" => "senha incorreta", 'count' => 0);
                header("Location: " . PRJ_WEB_PATH . "/");
                
            }else{
                $_SESSION["aluno_id"] = $aluno["id_aluno"];
                $_SESSION["tipo"] = "aluno";
                $_SESSION["nome"] = $aluno["nome"];
        
                header("Location: " . PRJ_WEB_PATH . "/home");
            }

        }else{
            $bibliotecario = $this->bibliotecaria->getWhere("email_institucional",$email);
            
            if (!$bibliotecario) {
                $_SESSION["error_msg"] = array("msg" => "Email não encontrado", 'count' => 0);
                header("Location: " . PRJ_WEB_PATH . "/");

            }else if ($bibliotecario["nome"] !== $nome) {
                $_SESSION["error_msg"] = array("msg" => "Nome incorreto", 'count' => 0);
                header("Location: " . PRJ_WEB_PATH . "/");
            }else if (!password_verify($senha,$bibliotecario["senha"])) {
                $_SESSION["error_msg"] = array("msg" => "senha incorreta", 'count' => 0);
                header("Location: " . PRJ_WEB_PATH . "/");

            }else{
                $_SESSION["tipo"] = "bibliotecario";
                $_SESSION["bibliotecario_id"] = $bibliotecario["id_bibliotecaria"];
                $_SESSION["nome"] = $bibliotecario["nome"];
        
                header("Location: " . PRJ_WEB_PATH . "/home");
            }
        }
    }
}