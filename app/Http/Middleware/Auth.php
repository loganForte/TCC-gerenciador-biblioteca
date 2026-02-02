<?php 
namespace App\Http\Middleware;

class Auth{
    public function handle($next){
        if (empty($_SESSION)) {
            header("Location: http://localhost/php%20projects/prjGerencia-biblioteca/");
        }else{
            return $next();
        }
    }
}