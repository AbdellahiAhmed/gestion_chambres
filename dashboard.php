<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/auth/login.php');
    exit;
}

require_once __DIR__ . '/config/database.php';

// Récupérer les statistiques
$total_chambres    = $conn->query("SELECT COUNT(*) FROM chambres")->fetch_row()[0];
$chambres_dispos   = $conn->query("SELECT COUNT(*) FROM chambres WHERE statut = 'disponible'")->fetch_row()[0];
$chambres_occupees = $conn->query("SELECT COUNT(*) FROM chambres WHERE statut = 'occupee'")->fetch_row()[0];
$total_reservas    = $conn->query("SELECT COUNT(*) FROM reservations")->fetch_row()[0];

$page_title = 'Tableau de bord';
$active     = 'dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <h1><?= $page_title ?></h1>
</div>

<!-- Cartes statistiques -->
<div class="cards-grid">
    <div class="card">
        <div class="card-number"><?= $total_chambres ?></div>
        <div class="card-label">Total des chambres</div>
    </div>
    <div class="card green">
        <div class="card-number"><?= $chambres_dispos ?></div>
        <div class="card-label">Chambres disponibles</div>
    </div>
    <div class="card red">
        <div class="card-number"><?= $chambres_occupees ?></div>
        <div class="card-label">Chambres occupées</div>
    </div>
    <div class="card orange">
        <div class="card-number"><?= $total_reservas ?></div>
        <div class="card-label">Réservations</div>
    </div>
</div>

<!-- Raccourcis -->
<div class="quick-links">
    <a href="<?= BASE_URL ?>/chambres/index.php"      class="quick-link">Gérer les chambres</a>
    <a href="<?= BASE_URL ?>/reservations/index.php"  class="quick-link">Voir les réservations</a>
    <a href="<?= BASE_URL ?>/chambres/ajouter.php"    class="quick-link">+ Ajouter une chambre</a>
    <a href="<?= BASE_URL ?>/reservations/ajouter.php" class="quick-link">+ Nouvelle réservation</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
