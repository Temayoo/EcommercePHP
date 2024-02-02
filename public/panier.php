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
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    color: #333;
}

.container {
    max-width: 1000px; /* Increased container width for better readability */
    margin: 20px auto;
    background-color: #fff;
    padding: 30px; /* Increased padding for better spacing */
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 36px;
    margin-bottom: 20px;
    color: #3498db;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input, select, button {
    width: 100%;
    padding: 12px; /* Increased padding for better input/button size */
    margin-bottom: 20px; /* Increased margin for better spacing */
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

select {
    height: 40px;
}

.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.product {
    width: 48%;
    margin-bottom: 20px;
    padding: 20px; /* Increased padding for better spacing */
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    float: left;
    box-sizing: border-box;
}

.product img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

.center-button {
    text-align: center;
    margin-top: 20px;
}

.centered-form {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 30px; /* Increased padding for better spacing */
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.centered-form fieldset {
    border: none;
}

.centered-form legend {
    font-size: 24px;
    font-weight: bold;
    color: #3498db;
    margin-bottom: 20px;
}

.btn-primary {
    background-color: #3498db;
    color: #fff;
    padding: 12px 20px; /* Increased padding for better button size */
    font-size: 16px;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #2980b9;
}

</style>

</html>
   