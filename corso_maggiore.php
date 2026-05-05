<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

$query = "
    SELECT I.nome, I.cognome, C.nome_corso, COUNT(IC.id_iscrizione) AS iscritti
    FROM Istruttori I
    JOIN Corsi C ON I.id_istruttore = C.id_istruttore
    JOIN Iscrizioni_Corsi IC ON C.id_corso = IC.id_corso
    GROUP BY C.id_corso
    HAVING iscritti >= 5
    ORDER BY iscritti DESC
";
$result = $conn->query($query);
?>
