<?php
require_once __DIR__ . '/../src/init.php';

// Vérifier si l'utilisateur est connecté
if (!isset($user['id'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonjour</title>
    <?php require_once __DIR__ . '/../src/partials/head_css.php'; ?>
</head>
<body>
    <?php require_once __DIR__ . '/../src/partials/menu.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_error.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_success.php'; ?>


<h2>Entrez vos informations de localisation :</h2>

<form action="/actions/maCommande.php" method="post">
    
    <label for="adresse">Adresse :</label>
    <input type="text" name="adresse" required><br>

    <label for="code_postal">Code Postal :</label>
    <input type="text" name="code_postal" required><br>

    <label for="ville">Ville :</label>
    <input type="text" name="ville" required><br>

    <label for="pays">Pays :</label>
    <input type="text" name="pays" required><br>

    <input type="submit" value="Enregistrer">
</form>


</body>
</html>





