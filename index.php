<?php
    session_start();

    if (!isset($_COOKIE[session_name()])) {
        session_unset();
        session_destroy();
        session_start();   
    }

    require_once './vendor/autoload.php';
    require_once './app/Route/Web.php';
    require_once './app/Route/Router.php';
    require_once './app/config/Connection.php';
    require_once './app/models/Alunos.php';
    require_once './app/models/Livro.php';
    require_once './app/models/Autor.php';
    require_once './app/models/Reserva.php';
    require_once './app/models/Bibliotecaria.php';
    require_once './app/Http/Controllers/Controller.php';
    require_once './app/Http/Controllers/AlunosController.php';
    require_once './app/Http/Controllers/ContaController.php';
    require_once './app/Http/Controllers/LoginController.php';
    require_once './app/Http/Controllers/HomeController.php';
    require_once './app/Http/Controllers/ErrorController.php';
    require_once './app/Http/Controllers/LivroController.php';
    require_once './app/Http/Controllers/ReservaController.php';
    require_once './app/Http/Controllers/CategoriaController.php';
    require_once './app/Http/Middleware/QueueMiddleware.php';
    require_once './app/Http/Middleware/Auth.php';
    require_once './app/Http/Exception/ExceptionHandler.php';
    require_once './app/Http/Exception/RouteNotFoundException.php';

    define("PRJ_ROOT", __DIR__);
    define("PRJ_WEB_PATH", "http://localhost/php%20projects/prjGerencia-biblioteca");

    set_exception_handler(function(Throwable $th){
        if ($th instanceof App\Http\Exception\RouteNotFoundException) {
            echo (new App\Http\Exception\ExceptionHandler)->handle();
        }
    });

    if (isset($_SESSION["error_msg"])) {
        if ($_SESSION["error_msg"]['count'] === 0) {
            $_SESSION['error_msg']['count']++;
        }else{
            unset($_SESSION['error_msg']);
        }
    }

    App\Http\Middleware\QueueMiddleware::setMap([
        "auth" => App\Http\Middleware\Auth::class
    ]);

    try {
        $web = new routes\Web();
        echo $web->api();
    } catch (App\Http\Exception\RouteNotFoundException $e) {
        throw $e;
    }