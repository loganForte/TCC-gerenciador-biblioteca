<?php 
namespace App\Route;

use App\Http\Exception\RouteNotFoundException;
use App\Http\Middleware\QueueMiddleware;

class Router{
    private $routes = array();
    private $middleware_queue = [];

    private function addRoute(string $method,string $route,$callback,$middleware=null){
        $route = preg_replace('/\{(\w+)}/','(\w+)',$route);
        $route = "#^$route$#";
        $this->middleware_queue[$route] = isset($middleware) ? $middleware : [];
        $this->routes[$method][$route] = array('callback' => $callback);
    }

    public function route(){
        $uri = array_key_exists("url",$_REQUEST) ? "/".$_REQUEST["url"] : "/";
        $method = $_SERVER["REQUEST_METHOD"];

        foreach($this->routes[$method] as $route => $data){
            if (preg_match($route,$uri,$matches)) {
                array_shift($matches);
                $callback = $data['callback'];
                $class = new $callback[0];

                $queueMiddleware = new QueueMiddleware($this->middleware_queue[$route],$class,$callback[1],$matches);
                return $queueMiddleware->next();
            }
        }
        throw new RouteNotFoundException();
    }

    public function get($route,$callback,$middleware=null){
        $this->addRoute('GET',$route,$callback,$middleware);
    }

    public function post($route,$callback,$middleware=null){
        $this->addRoute('POST',$route,$callback,$middleware);       
    }
}