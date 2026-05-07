<?php
require_once __DIR__ .'/config/db.php';

$login    = 'admin';
$password = 'admin123';
$hash     = password_hash($password, PASSWORD_DEFAULT);

// Supprimer l'ancien et recréer
$pdo->prepare("DELETE FROM personnel WHERE login = ?")->execute([$login]);
$pdo->prepare("INSERT INTO personnel (login, password_hash) VALUES (?, ?)")->execute([$login, $hash]);

echo "<h2>✅ Admin créé avec succès !</h2>";
echo "<p><strong>Login :</strong> $login</p>";
echo "<p><strong>Mot de passe :</strong> $password</p>";
echo "<p><strong>Hash stocké :</strong> $hash</p>";
echo "<hr>";
echo "<p style='color:red'><strong>⚠️ Supprime ce fichier après utilisation !</strong></p>";
echo "<p><a href='connexion.php'>→ Aller à la page de connexion</a></p>";

// Vérification immédiate
if (password_verify($password, $hash)) {
    echo "<p style='color:green'>✅ Vérification : le hash correspond bien au mot de passe.</p>";
} else {
    echo "<p style='color:red'>❌ Erreur : le hash ne correspond pas !</p>";
}
?>
