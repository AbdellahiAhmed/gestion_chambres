-- ============================================================
-- Projet : Gestion de location de chambres
-- Importer ce fichier via phpMyAdmin
-- ============================================================

CREATE DATABASE IF NOT EXISTS gestion_chambres
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE gestion_chambres;

-- ----------------------
-- Table : utilisateurs
-- ----------------------
CREATE TABLE IF NOT EXISTS utilisateurs (
    id       INT          AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- ----------------------
-- Table : chambres
-- ----------------------
CREATE TABLE IF NOT EXISTS chambres (
    id     INT           AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10)   NOT NULL,
    prix   DECIMAL(10,2) NOT NULL,
    statut ENUM('disponible', 'occupee') NOT NULL DEFAULT 'disponible'
);

-- ----------------------
-- Table : reservations
-- ----------------------
CREATE TABLE IF NOT EXISTS reservations (
    id         INT          AUTO_INCREMENT PRIMARY KEY,
    chambre_id INT          NOT NULL,
    client     VARCHAR(100) NOT NULL,
    date_debut DATE         NOT NULL,
    date_fin   DATE         NOT NULL,
    FOREIGN KEY (chambre_id) REFERENCES chambres(id) ON DELETE CASCADE
);

-- ----------------------
-- Données initiales
-- ----------------------

-- Compte admin (mot de passe en clair — projet scolaire uniquement)
-- En production, utiliser password_hash() et password_verify()
INSERT INTO utilisateurs (username, password) VALUES ('admin', 'admin123');

-- Chambres de démonstration
INSERT INTO chambres (numero, prix, statut) VALUES
    ('101', 450.00, 'disponible'),
    ('102', 600.00, 'disponible'),
    ('103', 750.00, 'occupee'),
    ('201', 500.00, 'disponible'),
    ('202', 550.00, 'disponible');

-- Réservation de démonstration
INSERT INTO reservations (chambre_id, client, date_debut, date_fin) VALUES
    (3, 'Mohamed Amine', '2025-04-20', '2025-04-25');
