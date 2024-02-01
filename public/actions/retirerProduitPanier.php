<?php
require_once __DIR__ . '/../../src/init.php';
    if (isset($_GET["id"])) {
        $stmt = $pdo->prepare('SELECT * FROM Commande WHERE id_user = ? AND status = ?');
        $stmt->execute([
            $user['id'],
            "En Cours"
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($row)) {
            $stmt = $pdo->prepare('DELETE FROM produitCommande WHERE id_produit = ?');
            $stmt->execute([
                $_GET['id']
            ]);
            header('Location: /../panier.php');

        }

    }
    

?>