<?php
require_once __DIR__ . '/../../src/init.php';
// $pdo est dispo !

if (empty($_POST['email']) || empty($_POST['password'])) {
    // error
    $_SESSION['error_message'] = 'Champs email ou mot de passe vide.';
    header('Location: /login.php'); // redirige utilisateur
    die(); // stop execution du script
}

if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
    $_SESSION['error_message'] = "L'email est invalide";
    header('Location: /login.php'); // redirige utilisateur
    die(); // stop execution du script
}

$email = $_POST['email'];
$password = hash('sha256', $_POST['password']);

// Vérifier les informations de connexion
$st = $pdo->prepare('SELECT * FROM User WHERE email = ? AND mdp = ?');
$st->execute([$email, $password]);
$user = $st->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Les informations de connexion sont incorrectes
    $_SESSION['error_message'] = 'Email ou mot de passe incorrect.';
    header('Location: /login.php');
    die();
}

// Les informations de connexion sont correctes, créer une session et rediriger
$_SESSION['user_id'] = $user['id'];
header('Location: /dashboard.php'); // Rediriger vers la page du tableau de bord ou toute autre page après la connexion
