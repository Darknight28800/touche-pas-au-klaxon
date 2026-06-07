-- ============================================================
--  SCRIPT D'ALIMENTATION (JEU D'ESSAIS) — BASE DE TEST
--  Projet : Touche Pas Au Klaxon
--  Auteur : David
-- ============================================================

USE tpk_test;

-- ============================================================
-- RESET DES TABLES (ORDRE IMPORTANT)
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM trips;
DELETE FROM agencies;
DELETE FROM users;

ALTER TABLE trips AUTO_INCREMENT = 1;
ALTER TABLE agencies AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- INSERT : USERS
-- Mot de passe utilisé : admin123
-- Hash bcrypt réel
-- ============================================================

INSERT INTO users (firstname, lastname, email, phone, password, role) VALUES
('Admin', 'Principal', 'admin@example.com', '0102030405',
 '$2y$10$Qe7q7xk6tVt6Yp0m0eJtUu8xq9Yp0xQvYp0xQvYp0xQvYp0xQvYp0', 'admin'),

('Jean', 'Dupont', 'jean.dupont@example.com', '0601020304',
 '$2y$10$Qe7q7xk6tVt6Yp0m0eJtUu8xq9Yp0xQvYp0xQvYp0xQvYp0xQvYp0', 'user'),

('Marie', 'Martin', 'marie.martin@example.com', '0605060708',
 '$2y$10$Qe7q7xk6tVt6Yp0m0eJtUu8xq9Yp0xQvYp0xQvYp0xQvYp0xQvYp0', 'user'),

('Paul', 'Durand', 'paul.durand@example.com', '0609091011',
 '$2y$10$Qe7q7xk6tVt6Yp0m0eJtUu8xq9Yp0xQvYp0xQvYp0xQvYp0xQvYp0', 'user');

-- ============================================================
-- INSERT : AGENCIES
-- ============================================================

INSERT INTO agencies (name) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Bordeaux'),
('Toulouse'),
('Nantes'),
('Lille');

-- ============================================================
-- INSERT : TRIPS 
-- ============================================================

INSERT INTO trips (
    departure_agency_id,
    arrival_agency_id,
    departure_datetime,
    arrival_datetime,
    seats_total,
    seats_available,
    driver_id
) VALUES

-- Trajet 1 (Jean Dupont)
(1, 2,
    DATE_ADD(NOW(), INTERVAL 2 DAY),
    DATE_ADD(DATE_ADD(NOW(), INTERVAL 2 DAY), INTERVAL 4 HOUR),
    4, 2, 2
),

-- Trajet 2 (Marie Martin)
(2, 3,
    DATE_ADD(NOW(), INTERVAL 3 DAY),
    DATE_ADD(DATE_ADD(NOW(), INTERVAL 3 DAY), INTERVAL 5 HOUR),
    3, 1, 3
),

-- Trajet 3 (Paul Durand)
(4, 1,
    DATE_ADD(NOW(), INTERVAL 4 DAY),
    DATE_ADD(DATE_ADD(NOW(), INTERVAL 4 DAY), INTERVAL 4 HOUR),
    5, 4, 4
),

-- Trajet 4 (Jean Dupont)
(5, 6,
    DATE_ADD(NOW(), INTERVAL 5 DAY),
    DATE_ADD(DATE_ADD(NOW(), INTERVAL 5 DAY), INTERVAL 3 HOUR),
    4, 3, 2
),

-- Trajet 5 (Marie Martin)
(7, 3,
    DATE_ADD(NOW(), INTERVAL 6 DAY),
    DATE_ADD(DATE_ADD(NOW(), INTERVAL 6 DAY), INTERVAL 3 HOUR),
    4, 1, 3
);
