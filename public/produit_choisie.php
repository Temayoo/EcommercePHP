<?
require_once __DIR__ . '/../src/init.php';

if (!empty($_GET["id"])) {
    $stmt = $pdo->prepare('SELECT * FROM Produit WHERE id = ?');
    $stmt->execute([
        $_GET['id']
    ]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>BONJOURS</h1>
    <table>
    <tr>
        <th>Stock</th>
        <th>Prix</th>
        <th>Genre</th>
        <th>Nom</th>
        <th>Commantaire</th>
        <th>Notation</th>
    </tr>
    <?php foreach ($products as $product) : ?>
        <tr>
            <td><?= $product['stock'] ?></td>
            <td><?= $product['prix'] ?></td>
            <td><?= $product['genre'] ?></td>
            <td><?= $product['nom'] ?></td>
            <td><?= $product['commentaire'] ?></td>
            <td><?= $product['notations'] ?></td>
        </tr>
    <?php endforeach; ?>
    <a href="/product.php" class="btn btn-primary">Retour a la boutique</a>
    </table>
   
</body>
</html>