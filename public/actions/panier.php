<?php
require_once __DIR__ . '/../../src/init.php';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitCommande'])) {
    // Récupère l'id de l'utilisateur
    $userId = $user['id'];

    // Vérifie si l'utilisateur a une commande en cours
    $stmtCheckCommande = $pdo->prepare('SELECT id FROM Commande WHERE id_user = ? AND status = "En Cours"');
    $stmtCheckCommande->execute([$userId]);
    $existingCommande = $stmtCheckCommande->fetch(PDO::FETCH_ASSOC);

    if ($existingCommande) {
        // Si une commande en cours existe, mettez à jour cette commande
        $commandeId = $existingCommande['id'];
    } else {
        // Sinon, créez une nouvelle commande
        $stmtInsertCommande = $pdo->prepare('INSERT INTO Commande (id_user,detail, status) VALUES (?, ?, "En Cours")');
        $stmtInsertCommande->execute([$userId, "Detail de la commandes"]);

        // Récupérez l'ID de la nouvelle commande
        $commandeId = $pdo->lastInsertId();
    }

    // Initialise une variable pour vérifier si tous les produits ont suffisamment de stock
    $stockSuffisant = true;

    // Initialiser un tableau pour stocker les mises à jour du stock
    $stockUpdates = [];

    foreach ($_POST['quantite'] as $produitId => $quantite) {
        // Vérifie si la quantité est valide
        if (!is_numeric($quantite) || $quantite < 1) {
            $stockSuffisant = false;
            break;
        }

        // Récupère les informations du produit
        $stmtProduit = $pdo->prepare('SELECT stock FROM Produit WHERE id = ?');
        $stmtProduit->execute([$produitId]);
        $produit = $stmtProduit->fetch(PDO::FETCH_ASSOC);

        // Vérifie si le stock est suffisant
        if ($produit['stock'] < $quantite) {
            $stockSuffisant = false;
            break;
        }

        // Ajouter la mise à jour du stock au tableau
        $stockUpdates[$produitId] = $quantite;
    }

    if ($stockSuffisant) {
        // Si le stock est suffisant, mettre à jour le stock
        foreach ($stockUpdates as $produitId => $quantite) {
            $stmtUpdateStock = $pdo->prepare('UPDATE Produit SET stock = stock - ? WHERE id = ?');
            $stmtUpdateStock->execute([$quantite, $produitId]);
        }

        $stmt = $pdo->prepare('SELECT Produit.id, Produit.nom, Produit.prix, Produit.genre, Produit.image_url, Produit.stock
        FROM produitCommande
        JOIN Commande ON produitCommande.id_commande = Commande.id
        JOIN Produit ON produitCommande.id_produit = Produit.id
        JOIN User ON commande.id_user = User.id
        WHERE User.id = ?');
        $stmt->execute([$user['id']]);
        $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Recupération de tous les details des article du panier
        $detail = "";
        $total = 0;
        foreach ($panier as $row) {
            $detail = "{$detail} Nom : {$row['nom']} Prix: {$row['prix']}€";
            $total = $total + $row['prix'];
        }

        // Mettre à jour le statut de la commande en "Envoyer" uniquement si elle est en cours
        $stmtUpdateCommande = $pdo->prepare('UPDATE Commande SET detail = ?, status = "Envoyer" WHERE id = ? AND status = "En Cours"');
        $stmtUpdateCommande->execute(["{$detail} Prix total : {$total}€", $commandeId]);

        $stmtUpdateCommande = $pdo->prepare('DELETE FROM produitCommande WHERE id_commande = ?');
        $stmtUpdateCommande->execute([$commandeId]);

        // Vérifier si la mise à jour a été effectuée
        if ($stmtUpdateCommande->rowCount() > 0) {
            // Rediriger l'utilisateur vers maCommande.php
            header('Location: /maCommande.php');
            exit();
        } else {
            // Afficher un message si la commande n'était pas en cours
            $_SESSION['error_message'] = "La commande n'était pas en cour ";
            header('Location: /product.php');
            die();
        }
    } else {
        // Si le stock n'est pas suffisant, afficher un message d'erreur
        $_SESSION['error_message'] = "Stock Insuffisant";
        header('Location: /product.php');
        die();
    }
}


$stmt = $pdo->prepare('SELECT Produit.id, Produit.nom, Produit.prix, Produit.genre, Produit.image_url, Produit.stock FROM produitCommande JOIN Commande ON produitCommande.id_commande = Commande.id JOIN Produit ON produitCommande.id_produit = Produit.id JOIN User ON commande.id_user = User.id WHERE User.id = ?');
$stmt->execute([$user['id']]);
$panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>