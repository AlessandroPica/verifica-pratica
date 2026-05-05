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
<!DOCTYPE html>
<html>
<head>
    <title>Corso con più iscritti</title>
</head>
<body>
    <h1>Corso con più iscritti</h1>
    <table>
        <tr>
            <th>Istruttore</th>
            <th>Corso</th>
            <th>Iscritti</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nome'] . ' ' . $row['cognome'] ?></td>
                <td><?= $row['nome_corso'] ?></td>
                <td><?= $row['iscritti'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
