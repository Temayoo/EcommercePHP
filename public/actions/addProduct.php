<?php
require_once __DIR__ . '/../../src/init.php';

// Vérifier si le formulaire n'est pas vide
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $stock = $_POST['stock'];
    $prix = $_POST['prix'];
    $genre = $_POST['genre'];
    $nom = $_POST['nom'];
    $commentaire = $_POST['commentaire'];

    // Validation du prix
    if ($prix <= 0) {
        $_SESSION['error_message'] = 'Le prix doit être supérieur à zéro.';
        header('Location: /product.php'); // Redirige l'utilisateur
        die(); // Arrête l'exécution du script
    }

        // Validation de la quantité
    if ($stock < 0) {
        $_SESSION['error_message'] = 'La quantité ne doit pas être negatif';
        header('Location: /product.php'); // Redirige l'utilisateur
        die(); // Arrête l'exécution du script
    }
    // Requête SQL
    $sql = "INSERT INTO Produit (stock, prix, genre, nom, commentaire) VALUES (?, ?, ?, ?, ?)";

    // Préparer la requête
    $stmt = $pdo->prepare($sql);

    // Lier les paramètres
    $stmt->bindValue(1, $stock, PDO::PARAM_INT);
    $stmt->bindValue(2, $prix, PDO::PARAM_STR);
    $stmt->bindValue(3, $genre, PDO::PARAM_STR);
    $stmt->bindValue(4, $nom, PDO::PARAM_STR);
    $stmt->bindValue(5, $commentaire, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Création réussie';
        header('Location: /product.php'); // Redirige l'utilisateur
        die(); // Arrête l'exécution du script
    } else {
        $_SESSION['error_message'] = 'Erreur lors de la création';
        header('Location: /maCommande.php'); // Redirige l'utilisateur
        die(); // Arrête l'exécution du script
    }
} else {
    $_SESSION['error_message'] = 'Formulaire non fourni';
    header('Location: /maCommande.php'); // Redirige l'utilisateur
    die(); // Arrête l'exécution du script
}
?>
