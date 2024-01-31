<?php
require_once __DIR__ . '/../src/init.php';

// Traitement de la recherche
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Requête pour récupérer les produits en fonction de la recherche
if (!empty($searchTerm)) {
    $stmt = $pdo->prepare('SELECT * FROM Produit WHERE nom LIKE ? OR description LIKE ?');
    $stmt->execute(["%$searchTerm%", "%$searchTerm%"]);
} else {
    $stmt = $pdo->query('SELECT * FROM Produit');
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Générer le contenu HTML de la table
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Stock</th>';
echo '<th>Prix</th>';
echo '<th>Genre</th>';
echo '<th>Nom</th>';
echo '<th>Commentaire</th>';
echo '<th>Notations</th>';
echo '</tr>';

foreach ($products as $product) {
    echo '<tr>';
    echo '<td>' . $product['id'] . '</td>';
    echo '<td>' . $product['stock'] . '</td>';
    echo '<td>' . $product['prix'] . '</td>';
    echo '<td>' . $product['genre'] . '</td>';
    echo '<td>' . $product['nom'] . '</td>';
    echo '<td>' . $product['commentaire'] . '</td>';
    echo '<td>' . $product['notations'] . '</td>';
    echo '</tr>';
}
?>
