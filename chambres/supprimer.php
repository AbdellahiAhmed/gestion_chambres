<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/auth/login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM chambres WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header('Location: ' . BASE_URL . '/chambres/index.php');
exit;
