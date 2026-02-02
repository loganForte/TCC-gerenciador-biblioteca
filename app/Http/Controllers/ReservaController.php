<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\models\Reserva;
use DateTime;
use DateTimeZone;

class ReservaController extends Controller{
    private $reserva;


    public function __construct()
    {
        $this->reserva = new Reserva();
    }

    public function create(int $id_livro){
        $data = new DateTime('now',new DateTimeZone('America/Sao_Paulo'));

        $data_emprestimo = $data->format("Y-m-d");
        $data->modify("+1 week");
        $data_devolucao = $data->format("Y-m-d");

        $this->reserva->create($data_emprestimo,$data_devolucao,$_SESSION["aluno_id"],$id_livro);

        header("Location: " . PRJ_WEB_PATH . "/conta");
    }

    public function delete(int $id_reserva){
        $this->reserva->delete($id_reserva);
        header("Location: " . PRJ_WEB_PATH . "/conta");
    }
}
