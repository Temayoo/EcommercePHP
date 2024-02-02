<?php
require_once __DIR__ . '/../src/init.php';

$stmt = $pdo->prepare('SELECT date_commande, date_update, status, detail FROM Commande WHERE id_user = ?');
$stmt->execute([$user['id']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if ($rows) : ?>
    <?php foreach ($rows as $listecommande) : ?>
        <?php $date_creation = $listecommande['date_commande']; ?>
        <?php $date_maj = $listecommande['date_update']; ?>
        <?php $status = $listecommande['status']; ?>
        <?php $detail = $listecommande['detail']; ?>
        <p><strong><?= "Date Création : {$date_creation}" ?></strong></p>
        <p><strong><?= "Date Mise à jour : {$date_maj}" ?></strong></p>
        <p><strong><?= "Status : {$status}" ?></strong></p>
        <p><strong><?= "Détail : {$detail}" ?></strong></p>
        <p>_____________________________________________________________________________</p>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucune commande trouvée pour cet utilisateur.</p>
<?php endif; ?>
<a href="/product.php" class="btn btn-primary">retour sur les produits</a>
