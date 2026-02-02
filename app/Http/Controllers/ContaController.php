<?php 
namespace App\Http\Controllers;

use App\models\Reserva;
use DateTime;
use DateTimeZone;

class ContaController extends Controller{
    private $reserva;

    public function __construct()
    {
        $this->reserva = new Reserva();
    }

    public function logout(){
        session_destroy();
        header("Location: " . PRJ_WEB_PATH . "/");
    }

    public function index(){
        if ($_SESSION["tipo"] === "aluno") {
            $reserva = $this->reserva->getReservaToAluno($_SESSION["aluno_id"]);

            if (empty($reserva)) {
                return parent::view("view/conta.html");
            }

            $data_reserva = DateTime::createFromFormat('d/m/Y',$reserva[0]["emprestimo"],new DateTimeZone('America/Sao_Paulo'));
            $data_devolucao = DateTime::createFromFormat('d/m/Y',$reserva[0]["devolucao"],new DateTimeZone('America/Sao_Paulo'));

            return parent::view("view/conta.html",[
                'dados' => $reserva,
                'dias_entrega' => $data_reserva->diff($data_devolucao)->days
            ]);
        }else{
            $reserva = $this->reserva->getReservaToBibliotecaria();
            
            if (empty($reserva)) {
                return parent::view("view/conta.html");
            }

            $data_reserva = DateTime::createFromFormat('d/m/Y',$reserva[0]["emprestimo"],new DateTimeZone('America/Sao_Paulo'));
            $data_devolucao = DateTime::createFromFormat('d/m/Y',$reserva[0]["devolucao"],new DateTimeZone('America/Sao_Paulo'));

            return parent::view("view/conta.html",[
                'dados' => $reserva,
                'dias_entrega' => $data_reserva->diff($data_devolucao)->days
            ]);
        }
    }

}