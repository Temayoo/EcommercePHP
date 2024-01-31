<?php
require_once __DIR__ . '/../../src/init.php';

// fonction pour Code POstal
function isNumeric($str) {
    return preg_match('/^[0-9]+$/', $str);
}

// Verifie formiulaire rempli
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire 
    $adresse = isset($_POST['adresse']) ? htmlspecialchars(trim($_POST['adresse'])) : '';
    $code_postal = isset($_POST['code_postal']) ? $_POST['code_postal'] : '';
    $ville = isset($_POST['ville']) ? htmlspecialchars(trim($_POST['ville'])) : '';
    $pays = isset($_POST['pays']) ? htmlspecialchars(trim($_POST['pays'])) : '';

    // Vérifie Longueur code Postal < 10
    if (is_numeric($code_postal) && strlen($code_postal) <= 10) {
        // Vérifie si l'utilisateur est connecté
        if ($user) {
            // Requete insertion 
            $insertLocalisation = $pdo->prepare('INSERT INTO Localisation (id_user, adresse, code_postal, ville, pays) VALUES (?, ?, ?, ?, ?)');

            // Exécute la requête
            $insertLocalisation->execute([$user['id'], $adresse, $code_postal, $ville, $pays]);

            // Vérifie si l'insertion a réussi
            if ($insertLocalisation->rowCount() > 0) {
                $_SESSION['success_message'] = 'Localisation enregistrée avec succès!';
                header('Location: /product.php'); // redirige utilisateur
                die(); // stop execution du script
                
            } else {
                $_SESSION['error_message'] = 'Erreur lors de l\'enregistrement de la localisation.';
                header('Location: /maCommande.php'); // redirige utilisateur
                die(); // stop execution du script
            }
        } else {
            $_SESSION['error_message'] = 'Vous devez être connecté pour enregistrer une localisation.';
            header('Location: /maCommande.php'); // redirige utilisateur
            die(); // stop execution du script
        }
    } else {
        $_SESSION['error_message'] = 'Le code postal doit être un nombre et avoir une longueur maximale de 10 caractères.';
        header('Location: /maCommande.php'); // redirige utilisateur
        die(); // stop execution du script
    }
} else {
    $_SESSION['error_message'] = 'Le formulaire n\'a pas été soumis correctement.';
    header('Location: /maCommande.php'); // redirige utilisateur
    die(); // stop execution du script
}
?>
