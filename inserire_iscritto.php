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
<!DOCTYPE html>
<html>
<head>
    <title>Inserisci Iscritto</title>
</head>
<body>
    <form method="POST">
        <label>Corso:</label>
        <select name="id_corso">
            <?php while ($corso = $corsi->fetch_assoc()): ?>
                <option value="<?= $corso['id_corso'] ?>"><?= $corso['nome_corso'] ?></option>
            <?php endwhile; ?>
        </select>
        <label>Membro:</label>
        <select name="id_membro">
            <?php while ($membro = $membri->fetch_assoc()): ?>
                <option value="<?= $membro['id_membro'] ?>"><?= $membro['nome'] ?></option>
            <?php endwhile; ?>
        </select>
        <label>Data Iscrizione:</label>
        <input type="date" name="data_iscrizione" required>
        <label>Orario Preferito:</label>
        <input type="time" name="orario_preferito" required>
        <button type="submit">Inserisci</button>
    </form>
</body>
</html>
