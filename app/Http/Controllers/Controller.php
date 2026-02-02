<?php 
namespace App\Http\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller{
     private const VIEW_DIRECTORY = "./resources";

    protected function view(string $view_name, array $arguments = []){
        $loader = new FilesystemLoader(Controller::VIEW_DIRECTORY);
        $twig = new Environment($loader);

        $twig->addGlobal("session",$_SESSION);
        $twig->addGlobal("web_path",PRJ_WEB_PATH);

        $view = $twig->load($view_name);

        return $view->render($arguments);
    }
}