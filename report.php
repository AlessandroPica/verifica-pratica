<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}


$query = "
    SELECT I.nome AS nome_istruttore, I.cognome AS cognome_istruttore, C.nome_corso, 
           M.nome AS nome_membro, M.cognome AS cognome_membro
    FROM Istruttori I
    JOIN Corsi C ON I.id_istruttore = C.id_istruttore
    LEFT JOIN Iscrizioni_Corsi IC ON C.id_corso = IC.id_corso
    LEFT JOIN Membri M ON IC.id_membro = M.id_membro
    ORDER BY I.cognome, I.nome, C.nome_corso, M.cognome, M.nome
";
$report = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report Corsi</title>
</head>
<body>
    <h1>Report Corsi</h1>
    <table>
        <tr>
            <th>Istruttore</th>
            <th>Corso</th>
            <th>Iscritto</th>
        </tr>
        <?php while ($row = $report->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nome_istruttore'] . ' ' . $row['cognome_istruttore'] ?></td>
                <td><?= $row['nome_corso'] ?></td>
                <td>
                    <?php
                    if ($row['nome_membro'] && $row['cognome_membro']) {
                        echo $row['cognome_membro'] . ' ' . $row['nome_membro'];
                    } else {
                        echo "Nessun iscritto";
                    }
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
