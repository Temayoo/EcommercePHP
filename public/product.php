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

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.product {
    border: 1px solid #ccc;
    padding: 15px;
    width: calc(48% - 20px); /* Ajuster la largeur pour avoir deux produits par ligne avec un espacement */
    box-sizing: border-box;
    text-align: center;
    margin-bottom: 20px;
}

.product img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

.product p {
    margin: 0;
}

.product a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

.product a:hover {
    text-decoration: underline;
}

.center-button {
    text-align: center;
    margin-top: 20px;
}

.btn-primary {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.centered-form {
    max-width: 400px;
    margin: 0 auto;
    text-align: center;
}

.add-product-form fieldset {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
    text-align: left;
}

.add-product-form label {
    display: block;
    margin-bottom: 10px;
}

.add-product-form input,
.add-product-form textarea,
.add-product-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

.add-product-form button {
    width: 100%;
    padding: 10px;
    background-color: #4caf50;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="number"] {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    margin-bottom: 15px;
}

select {
    padding: 5px;
    box-sizing: border-box;
    margin-bottom: 15px;
}

button[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}


</style>

</html>
