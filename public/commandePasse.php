<?php
require_once __DIR__ . '/../src/init.php';

// Récupérer le statut sélectionné (filtrage)
$selectedStatus = isset($_GET['status']) ? $_GET['status'] : '';

// Récupérer le critère de tri sélectionné (nouvelle partie ajoutée)
$selectedTri = isset($_GET['tri']) ? $_GET['tri'] : 'date_creation';

// Récupérer tous les statuts uniques
$stmt = $pdo->query('SELECT DISTINCT status FROM Commande');
$statuts = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer toutes les commandes avec filtre par statut et tri par date (plus récente à la plus ancienne)
if (!empty($selectedStatus)) {
    $orderBy = ($selectedTri === 'date_mise_a_jour') ? 'Commande.date_update DESC' : 'Commande.date_commande DESC';
    $stmt = $pdo->prepare('SELECT Commande.*, User.pseudo, Produit.nom as produit_nom, ProduitCommande.quantite, Produit.prix
                        FROM Commande
                        JOIN User ON Commande.id_user = User.id
                        LEFT JOIN ProduitCommande ON Commande.id = ProduitCommande.id_commande
                        LEFT JOIN Produit ON ProduitCommande.id_produit = Produit.id
                        WHERE Commande.status = :status
                        ORDER BY ' . $orderBy);
    $stmt->execute(['status' => $selectedStatus]);
} else {
    // Récupérer toutes les commandes sans filtre par statut et tri par date (plus récente à la plus ancienne)
    $orderBy = ($selectedTri === 'date_mise_a_jour') ? 'Commande.date_update DESC' : 'Commande.date_commande DESC';
    $stmt = $pdo->query('SELECT Commande.*, User.pseudo, Produit.nom as produit_nom, ProduitCommande.quantite, Produit.prix
                        FROM Commande
                        JOIN User ON Commande.id_user = User.id
                        LEFT JOIN ProduitCommande ON Commande.id = ProduitCommande.id_commande
                        LEFT JOIN Produit ON ProduitCommande.id_produit = Produit.id
                        ORDER BY ' . $orderBy);
}

$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialiser une structure de données pour stocker les commandes regroupées par ID
$groupedCommandes = [];

foreach ($commandes as $commande) {
    $commandeId = $commande['id'];

    if (!isset($groupedCommandes[$commandeId])) {
        // Créer une nouvelle entrée pour l'ID de commande s'il n'existe pas encore
        $groupedCommandes[$commandeId] = [
            'details' => [],
            'total' => 0,
            'pseudo' => $commande['pseudo'],
            'date_commande' => $commande['date_commande'],
            'date_update' => $commande['date_update'],
            'status' => $commande['status'],
        ];
    }

    // Ajouter les détails de la commande
    $groupedCommandes[$commandeId]['details'][] = [
        'quantite' => $commande['quantite'],
        'produit_nom' => $commande['produit_nom'],
        'prix_unitaire' => $commande['prix'],
        'prix_total' => $commande['quantite'] * $commande['prix'],
    ];

    // Mettre à jour le total de la commande
    $groupedCommandes[$commandeId]['total'] += $commande['quantite'] * $commande['prix'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>
    <?php require_once __DIR__ . '/../src/partials/head_css.php'; ?>
    <style>
        .commande {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .commande p {
            margin: 0;
            padding: 5px 0;
        }

        .commande strong {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../src/partials/menu.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_error.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_success.php'; ?>

    <div class="container">
        <h1>Liste des Commandes</h1>

        <!-- Ajout du formulaire de filtrage par statut et tri -->
        <form method="get">
            <label for="status">Filtrer par statut :</label>
            <select id="status" name="status">
                <option value="" <?= ($selectedStatus === '') ? 'selected' : '' ?>>Tous les statuts</option>
                <?php foreach ($statuts as $statut) : ?>
                    <option value="<?= $statut ?>" <?= ($selectedStatus === $statut) ? 'selected' : '' ?>><?= $statut ?></option>
                <?php endforeach; ?>
            </select>

            <label for="tri">Trier par :</label>
            <select id="tri" name="tri">
                <option value="date_creation" <?= ($selectedTri === 'date_creation') ? 'selected' : '' ?>>Date de création</option>
                <option value="date_mise_a_jour" <?= ($selectedTri === 'date_mise_a_jour') ? 'selected' : '' ?>>Date de mise à jour</option>
            </select>

            <button type="submit">Filtrer</button>
        </form>
        <!-- Fin du formulaire de filtrage -->

        <?php foreach ($groupedCommandes as $commandeId => $groupedCommande) : ?>
            <div class="commande">
                <p><strong>ID Commande:</strong> <?= $commandeId ?></p>
                <p><strong>Utilisateur:</strong> <?= $groupedCommande['pseudo'] ?></p>
                <p><strong>Date de Commande:</strong> <?= $groupedCommande['date_commande'] ?></p>
                <p><strong>Date de Mise à Jour:</strong> <?= $groupedCommande['date_update'] ?></p>
                <p><strong>Status:</strong> <?= $groupedCommande['status'] ?></p>

                <?php foreach ($groupedCommande['details'] as $detail) : ?>
                    <p><strong>Détails:</strong> <?= $detail['quantite'] ?> <?= $detail['produit_nom'] ?> à <?= $detail['prix_unitaire'] ?>€ chacun</p>
                    <p><strong>Prix Total:</strong> <?= $detail['prix_total'] ?>€</p>
                <?php endforeach; ?>

                <p><strong>Total de la Commande:</strong> <?= $groupedCommande['total'] ?>€</p>
                
                <?php if ($user["admin"]) : ?>
                    <form method="post" action="/actions/update_status.php">
                        <input type="hidden" name="commandeId" value="<?= $commandeId ?>">
                        <label for="nouveauStatut">Nouveau Statut:</label>
                        <select id="nouveauStatut" name="nouveauStatut">
                        <option value="En Cours">En Cours</option>
                        <option value="Envoyer">Envoyer</option>
                        <option value="Nouvelle">Nouvelle</option>
                        <option value="Retour Client">Retour Client</option>
                        <option value="Finie">Finie</option>
                        </select>
                        <button type="submit">Modifier Statut</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
