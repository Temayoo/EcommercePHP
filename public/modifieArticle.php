<?php require_once __DIR__ . '/actions/modifieArticle.php' ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php 
if (!empty($_GET["id"])) {
    $stmt = $pdo->prepare('SELECT * FROM Produit WHERE id = ?');
    $stmt->execute([
        $_GET['id']
        ]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php foreach ($products as $product): ?>
    <form action="/actions/modifieArticle.php" method="post">
        <div>
            <label for="stock">Stock :</label>
            <input type="number" name="stock" id="stock" value="<?php $product["stock"]?>">
        </div>
        <div>
            <label for="prix">Prix :</label>
            <input type="number" name="prix" id="prix" value="<?php $product["prix"]?>">
        </div>
        <div>
            <label for="genre">Genre :</label>
            <input type="text" name="genre" id="genre" value="<?php $product["genre"]?>">
        </div>
        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php $product["nom"]?>">
        </div>
        <div>
            <label for="details">Description :</label>
            <input type="text" name="details" id="details"  value="<?php $product["commentaire"]?>">
        </div>
        <div>
            <button type="submit">Appliquer modification</button>
        </div>
    </form>
<?php endforeach; ?>
</body>
</html>