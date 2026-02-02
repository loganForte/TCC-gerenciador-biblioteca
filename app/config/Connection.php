<?php 
namespace App\config;

class Connection{
    private $connection;
    private static $instance = null;

    private function __construct(){
        $config = require __DIR__."/connection_config.php";
        $this->connection = new \PDO("mysql:dbname=". $config["dbname"].";".$config["host"],$config["user"],$config["password"],[
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->connection;
    }
}