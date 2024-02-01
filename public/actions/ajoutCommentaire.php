<?php
require_once __DIR__ . '/../../src/init.php';

$stmt = $pdo->prepare('INSERT INTO Commentaire (id_user, id_produit, commentaire, notations) VALUES (?, ?, ?, ?)');
$stmt->execute([
    $user['id'],
    $_GET['id'],
    $_POST['commentaire'],
    $_POST['notation']
]);
header('Location: /../product.php');
?>