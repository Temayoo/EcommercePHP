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

$stmt = $pdo->prepare('SELECT * FROM Commande WHERE id_user = ? AND status = "Envoyer" OR status = "Reçu"');
$stmt->execute([
    $user["id"]
]);
$commandeUser = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Produit</title>
</head>
<body>
    <?php foreach ($products as $product) : ?>
        <h2><?= $product["nom"] ?></h2>
        <img src="<?= $product['image_url'] ?>" alt="<?= $product['nom'] ?>" width="300">
        <p><strong>Stock:</strong> <?= $product['stock'] ?></p>
        <p><strong>Prix:</strong> <?= $product['prix'] ?></p>
        <p><strong>Genre:</strong> <?= $product['genre'] ?></p>
        <p><strong>Description:</strong> <?= $product['commentaire'] ?></p>
        <p><a href="actions/ajoutProduit.php?id=<?= $id ?>">Rajouter au panier</a></p>
    <?php endforeach; ?>

    <?php if (!empty($commandeUser)) :?>
        <a href="AjoutCommentaire.php?id=<?= $_GET['id'] ?>">Ajouter un commentaire</a>
    <?php endif; ?>


    <table border="1">
        <tr>
            <th colspan="4">Commentaire</th>
            <th>Notation</th>
        </tr>
        <?php foreach ($commentaires as $commentaire) : ?>
            <tr>
                <td colspan="4"><?= $commentaire["commentaire"] ?></td>
                <td><?= $commentaire["notations"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="/product.php" class="btn btn-primary">Retour à la boutique</a>
</body>




</html>
