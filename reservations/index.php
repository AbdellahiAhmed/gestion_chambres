<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/auth/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

// Jointure pour afficher le numéro de chambre avec chaque réservation
$reservations = $conn->query("
    SELECT r.id, r.client, r.date_debut, r.date_fin, c.numero AS chambre_numero
    FROM reservations r
    JOIN chambres c ON r.chambre_id = c.id
    ORDER BY r.date_debut DESC
");

$page_title = 'Liste des réservations';
$active     = 'reservations';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1><?= $page_title ?></h1>
    <a href="<?= BASE_URL ?>/reservations/ajouter.php" class="btn btn-primary">+ Nouvelle réservation</a>
</div>

<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Chambre</th>
                <th>Date de début</th>
                <th>Date de fin</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($reservations->num_rows === 0): ?>
            <tr>
                <td colspan="5" style="text-align:center;color:#aaa;padding:30px;">
                    Aucune réservation enregistrée.
                </td>
            </tr>
        <?php else: ?>
            <?php while ($r = $reservations->fetch_assoc()): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['client']) ?></td>
                <td>Chambre <?= htmlspecialchars($r['chambre_numero']) ?></td>
                <td><?= date('d/m/Y', strtotime($r['date_debut'])) ?></td>
                <td><?= date('d/m/Y', strtotime($r['date_fin'])) ?></td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
