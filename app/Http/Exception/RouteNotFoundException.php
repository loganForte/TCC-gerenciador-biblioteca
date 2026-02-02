<?php 
namespace App\Http\Exception;

use Exception;

class RouteNotFoundException extends Exception{
    public function __construct()
    {
        parent::__construct("A rota não foi encontrada",404);
    }
}