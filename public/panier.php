<?php
require_once __DIR__ . '/../src/init.php';

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

// Le reste du code reste inchangé

// Si le formulaire n'a pas été soumis ou si le stock est suffisant, afficher le panier
$stmt = $pdo->prepare('SELECT Produit.id, Produit.nom, Produit.prix, Produit.genre, Produit.image_url, Produit.stock FROM produitCommande JOIN Commande ON produitCommande.id_commande = Commande.id JOIN Produit ON produitCommande.id_produit = Produit.id JOIN User ON commande.id_user = User.id WHERE User.id = ?');
$stmt->execute([$user['id']]);
$panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
</head>
<body>
    <div class="container">
        <form action="/panier.php" method="post">
            <?php foreach ($panier as $row): ?>
                <div class="product">
                    <p><img src="<?= $row['image_url'] ?>" alt="<?= $row['nom'] ?>"></p>
                    <div class="product-info">
                        <p><?= $row['nom'] ?></p>
                        <p><?= $row['genre'] ?></p>
                        <p><?= $row['prix'] ?></p>

                        <?php if ($user['admin']): ?>
                            <p>Stock: <?= $row['stock'] ?></p>
                        <?php elseif ($row['stock'] > 0): ?>
                            <p>Stock disponible</p>
                        <?php else: ?>
                            <p>Quantité épuisée</p>
                        <?php endif; ?>

                        <label for="quantite_<?= $row['id'] ?>">Quantité:</label>
                        <input type="number" name="quantite[<?= $row['id'] ?>]" value="1" min="1" max="1">
                        <p><a href="actions/retirerProduitPanier.php?id=<?= $row['id'] ?>" class="btn btn-primary">Supprimer l'article du panier</a></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary" name="submitCommande">Passer la commande</button>
                <a href="/product.php" class="btn btn-primary">Retour à la boutique</a>
            </div>
        </form>
    </div>
</body>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .product {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 20px;
        background-color: #fff;
        overflow: hidden;
    }

    .product img {
        max-width: 100px;
        float: left;
        margin-right: 10px;
    }

    .product-info {
        float: left;
    }

    .product p {
        margin: 0;
    }

    .btn-container {
        margin-top: 10px;
        clear: both;
    }

    .btn {
        display: inline-block;
        padding: 10px;
        background-color: #3498db;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin-right: 10px;
    }
</style>

</html>