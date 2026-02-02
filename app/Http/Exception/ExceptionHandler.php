<?php 
namespace App\Http\Exception;

use App\Http\Controllers\ErrorController;

class ExceptionHandler {
    private $errorController;

    public function __construct()
    {
        $this->errorController = new ErrorController;    
    }

    public function handle(){
        return $this->errorController->notFound();
    }
}