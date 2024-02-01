<?php
require_once __DIR__ . '/../../src/init.php';

if (isset($_GET["id"])) {
    $stmt = $pdo->prepare('SELECT * FROM Commande WHERE id = ? AND status = ?');
    $stmt->execute([
        $_GET['id'],
        "En Cours"
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($row)) {
        foreach ($row as $commmande) {
            $stmt = $pdo->prepare('INSERT INTO ProduitCommande (id_produit, id_commande, quantite) VALUES ( ?, ?, 1)');
            $stmt->execute([
                $user['id'],
                $commande["id"]
        ]);
        }
        $_SESSION['success_message'] = 'Ajouter au panier';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
        //Rajouter a la commande
    }else{
        //Création de la commande
        $stmt = $pdo->prepare('INSERT INTO Commande (id_user, date_update, status) VALUES (?, NOW(), ?) ');
        $stmt->execute([
            $user['id'],
            'En Cours'
        ]);
        $idCommande = $pdo->lastInsertId();

        $stmt = $pdo->prepare('INSERT INTO ProduitCommande (id_produit, id_commande, quantite) VALUES ( ?, ?, 1)');
        $stmt->execute([
            $user['id'],
            $idCommande
        ]);

        $_SESSION['success_message'] = 'Ajouter au panier + création de commande';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }
}




?>