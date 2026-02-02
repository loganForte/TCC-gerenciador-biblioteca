<?php 
namespace routes;

use app\Route\Router;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReservaController;

class Web{
    public function api(){
        $router = new Router();
        $router->get("/",[LoginController::class,'index']);
        $router->post("/login/check",[LoginController::class,'check']);

        $router->get("/home",[HomeController::class,'index'],["auth"]);

        $router->get("/categorias",[CategoriaController::class,'index'],["auth"]);
        $router->get("/categorias/{categoria}",[CategoriaController::class,'show'],["auth"]);

        $router->get("/livro",[LivroController::class,'index'],["auth"]);
        $router->get("/livro/store",[LivroController::class,"store"],["auth"]);
        $router->post("/livro/create",[LivroController::class,"create"], ["auth"]);

        $router->get("/livro/search/{query}",[LivroController::class,"search"], ["auth"]);

        $router->get("/livro/{id}",[LivroController::class,"show"],["auth"]);
        $router->get("/reservar/{id}",[LivroController::class,"reservar"],["auth"]);

        $router->get("/reservar/devolver/{id}",[ReservaController::class,"delete"],["auth"]);
        
        $router->get("/conta",[ContaController::class,"index"],["auth"]);

        $router->get("/logout",[ContaController::class,"logout"],["auth"]);

        return $router->route();
    }
}