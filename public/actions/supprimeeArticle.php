<?php
require_once __DIR__ . '/../../src/init.php';

if ($user["admin"]){
    if (!empty($_GET["id"])) {
        $stmt = $pdo->prepare('DELETE FROM Produit WHERE id = ?');
        $stmt->execute([
            $_GET['id']
        ]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
}


header('Location: /product.php');
?>