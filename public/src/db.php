<?php
function connexionBdd() 
{
    $user = 'root';
    $pass = 'root';
    try {
        $dbh = new PDO('mysql:host=mariadb;dbname=dbadmin', $user, $pass);
        return $dbh;
    } catch (PDOException $e) {
        echo $e;

    }
}
