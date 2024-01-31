<?php
require_once __DIR__ . '/../../src/init.php';
// $pdo est dispo !

if (empty($_POST['email'])) {
    // error
    $_SESSION['error_message'] = 'Champs email vide.';
    header('Location: /register.php'); // redirige utilisateur
    die(); // stop execution du script
}

if (empty($_POST['password'])) {
    // error
    $_SESSION['error_message'] = 'Champs password vide.';
    header('Location: /register.php'); // redirige utilisateur
    die(); // stop execution du script
}

if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
    $_SESSION['error_message'] = "L'email est invalide";
    header('Location: /register.php'); // redirige utilisateur
    die(); // stop execution du script
}

if (strlen($_POST['password']) < 6) {
    $_SESSION['error_message'] = "Le mot de passe est trop petit (<6)";
    header('Location: /register.php'); // redirige utilisateur
    die(); // stop execution du script
}

$password = hash('sha256', $_POST['password']);

// verifier que l'email n'est pas deja en DB
$st1 = $pdo->prepare('SELECT * FROM User WHERE email = ? OR pseudo = ?');
$st1->execute([$_POST['email'], $_POST['username']]);
$alreadyExists = $st1->fetch(PDO::FETCH_ASSOC);
// $alreadyExists = [ 'pseudo' => 'edouard', .... ];
if ($alreadyExists != false) {
    $_SESSION['error_message'] = 'Déjà inscrit.';
    header('Location: /register.php'); // redirige utilisateur
    die(); // stop execution du script
}

if (isset($_POST['role'])) {
    $role = $_POST['role']; 
} else {
    $role = 'user'; 
}

if ($role === 'admin') {
    $admin = 1; 
} else {
    $admin = 0; 
}

$sql = 'INSERT INTO User(email, mdp, pseudo, admin) VALUES (?, ?, ?, ?)';
$st2 = $pdo->prepare($sql);
$st2->execute([$_POST['email'], $password, $_POST['username'], $admin]);


// recup id utilisateur
$_SESSION['user_id'] = $pdo->lastInsertId(); // connecté pour plus tard

header('Location: /register.php?success=1'); // $_GET['success']
