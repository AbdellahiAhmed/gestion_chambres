<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/auth/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $prix   = floatval($_POST['prix']   ?? 0);
    $statut = $_POST['statut'] ?? 'disponible';

    if ($numero === '' || $prix <= 0) {
        $erreur = 'Veuillez remplir tous les champs correctement.';
    } else {
        $stmt = $conn->prepare("INSERT INTO chambres (numero, prix, statut) VALUES (?, ?, ?)");
        $stmt->bind_param('sds', $numero, $prix, $statut);
        $stmt->execute();
        header('Location: ' . BASE_URL . '/chambres/index.php');
        exit;
    }
}

$page_title = 'Ajouter une chambre';
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
                   placeholder="Ex : 101"
                   value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="prix">Prix par nuit (MRU)</label>
            <input type="number" id="prix" name="prix"
                   step="0.01" min="1" placeholder="Ex : 500"
                   value="<?= htmlspecialchars($_POST['prix'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="statut">Statut</label>
            <select id="statut" name="statut">
                <option value="disponible"
                    <?= (($_POST['statut'] ?? '') === 'disponible') ? 'selected' : '' ?>>
                    Disponible
                </option>
                <option value="occupee"
                    <?= (($_POST['statut'] ?? '') === 'occupee') ? 'selected' : '' ?>>
                    Occupée
                </option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
