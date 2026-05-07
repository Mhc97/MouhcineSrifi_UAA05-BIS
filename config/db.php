<?php
$host     = 'mysql-mouhcine.alwaysdata.net';
$dbname   = 'mouhcine_cfitech';
$user     = 'mouhcine';
$password = 'Mouhcine-1997';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion BDD : " . $e->getMessage());
}
?>