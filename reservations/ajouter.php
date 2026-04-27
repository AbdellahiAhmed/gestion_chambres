<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/auth/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

// Charger uniquement les chambres disponibles
$chambres_dispos = $conn->query("SELECT * FROM chambres WHERE statut = 'disponible' ORDER BY numero ASC");

// Pré-sélectionner une chambre si elle est passée via GET (bouton "Réserver" de la liste)
$chambre_preselect = intval($_GET['chambre_id'] ?? 0);

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client     = trim($_POST['client']     ?? '');
    $chambre_id = intval($_POST['chambre_id'] ?? 0);
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin   = $_POST['date_fin']   ?? '';

    if ($client === '' || $chambre_id === 0 || $date_debut === '' || $date_fin === '') {
        $erreur = 'Veuillez remplir tous les champs.';
    } elseif ($date_fin <= $date_debut) {
        $erreur = 'La date de fin doit être postérieure à la date de début.';
    } else {
        // Enregistrer la réservation
        $stmt = $conn->prepare("INSERT INTO reservations (chambre_id, client, date_debut, date_fin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $chambre_id, $client, $date_debut, $date_fin);
        $stmt->execute();

        // Marquer la chambre comme occupée
        $stmt2 = $conn->prepare("UPDATE chambres SET statut = 'occupee' WHERE id = ?");
        $stmt2->bind_param('i', $chambre_id);
        $stmt2->execute();

        header('Location: ' . BASE_URL . '/reservations/index.php');
        exit;
    }
}

$page_title = 'Nouvelle réservation';
$active     = 'reservations';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1><?= $page_title ?></h1>
    <a href="<?= BASE_URL ?>/reservations/index.php" class="btn btn-primary">← Retour</a>
</div>

<div class="form-box">
    <?php if ($erreur): ?>
        <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <?php if ($chambres_dispos->num_rows === 0): ?>
        <div class="alert alert-error">
            Aucune chambre disponible en ce moment.
        </div>
    <?php else: ?>
    <form method="POST">
        <div class="form-group">
            <label for="client">Nom du client</label>
            <input type="text" id="client" name="client"
                   placeholder="Nom complet"
                   value="<?= htmlspecialchars($_POST['client'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="chambre_id">Chambre</label>
            <select id="chambre_id" name="chambre_id">
                <option value="">-- Choisir une chambre --</option>
                <?php
                $chambres_dispos->data_seek(0);
                while ($ch = $chambres_dispos->fetch_assoc()):
                    $selected = (intval($_POST['chambre_id'] ?? $chambre_preselect) === $ch['id']) ? 'selected' : '';
                ?>
                <option value="<?= $ch['id'] ?>" <?= $selected ?>>
                    Chambre <?= htmlspecialchars($ch['numero']) ?> — <?= number_format($ch['prix'], 2) ?> DH/nuit
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input type="date" id="date_debut" name="date_debut"
                   value="<?= htmlspecialchars($_POST['date_debut'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input type="date" id="date_fin" name="date_fin"
                   value="<?= htmlspecialchars($_POST['date_fin'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-success">Enregistrer la réservation</button>
    </form>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
