<?php 
require_once __DIR__ . '/../src/init.php';

$stmt = $pdo->prepare('SELECT Produit.id, Produit.nom, Produit.prix, Produit.genre, Produit.image_url from produitCommande join Commande on produitCommande.id_commande = Commande.id join Produit on produitCommande.id_produit = Produit.id join User on commande.id_user = User.id where User.id = ?');
    $stmt->execute([
        $user['id']
    ]);
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php require_once __DIR__ . '/../src/partials/menu.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_error.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_success.php'; ?>

    <?php foreach ($panier as $row): ?>
        <div>
        <p><a href="<?php $row['image_url']?>"></a></p>
        <p><?= $row['nom']?></p>
        <p><?= $row['genre']?></p>
        <p><?= $row['prix']?></p>
        <p><a href="actions/retirerProduitPanier.php?id=<?= $row['id'] ?>" class="btn btn-primary">Enlever l'article du panier</a></p>
        </div>
    <?php endforeach;?>
    <div><a href="/maCommande.php" class="btn btn-primary">Passer la commande </a></div>

    
    <div><a href="/product.php" class="btn btn-primary">Retour a la boutique</a></div>
</body>
</html>
