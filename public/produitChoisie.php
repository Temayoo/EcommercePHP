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
    <div>
    <table border="1" >
    <tr>
        <th>Stock</th>
        <th>Prix</th>
        <th>Genre</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Ajouter au Panier</th>

    </tr>
    <?php foreach ($products as $product) : ?>
        <tr>
            <td><?= $product['stock'] ?></td>
            <td><?= $product['prix'] ?></td>
            <td><?= $product['genre'] ?></td>
            <td><?= $product['nom'] ?></td>
            <td><?= $product['commentaire'] ?></td>
            <td><a href="action/ajoutArctivle.php?id=<?= $id ?>">Achter</a></td>

        </tr>
    <?php endforeach; ?>

    <p></p>
    <?php
        //si commande enregistrer >= 1 alors on affiche les commentaire et la notation,
        // + ajout d un bouton ou d un lien vers un petit formulaire pour add un commentaire + notation ?>
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
    </div>
   
</body>
</html>