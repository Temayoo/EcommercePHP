<?php
require_once __DIR__ . '/../../src/init.php';

if (!empty($_GET["id"])) {
    $stmt = $pdo->prepare('SELECT * FROM Commande WHERE id = ? AND status = ?');
    $stmt->execute([
        $_GET['id'],
        "enCours"
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($row)) {
        // ajout pour la commande en cours
    }else{
        $stmt = $pdo->prepare('INSERT INTO Commande VALUES() id = ? AND status = ?');

    }
}




?>