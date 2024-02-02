<?php
require_once __DIR__ . '/../../src/init.php';

if ($user["admin"]) {
    $nouveauStatut = isset($_POST['nouveauStatut']) ? $_POST['nouveauStatut'] : '';
    $commandeId = isset($_POST['commandeId']) ? $_POST['commandeId'] : '';

    if (!empty($nouveauStatut) && !empty($commandeId)) {
        // Mettre à jour le statut et la date de mise à jour
        $stmt = $pdo->prepare('UPDATE Commande SET status = :nouveauStatut, date_update = NOW() WHERE id = :commandeId');
        $stmt->execute(['nouveauStatut' => $nouveauStatut, 'commandeId' => $commandeId]);

        // Redirigez l'administrateur vers la page des commandes après la mise à jour
        header('Location: /commandePasse.php');
        exit();
    }
}