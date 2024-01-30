

<?php
function ajouterUtilisateur($pdo, $username, $password): void
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertionDonnee = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    
    if ($insertionDonnee->execute([':username' => $username, ':password' => $hashedPassword])) {
        echo "Utilisateur inséré avec succès!";
    } else {
        var_dump($insertionDonnee->errorInfo());
    }
}

?>