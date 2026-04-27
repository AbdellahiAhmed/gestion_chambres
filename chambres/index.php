<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/auth/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$chambres = $conn->query("SELECT * FROM chambres ORDER BY numero ASC");

$page_title = 'Gestion des chambres';
$active     = 'chambres';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1><?= $page_title ?></h1>
    <a href="<?= BASE_URL ?>/chambres/ajouter.php" class="btn btn-primary">+ Ajouter une chambre</a>
</div>

<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Prix (DH / nuit)</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($chambres->num_rows === 0): ?>
            <tr>
                <td colspan="4" style="text-align:center;color:#aaa;padding:30px;">
                    Aucune chambre enregistrée.
                </td>
            </tr>
        <?php else: ?>
            <?php while ($ch = $chambres->fetch_assoc()): ?>
            <tr>
                <td><strong>Chambre <?= htmlspecialchars($ch['numero']) ?></strong></td>
                <td><?= number_format($ch['prix'], 2) ?> DH</td>
                <td>
                    <span class="badge badge-<?= $ch['statut'] ?>">
                        <?= $ch['statut'] === 'disponible' ? 'Disponible' : 'Occupée' ?>
                    </span>
                </td>
                <td>
                    <a href="<?= BASE_URL ?>/chambres/modifier.php?id=<?= $ch['id'] ?>"
                       class="btn btn-warning">Modifier</a>

                    <a href="<?= BASE_URL ?>/chambres/supprimer.php?id=<?= $ch['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Supprimer cette chambre ?')">Supprimer</a>

                    <?php if ($ch['statut'] === 'disponible'): ?>
                    <a href="<?= BASE_URL ?>/reservations/ajouter.php?chambre_id=<?= $ch['id'] ?>"
                       class="btn btn-success">Réserver</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
