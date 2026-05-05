<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

$query = "
    SELECT IC.id_iscrizione, M.nome AS nome_membro, M.cognome AS cognome_membro, C.nome_corso
    FROM Iscrizioni_Corsi IC
    JOIN Membri M ON IC.id_membro = M.id_membro
    JOIN Corsi C ON IC.id_corso = C.id_corso
";
$iscritti = $conn->query($query);

$corsi = $conn->query("SELECT id_corso, nome_corso FROM Corsi");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_iscrizione = $_POST['id_iscrizione'];
    $nuovo_corso = $_POST['nuovo_corso'];

    $stmt = $conn->prepare("UPDATE Iscrizioni_Corsi SET id_corso = ? WHERE id_iscrizione = ?");
    $stmt->bind_param("ii", $nuovo_corso, $id_iscrizione);
    $stmt->execute();
    $stmt->close();

    header('Location: elenco_iscritti.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Elenco Iscritti</title>
</head>
<body>
    <h1>Elenco Iscritti</h1>
    <table>
        <tr>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Corso</th>
            <th>Cambia Corso</th>
        </tr>
        <?php while ($row = $iscritti->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nome_membro'] ?></td>
                <td><?= $row['cognome_membro'] ?></td>
                <td><?= $row['nome_corso'] ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id_iscrizione" value="<?= $row['id_iscrizione'] ?>">
                        <select name="nuovo_corso">
                            <?php
                            $corsi->data_seek(0);
                            while ($corso = $corsi->fetch_assoc()): ?>
                                <option value="<?= $corso['id_corso'] ?>"><?= $corso['nome_corso'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit">Cambia</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
