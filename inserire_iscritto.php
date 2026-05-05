<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_corso = $_POST['id_corso'];
    $id_membro = $_POST['id_membro'];
    $data_iscrizione = $_POST['data_iscrizione'];
    $orario_preferito = $_POST['orario_preferito'];

    $stmt = $conn->prepare("INSERT INTO Iscrizioni_Corsi (id_corso, id_membro, data_iscrizione, orario_preferito) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_corso, $id_membro, $data_iscrizione, $orario_preferito);
    $stmt->execute();
    $stmt->close();

    header('Location: dashboard.php');
    exit;
}

$corsi = $conn->query("SELECT id_corso, nome_corso FROM Corsi");
$membri = $conn->query("SELECT id_membro, CONCAT(nome, ' ', cognome) AS nome FROM Membri");
?>
