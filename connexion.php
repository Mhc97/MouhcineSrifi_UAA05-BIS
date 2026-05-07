<?php
require_once __DIR__ . '/config/db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM personnel WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = $user['login'];
        header('Location: stagiaires.php');
        exit();
    } else {
        $error = "Identifiant ou mot de passe incorrect.";
    }
}
require_once 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <h1 class="mb-4">Connexion</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="connexion.php">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" name="login" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>