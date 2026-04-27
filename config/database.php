<?php
// Paramètres de connexion MySQL
$host     = 'localhost';
$dbname   = 'gestion_chambres';
$user     = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

$conn->set_charset('utf8');

// URL de base du projet (à adapter si nécessaire)
define('BASE_URL', '/gestion_chambres');
