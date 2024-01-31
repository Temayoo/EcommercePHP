<?php
require_once __DIR__ . '/../../src/init.php';
// $pdo est dispo !

if ($user["admin"]){
    if (empty($_POST['stock'])) {
        // error
        $_SESSION['error_message'] = 'Champs stock vide.';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }
    elseif ($_POST['stock'] <= 0) {
        $_SESSION['error_message'] = 'Quantité stock négative';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }

    if (empty($_POST['prix'])) {
        // error
        $_SESSION['error_message'] = 'Champs prix vide.';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }
    elseif ($_POST['prix'] <= 0) {
        $_SESSION['error_message'] = 'Prix négatif';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }

    if (empty($_POST['genre'])) {
        // error
        $_SESSION['error_message'] = 'Champs genre vide.';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }

    if (empty($_POST['nom'])) {
        // error
        $_SESSION['error_message'] = 'Champs nom vide.';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }

    if (empty($_POST['details'])) {
        // error
        $_SESSION['error_message'] = 'Champs detail vide.';
        header('Location: /../product.php'); // redirige utilisateur
        die(); // stop execution du script
    }

    $stmt = $pdo->prepare('UPDATE produit SET stock = ?, prix = ?, genre = ?, nom = ?, commentaire = ? where id = ?');
    $stmt->execute([
        $_POST["stock"],
        $_POST["prix"],
        $_POST["genre"],
        $_POST["nom"],
        $_POST["commentaire"],
        $_GET['id']
        ]);

    $_SESSION['error_message'] = "Modification Réalisée";
    header('Location: /../product.php');
}