<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/auth/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$id = intval($_GET['id'] ?? 0);

// Récupérer la chambre à modifier
$stmt = $conn->prepare("SELECT * FROM chambres WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$chambre = $stmt->get_result()->fetch_assoc();

if (!$chambre) {
    header('Location: ' . BASE_URL . '/chambres/index.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $prix   = floatval($_POST['prix']   ?? 0);
    $statut = $_POST['statut'] ?? 'disponible';

    if ($numero === '' || $prix <= 0) {
        $erreur = 'Veuillez remplir tous les champs correctement.';
    } else {
        $stmt = $conn->prepare("UPDATE chambres SET numero = ?, prix = ?, statut = ? WHERE id = ?");
        $stmt->bind_param('sdsi', $numero, $prix, $statut, $id);
        $stmt->execute();
        header('Location: ' . BASE_URL . '/chambres/index.php');
        exit;
    }
}

// Utiliser les valeurs POST en cas d'erreur, sinon les valeurs de la base
$val_numero = $_POST['numero'] ?? $chambre['numero'];
$val_prix   = $_POST['prix']   ?? $chambre['prix'];
$val_statut = $_POST['statut'] ?? $chambre['statut'];

$page_title = 'Modifier la chambre ' . htmlspecialchars($chambre['numero']);
$active     = 'chambres';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1><?= $page_title ?></h1>
    <a href="<?= BASE_URL ?>/chambres/index.php" class="btn btn-primary">← Retour</a>
</div>

<div class="form-box">
    <?php if ($erreur): ?>
        <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="numero">Numéro de chambre</label>
            <input type="text" id="numero" name="numero"
                   value="<?= htmlspecialchars($val_numero) ?>">
        </div>
        <div class="form-group">
            <label for="prix">Prix par nuit (DH)</label>
            <input type="number" id="prix" name="prix"
                   step="0.01" min="1"
                   value="<?= htmlspecialchars($val_prix) ?>">
        </div>
        <div class="form-group">
            <label for="statut">Statut</label>
            <select id="statut" name="statut">
                <option value="disponible" <?= $val_statut === 'disponible' ? 'selected' : '' ?>>
                    Disponible
                </option>
                <option value="occupee" <?= $val_statut === 'occupee' ? 'selected' : '' ?>>
                    Occupée
                </option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Mettre à jour</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
