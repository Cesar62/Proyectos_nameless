<?php
// Cargar variables de entorno desde .env
$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

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