<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — Gestion Chambres</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="logo">Gestion<span>Chambres</span></div>

    <nav>
        <a href="<?= BASE_URL ?>/dashboard.php"
           <?= (($active ?? '') === 'dashboard') ? 'class="active"' : '' ?>>
            Tableau de bord
        </a>
        <a href="<?= BASE_URL ?>/chambres/index.php"
           <?= (($active ?? '') === 'chambres') ? 'class="active"' : '' ?>>
            Chambres
        </a>
        <a href="<?= BASE_URL ?>/reservations/index.php"
           <?= (($active ?? '') === 'reservations') ? 'class="active"' : '' ?>>
            Réservations
        </a>
    </nav>

    <div class="logout">
        <a href="<?= BASE_URL ?>/auth/logout.php">Déconnexion</a>
    </div>
</aside>

<main class="main">
