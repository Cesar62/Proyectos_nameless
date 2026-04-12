<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tux_technologies";

$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Lanza excepciones en errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Resultados como array asociativo
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Prepared statements reales
];

try {
    $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass, $opciones);
} catch (PDOException $e) {
    header("Location: Config/Error.php");
    die('Error de conexión: ' . $e->getMessage());
}
?>