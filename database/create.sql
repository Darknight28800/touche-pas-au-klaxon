-- ============================================================
--  SCRIPT DE CREATION DE LA BASE DE DONNEES
--  Projet : Touche Pas Au Klaxon
--  Auteur : David
-- ============================================================

-- Supprimer les tables si elles existent déjà
DROP TABLE IF EXISTS trips;
DROP TABLE IF EXISTS agencies;
DROP TABLE IF EXISTS users;

-- ============================================================
-- TABLE : users
-- ============================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

-- ============================================================
-- TABLE : agencies
-- ============================================================
CREATE TABLE agencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE
);

-- ============================================================
-- TABLE : trips
-- ============================================================
CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departure_agency_id INT NOT NULL,
    arrival_agency_id INT NOT NULL,
    departure_datetime DATETIME NOT NULL,
    arrival_datetime DATETIME NOT NULL,
    seats_total INT NOT NULL,
    seats_available INT NOT NULL,
    driver_id INT NOT NULL,

    CONSTRAINT fk_departure_agency
        FOREIGN KEY (departure_agency_id) REFERENCES agencies(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_arrival_agency
        FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_driver
        FOREIGN KEY (driver_id) REFERENCES users(id)
        ON DELETE CASCADE
);
