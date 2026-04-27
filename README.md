# Gestion Chambres

Application de gestion de location de chambres — projet scolaire PHP/MySQL.

## Installation

1. Démarrer Apache et MySQL via XAMPP.
2. Ouvrir **phpMyAdmin** → onglet **SQL** → coller et exécuter le contenu de `database.sql`.
3. Accéder à : **http://localhost/gestion_chambres**

## Connexion admin

- Utilisateur : `admin`
- Mot de passe : `admin123`

## Structure

```
gestion_chambres/
├── config/database.php       ← Connexion MySQL
├── assets/style.css          ← Styles CSS
├── includes/header.php       ← Layout : sidebar + nav
├── includes/footer.php       ← Fermeture HTML
├── auth/login.php            ← Formulaire de connexion
├── auth/logout.php           ← Déconnexion
├── chambres/index.php        ← Liste des chambres
├── chambres/ajouter.php      ← Ajouter une chambre
├── chambres/modifier.php     ← Modifier une chambre
├── chambres/supprimer.php    ← Supprimer une chambre
├── reservations/index.php    ← Liste des réservations
├── reservations/ajouter.php  ← Nouvelle réservation
├── dashboard.php             ← Tableau de bord
├── index.php                 ← Point d'entrée
└── database.sql              ← Script SQL