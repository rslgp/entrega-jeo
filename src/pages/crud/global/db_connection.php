<?php
$host = "localhost:3308";
$username = "root";
$password = "";
$database = "GGames";

//$conn = mysqli_connect($host, $username, $password, $database) OR die("Error connecting to MySQL: " . mysqli_connect_error());;

$pdo = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
//nome, genero, valor, plataforma
    $sql = "CREATE TABLE IF NOT EXISTS games  (
        id INT KEY AUTO_INCREMENT,
        nome VARCHAR(255),
        genero VARCHAR(255),
        valor VARCHAR(255),
        plataforma VARCHAR(255)
    )";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute();
} catch (PDOException $e) {
    // Handle any errors here
    die("Error: " . $e->getMessage());
}
?>