<?php
require_once __DIR__ . '/config/db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

$message = '';
$erreur  = '';
$formations = $pdo->query("SELECT id, intitule FROM formations ORDER BY intitule")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom            = trim($_POST['nom'] ?? '');
    $prenom         = trim($_POST['prenom'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $date_naissance = $_POST['date_naissance'] ?? '';
    $formation_id   = (int)($_POST['formation_id'] ?? 0);

    if (empty($nom) || empty($prenom) || empty($email) || empty($date_naissance) || $formation_id === 0) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO stagiaires (nom, prenom, email, date_naissance, formation_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $date_naissance, $formation_id]);
            $message = "Stagiaire $prenom $nom ajouté avec succès !";
            $_POST = [];
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $erreur = "Cet email est déjà utilisé.";
            } else {
                $erreur = "Erreur : " . $e->getMessage();
            }
        }
    }
}
require_once 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="mb-4">Ajouter un stagiaire</h1>
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if ($erreur): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>
        <form method="post" action="ajout.php">
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" class="form-control" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date de naissance</label>
                <input type="date" class="form-control" name="date_naissance" value="<?= htmlspecialchars($_POST['date_naissance'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Formation</label>
                <select class="form-select" name="formation_id" required>
                    <option value="">-- Choisir une formation --</option>
                    <?php foreach ($formations as $f): ?>
                        <option value="<?= (int)$f['id'] ?>" <?= (isset($_POST['formation_id']) && (int)$_POST['formation_id'] === (int)$f['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['intitule']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="stagiaires.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>