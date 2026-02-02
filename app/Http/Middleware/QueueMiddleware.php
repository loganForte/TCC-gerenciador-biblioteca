<?php 
namespace App\Http\Middleware;

use Exception;

class QueueMiddleware{
    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewareQueue = [];
    
    /**
     * mapeamento de middlewares
     */
    private static $map = [];

    private $controller_method;
    
    /**
     * parâmetros que o método do controller irá receber
     * @var array
     */
    private $controller_args = [];
    
    private $controller_class;

    /**
     * construtor
     * @param array
     * @param array
     */
    public function __construct(array $middlewareQueue,object $controller_class,$controller_method,array $controller_args){
        $this->middlewareQueue = $middlewareQueue;
        $this->controller_class = $controller_class;
        $this->controller_method = $controller_method;
        $this->controller_args = $controller_args;
    }

    /**
     * exexuta o próximo nível de middleware
    */
    public function next(){
        if (empty($this->middlewareQueue)) {
            return call_user_func_array([$this->controller_class,$this->controller_method],$this->controller_args);
        }
        $middleware = array_shift($this->middlewareQueue);
        
        if (!isset(self::$map[$middleware])) {
            throw new Exception("The middleware doesn't exist");
        }
        
        $middleware_queue_instance = $this;
        $next = function() use($middleware_queue_instance){
            return $middleware_queue_instance->next();
        };
        
        $a = new self::$map[$middleware]();
        
        return $a->handle($next);
    }

    public static function setMap($map){
        self::$map = $map;
    }

}