<?
require_once __DIR__ . '/../src/init.php';

if (!empty($_GET["id"])) {
    $stmt = $pdo->prepare('SELECT * FROM Produit WHERE id = ?');
    $stmt->execute([
        $_GET['id']
    ]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM commentaire WHERE id_produit = ?');
    $stmt->execute([
        $_GET['id']
    ]);
    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php foreach ($products as $product) : ?>
        <?= $product["nom"] ?>
    <?php endforeach; ?>
    <table border="1">
    <tr>
        <th>Stock</th>
        <th>Prix</th>
        <th>Genre</th>
        <th>Nom</th>
        <th>Description</th>
    </tr>
    <?php foreach ($products as $product) : ?>
        <tr>
            <td><?= $product['stock'] ?></td>
            <td><?= $product['prix'] ?></td>
            <td><?= $product['genre'] ?></td>
            <td><?= $product['nom'] ?></td>
            <td><?= $product['commentaire'] ?></td>
        </tr>
    <?php endforeach; ?>

    <p></p>

    <tr>
        <th colspan="4">Commentaire</th>
        <th>Notation</th>
    </tr>
    <?php foreach ($commentaires as $commentaire) : ?>
        <tr>
            <td colspan="4"><?= $commentaire["commentaire"]?></td>
            <td><?= $commentaire["notations"]?></td>
        </tr>
    <?php endforeach; ?>
    <a href="/product.php" class="btn btn-primary">Retour a la boutique</a>
    </table>
   
</body>
</html>