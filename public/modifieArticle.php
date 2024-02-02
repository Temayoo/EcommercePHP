<?php
require_once __DIR__ . '/../src/init.php';

// Vérifier si l'utilisateur est connecté
if (!isset($user['id'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /login.php");
    exit();
}

// Vérifier si l'utilisateur est un administrateur
if (!$user['admin']) {
    // Si l'utilisateur n'est pas un administrateur, redirigez-le vers une autre page (par exemple, la page d'accueil)
    header("Location: /login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 2px solid #3498db;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 15px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Style pour les petites tailles d'écran */
        @media only screen and (max-width: 600px) {
            form {
                width: 80%;
            }
        }

    </style>
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
    <form action="/actions/modifieArticle.php?id=<?php echo($product["id"])?>" method="post">
        <div>
            <label for="stock">Stock :</label>
            <input type="number" name="stock" id="stock" value="<?php echo($product["stock"])?>">
        </div>
        <div>
            <label for="prix">Prix :</label>
            <input type="number" name="prix" id="prix" value="<?php echo($product["prix"])?>">
        </div>
        <div>
            <label for="genre">Genre :</label>
            <input type="text" name="genre" id="genre" value="<?php echo($product["genre"])?>">
        </div>
        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo($product["nom"])?>">
        </div>
        <div>
            <label for="details">Description :</label>
            <input type="text" name="details" id="details"  value="<?php echo( $product["commentaire"])?>">
        </div>
        <div>
            <button type="submit" >Appliquer modification</button>
            <a href="/product.php" class="btn btn-primary">Retour a la boutique</a>
        </div>
    </form>
    <?php require_once __DIR__ . '/actions/modifieArticle.php' ?>
<?php endforeach; ?>
</body>
</html>