<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\models\Livro;
use App\models\Autor;
use DateTime;
use DateTimeZone;

class LivroController extends Controller{
    private $livro;
    private $autor;
    private $data_devolucao;

    public function __construct()
    {
        $this->livro = new Livro();
        $this->autor = new Autor();
    }

    public function index(){
        $livros = $this->livro->getAll();

        return parent::view("view/todos-os-livros.html",[
            'livros' => $livros
        ]);
    }

    public function show(int $id){
        
        $livro = $this->livro->getLivroAutorWhere("id_livro",$id);

        $data = new DateTime('now',new DateTimeZone('America/Sao_Paulo'));
        $data->modify("+1 week");
        $this->data_devolucao = $data->format("d/m/Y");

        if (isset($_SESSION["error_msg"])) {
            return parent::view("view/livro-reservar.html",[
                'livro' => $livro,
                'devolucao' => $this->data_devolucao,
                'error_msg' => $_SESSION['error_msg'],
                'message' => $_SESSION['error_msg']["msg"]
            ]);
        }

        return parent::view("view/livro-reservar.html",[
            'livro' => $livro,
            'devolucao' => $this->data_devolucao,
        ]);
    }

    public function store(){
        return parent::view("view/adicionar-livro.html");
    }

    public function create(){
        $caminho = PRJ_ROOT.'./public/images/livro/'. uniqid('',true) .".jpg";
        move_uploaded_file($_FILES["capa-livro"]["tmp_name"],$caminho);

        $caminho = preg_replace('/\./','',$caminho,1);

        $id_autor = $this->autor->create($_POST["autor"]);
        $id_bibliotecaria = $_SESSION["bibliotecario_id"];

        $this->livro->create($_POST["titulo"],$id_autor,$id_bibliotecaria,$_POST["categoria"],$caminho,$_POST["editora"],$_POST["ano-publicacao"],$_POST["quantidade"]);
        
        header("location: " . PRJ_WEB_PATH . "/livro/store");
        
    }

    public function reservar(int $id){

        $livro = $this->livro->getLivroWhere("id_livro",$id)[0];

        if ($livro["emprestado"] == 1) {
            $_SESSION["error_msg"] = array("msg" => "Livro já emprestado", 'count' => 0);

            header("Location: " . PRJ_WEB_PATH . "/livro/{$id}");
        }else{
            $reservar = new ReservaController();
            return $reservar->create($id);
        }
    }

    public function search(String $query){
        $livros = $this->livro->searchLivro($query);

        return parent::view("view/todos-os-livros.html",[
            'livros' => $livros
        ]);
    }
}