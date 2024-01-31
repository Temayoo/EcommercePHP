<?php
require_once __DIR__ . '/../src/init.php';

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
        

        <table border="1">
            <tr>
                <th>Image</th>
                <th>Prix</th>
                <th>Genre</th>
                <th>Nom</th>
                <?php if ($user["admin"]) : ?>
                    <th>Stock</th>
                    <th>Supprimer</th>
                    <th>Modifier</th>
                <?php endif ?>
            </tr>
            <?php foreach ($products as $product) : ?>
                <?$id = $product["id"]?>
                <tr>
                    <td><img src="<?= $product['image_url'] ?>" alt="<?= $product['nom'] ?>" width="100"></td>
                    <td><?= $product['prix'] ?></td>
                    <td><?= $product['genre'] ?></td>
                    <td><a href="produitChoisie.php?id=<?= $id ?>"><?= $product['nom'] ?></a></td>
                    <?php if ($user["admin"]) : ?>
                        <td><?= $product['stock'] ?></td>
                        <td><a href="actions/supprimeeArticle.php?id=<?= $id ?>">Supprimer l'article</a></td>
                        <td><a href="modifieArticle.php?id=<?= $id ?>">Modifier l'article</a></td>
                    <?php endif ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <a href="/panier.php" class="btn btn-primary">Aller a votre Panier</a>




    <?php if ($user["admin"]) : ?>
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

    <?php endif ?>

    <?php require_once __DIR__ . '/../src/partials/show_error.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_success.php'; ?>

    
</body>

<style>
    .add-product-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .add-product-form fieldset {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }

    .add-product-form label {
        display: inline-block;
        width: 100px;
        margin-bottom: 5px;
    }

    .add-product-form input,
    .add-product-form textarea {
        width: 100%;
        padding: 5px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    .add-product-form button {
        padding: 10px;
        background-color: #4caf50;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>


</html>