<?php
session_start();

// Si déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/dashboard.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // En production, utiliser password_hash() pour stocker et password_verify() pour vérifier
    $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE username = ? AND password = ?");
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id);
        $stmt->fetch();
        $_SESSION['admin_id'] = $id;
        header('Location: /gestion_chambres/dashboard.php');
        exit;
    } else {
        $erreur = 'Identifiants incorrects. Veuillez réessayer.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Gestion Chambres</title>
    <link rel="stylesheet" href="/gestion_chambres/assets/style.css">
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <h1>GestionChambres</h1>
        <p class="subtitle">Connectez-vous à votre espace administrateur</p>

        <?php if ($erreur): ?>
            <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username"
                       placeholder="admin" autofocus required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;padding:11px 0;font-size:15px;">
                Se connecter
            </button>
        </form>
    </div>
</div>

</body>
</html>
