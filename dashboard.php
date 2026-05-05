<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pica</title>
</head>
<body>
    <h1>benvenuto nella palestra pica</h1>
    <ul>
        <li><a href="inserire_iscritto.php">Inserisci Iscritto</a></li>
        <li><a href="corso_maggiore.php">Corso con più iscritti</a></li>
        <li><a href="elenco_iscritti.php">Elenco Iscritti</a></li>
        <li><a href="report.php">Report Corsi</a></li>
    </ul>
</body>
</html>
