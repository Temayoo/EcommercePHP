
<?php
require_once __DIR__ . '/../src/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitCommande'])) {
    // Récupérez l'id de l'utilisateur
    $userId = $user['id'];

    // varaible stock
    $stockSuffisant = true;

    foreach ($panier as $row) {
        // Récupérez l'id du produit et la quantité du formulaire
        $produitId = $row['id'];
        $quantite = $_POST['quantite_' . $produitId];

        // Vérifiez si le stock est suffisant
        if ($row['stock'] < $quantite) {
            $stockSuffisant = false;
            break;
        }
    }

    if ($stockSuffisant) {
        // Si le stock est suffisant, mettez à jour le statut de la commande
        $stmtUpdateCommande = $pdo->prepare('UPDATE Commande SET status = "Fini" WHERE id_user = ? AND status = "EnCours"');
        $stmtUpdateCommande->execute([$userId]);

        // Réduisez le stock des produits
        foreach ($panier as $row) {
            $produitId = $row['id'];
            $quantite = $_POST['quantite_' . $produitId];

            $stmtUpdateStock = $pdo->prepare('UPDATE Produit SET stock = stock - ? WHERE id = ?');
            $stmtUpdateStock->execute([$quantite, $produitId]);
        }

        // Redirigez l'utilisateur vers maCommande.php
        header('Location: /maCommande.php');
        exit();
    } else {
        // Si le stock n'est pas suffisant, affichez un message d'erreur ou effectuez une action appropriée
        $_SESSION['error_message'] = "Stock Insuffisant";
        header('Location: /product.php');
        die();
    }
} else {
    // Redirigez l'utilisateur s'il essaie d'accéder directement à processCommande.php sans soumettre le formulaire
    header('Location: /panier.php');
    exit();
}
?>
