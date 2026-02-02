<?php 
$host = "localhost";
$user = "root";
$password = "";
$sql_file = __DIR__ . "/create_databse.sql";

$sql_script = file_get_contents($sql_file);

try {
    $pdo = new PDO("mysql:host=$host", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $pdo->exec($sql_script);
    echo "Banco de dados criado com sucesso!";
} catch (\PDOException $th) {
    echo "Ocorreu um erro: ";
    $error = $th->errorInfo;

    if ($error[0] == 'HY000' && $error[1] == 2002) {
        echo "Conexão recusada. Por favor, ligue o mysql no xampp.";
    }else {
        echo $th->getMessage();
    }
}