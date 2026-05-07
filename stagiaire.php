<?php
require_once __DIR__ . '/config/db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}
require_once 'header.php';

$sql = "SELECT s.nom, s.prenom, s.email, f.intitule
        FROM stagiaires s
        JOIN formations f ON s.formation_id = f.id
        ORDER BY s.nom ASC";
$stagiaires = $pdo->query($sql)->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Liste des stagiaires</h1>
    <a href="ajout.php" class="btn btn-success">+ Ajouter un stagiaire</a>
</div>

<?php if (empty($stagiaires)): ?>
    <div class="alert alert-info">Aucun stagiaire enregistré.</div>
<?php else: ?>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nom</th><th>Prénom</th><th>Email</th><th>Formation</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stagiaires as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['prenom']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><span class="badge bg-secondary"><?= htmlspecialchars($row['intitule']) ?></span></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class="text-muted"><?= count($stagiaires) ?> stagiaire(s) au total.</p>
<?php endif; ?>

<?php require_once 'footer.php'; ?>