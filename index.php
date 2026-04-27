<?php
session_start();

// Rediriger selon l'état de la session
if (isset($_SESSION['admin_id'])) {
    header('Location: /gestion_chambres/dashboard.php');
} else {
    header('Location: /gestion_chambres/auth/login.php');
}
exit;
