<?php
require_once __DIR__ . '/config/db.php';
session_start();
require_once 'header.php';

$sql = "SELECT f.*, COUNT(s.id) AS nb_stagiaires
        FROM formations f
        LEFT JOIN stagiaires s ON f.id = s.formation_id
        GROUP BY f.id
        ORDER BY f.date_debut ASC";
$formations = $pdo->query($sql)->fetchAll();
?>

<h1 class="mb-4">Bienvenue au centre de formation CFITech</h1>

<img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&h=300&fit=crop"
     class="img-fluid rounded mb-4" alt="Centre de formation">

<h2 class="mb-3">Nos formations</h2>

<?php if (empty($formations)): ?>
    <div class="alert alert-info">Aucune formation enregistrée.</div>
<?php else: ?>
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Intitulé</th>
            <th>Date de début</th>
            <th>Durée (mois)</th>
            <th>Stagiaires inscrits</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($formations as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['intitule']) ?></td>
            <td><?= date('d/m/Y', strtotime($row['date_debut'])) ?></td>
            <td><?= (int)$row['nb_mois'] ?></td>
            <td><span class="badge bg-primary"><?= (int)$row['nb_stagiaires'] ?></span></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php require_once 'footer.php'; ?>