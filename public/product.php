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

<?php
require_once __DIR__ . '/../src/partials/menu.php';
?>

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
                <th>Prix</th>
                <th>Genre</th>
                <th>Nom</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <?$id = $product["id"]?>
                <tr>
                    <td><?= $product['prix'] ?></td>
                    <td><?= $product['genre'] ?></td>
                    <td><a href="produit_choisie.php?id=<?= $id ?>"><?= $product['nom'] ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <a href="/panier.php" class="btn btn-primary">Aller a votre Panier</a>
</body>
</html>
