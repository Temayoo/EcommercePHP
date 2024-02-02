<?php
require_once __DIR__ . '/../src/init.php';

// Vérifier si l'utilisateur est connecté
if (!isset($user['id'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /login.php");
    exit();
}
require_once __DIR__ . '/actions/panier.php';
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
        <form action="/actions/panier.php" method="post">
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