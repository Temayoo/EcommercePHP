<?php
require_once __DIR__ . '/../src/init.php';

// Vérifier si l'utilisateur est connecté
if (!isset($user['id'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /login.php");
    exit();
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';

// Récupérer la liste des genres distincts dans la base de données
$stmtGenres = $pdo->query('SELECT DISTINCT genre FROM Produit');
$genres = $stmtGenres->fetchAll(PDO::FETCH_COLUMN);

if (!empty($selectedGenre)) {
    // Si un genre est sélectionné, filtrer par ce genre
    $stmt = $pdo->prepare('SELECT * FROM Produit WHERE genre = ? AND nom LIKE ?');
    $stmt->execute([$selectedGenre, "%$searchTerm%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Sinon, afficher tous les produits
    $stmt = $pdo->prepare('SELECT * FROM Produit WHERE nom LIKE ? OR genre LIKE ?');
    $stmt->execute(["%$searchTerm%", "%$searchTerm%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Liste des Produits</title>
</head>
<body>


    <?php require_once __DIR__ . '/../src/partials/menu.php';?>
    <a href="/Mescommandes.php" class="btn btn-primary">vos commandes</a>
    <div class="container">
        <h1>Liste des Produits</h1>

        <form method="get">
            <label for="search">Rechercher un produit :</label>
            <input type="text" id="search" name="search" value="<?= $searchTerm ?>">

            <label for="genre">Trier par genre :</label>
            <select id="genre" name="genre">
                <option value="" <?= ($selectedGenre === '') ? 'selected' : '' ?>>Tous les genres</option>
                <?php foreach ($genres as $genre) : ?>
                    <option value="<?= $genre ?>" <?= ($selectedGenre === $genre) ? 'selected' : '' ?>>
                        <?= $genre ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Rechercher</button>
        </form>
       
        <div class="product-container">
            <?php $count = 0; ?>
            <?php foreach ($products as $product) : ?>
                <?php $id = $product["id"] ?>
                <a href=""></a>
                <div class="product">
                <a href="produitChoisie.php?id=<?= $id ?>">
                    <img src="<?= $product['image_url'] ?>" alt="<?= $product['nom'] ?>" width="100">
                    <p><strong>Prix:</strong> <?= $product['prix'] ?></p>
                    <p><strong>Genre:</strong> <?= $product['genre'] ?></p>
                    <p><strong>Nom:</strong> <?= $product['nom'] ?></p>
                    <p><a href="actions/ajoutArticle.php?id=<?= $id ?>">Rajouter au panier</a></p>
                    </a>
                    <?php if ($user["admin"]) : ?>
                        <p><strong>Stock:</strong> <?= $product['stock'] ?></p>
                        <p><a href="actions/supprimeeArticle.php?id=<?= $id ?>">Supprimer l'article</a></p>
                        <p><a href="modifieArticle.php?id=<?= $id ?>">Modifier l'article</a></p>
                    <?php endif ?>
                </div>
                <?php $count++; ?>
                <?php if ($count % 2 === 0) : ?>
                    <div style="clear: both;"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
                <div class="center-button">
    <a href="/panier.php" class="btn btn-primary">Aller a votre Panier</a>
                </div>
    <?php if ($user["admin"]) : ?>
    <div class="centered-form">
        <form action="/actions/addProduct.php" method="post" class="add-product-form">
            <fieldset>
                <legend>Ajouter un Produit</legend>

                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required><br>

                <label for="genre">Genre :</label>
                <input type="text" id="genre" name="genre" required><br>

                <label for="prix">Prix :</label>
                <input type="number" step="0.01" id="prix" name="prix" required><br>

                <label for="stock">Stock :</label>
                <input type="number" id="stock" name="stock" required><br>

                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire"></textarea><br>

                <label for="image_url">URL de l'image :</label>
                <input type="text" id="image_url" name="image_url" required><br>

                <button type="submit">Ajouter le Produit</button>
            </fieldset>
        </form>
    </div>

    <div class="center-button">
        <a href="/commandePasse.php" class="btn btn-primary">Voir les commandes passées</a>
    </div>
<?php endif ?>


    <?php require_once __DIR__ . '/../src/partials/show_error.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_success.php'; ?>
    
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
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
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
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    select {
        height: 40px; /* ajuster la hauteur du menu déroulant */
    }

    .product-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .product {
        width: 48%; /* pour deux produits par ligne */
        margin-bottom: 20px;
        padding: 15px;
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
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
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
        padding: 10px 20px;
        font-size: 16px;
        text-decoration: none;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

</style>
