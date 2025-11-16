<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$database = $_ENV['DB_NAME'];

//conexão
$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}


mysqli_set_charset($conn, "utf8mb4");

?>
