<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tux_technologies";

try {
    $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
} catch (PDOException $e) {
    header("Location: Config/Error.php");
}
?>