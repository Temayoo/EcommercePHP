<?php
require_once __DIR__ . '/../src/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperMart - Votre destination shopping</title>
    <?php require_once __DIR__ . '/../src/partials/head_css.php'; ?>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
        }

        .jumbotron {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../src/partials/menu.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_error.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_success.php'; ?>

    <div class="container">
        <div class="jumbotron">
            <h1>Bienvenue sur KATM</h1>
            <p>Découvrez une expérience de shopping exceptionnelle avec une variété de produits de qualité.</p>
            <?php if(isset($_SESSION['user_id'])) : ?>
                <a href="/product.php" class="btn btn-primary">Découvrir la boutique</a>
            <?php else : ?>
                <p>Connectez-vous pour profiter de l'expérience complète de magasinage.</p>
                <a href="/login.php" class="btn btn-primary">Se connecter</a>
            <?php endif; ?>
        </div>

        <h2>Notre Produit Vedette</h2>

        <div class="card">
            <img src="/assets/avion.jpg" class="card-img-top" alt="Produit 1">
            <div class="card-body">
                <h5 class="card-title">Boeing A330</h5>
                <p class="card-text">Un avion de qualité qualitative qui fait fiuuuu ! Prix : 149.99 €</p>
            </div>
        </div>


</body>
</html>

