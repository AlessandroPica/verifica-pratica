<?php
$host = 'localhost';
$user = 'root';
$password = 'your_password';
$dbname = 'pica_gym';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>
