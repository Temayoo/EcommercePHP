<?php
require_once __DIR__ . '/../src/init.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchTerm)) {
    $stmt = $pdo->prepare('SELECT * FROM Produit WHERE nom LIKE ? OR genre LIKE ?');
    $stmt->execute(["%$searchTerm%", "%$searchTerm%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si la barre de recherche n'est pas rempli on print tout
    $stmt = $pdo->query('SELECT * FROM Produit');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
</head>
<body>

    <div class="container">
        <h1>Liste des Produits</h1>

        <form method="get">
            <label for="search">Rechercher un produit :</label>
            <input type="text" id="search" name="search" value="<?= htmlentities($searchTerm) ?>">
            <button type="submit">Rechercher</button>
        </form>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Stock</th>
                <th>Prix</th>
                <th>Genre</th>
                <th>Nom</th>
                <th>Commentaire</th>
                <th>Notations</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td><?= $product['prix'] ?></td>
                    <td><?= $product['genre'] ?></td>
                    <td><?= $product['nom'] ?></td>
                    <td><?= $product['commentaire'] ?></td>
                    <td><?= $product['notations'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>
