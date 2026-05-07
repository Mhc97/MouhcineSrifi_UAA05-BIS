<?php
require_once __DIR__ . '/config/db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}
require_once 'header.php';

$formations   = $pdo->query("SELECT id, intitule FROM formations ORDER BY intitule")->fetchAll();
$formation_id = isset($_GET['id']) ? (int)$_GET['id'] : ($formations[0]['id'] ?? 0);

$stagiaires = [];
if ($formation_id > 0) {
    $stmt = $pdo->prepare("SELECT nom, prenom, email, date_naissance FROM stagiaires WHERE formation_id = ? ORDER BY nom ASC");
    $stmt->execute([$formation_id]);
    $stagiaires = $stmt->fetchAll();
}
?>

<h1 class="mb-4">Stagiaires par formation</h1>

<ul class="nav nav-tabs mb-4">
    <?php foreach ($formations as $f): ?>
        <li class="nav-item">
            <a class="nav-link <?= ($f['id'] == $formation_id) ? 'active' : '' ?>"
               href="formation.php?id=<?= (int)$f['id'] ?>">
                <?= htmlspecialchars($f['intitule']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php if (empty($stagiaires)): ?>
    <div class="alert alert-info">Aucun stagiaire dans cette formation.</div>
<?php else: ?>
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nom</th><th>Prénom</th><th>Email</th><th>Date de naissance</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stagiaires as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['nom']) ?></td>
            <td><?= htmlspecialchars($s['prenom']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= date('d/m/Y', strtotime($s['date_naissance'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class="text-muted"><?= count($stagiaires) ?> stagiaire(s)</p>
<?php endif; ?>

<?php require_once 'footer.php'; ?>