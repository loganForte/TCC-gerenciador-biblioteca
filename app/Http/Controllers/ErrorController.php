<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ErrorController extends Controller{

    public function notFound(){
        return parent::view("view/erro-404.html");
    }
}