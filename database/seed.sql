-- ============================================================
--  SCRIPT D'ALIMENTATION (JEU D'ESSAIS)
--  Projet : Touche Pas Au Klaxon
--  Auteur : David
-- ============================================================

-- ============================================================
-- INSERT : USERS
-- ============================================================

INSERT INTO users (firstname, lastname, email, phone, password, role) VALUES
('Admin', 'Principal', 'admin@example.com', '0102030405', '$2y$10$abcdefghijklmnopqrstuv', 'admin'),
('Jean', 'Dupont', 'jean.dupont@example.com', '0601020304', '$2y$10$abcdefghijklmnopqrstuv', 'user'),
('Marie', 'Martin', 'marie.martin@example.com', '0605060708', '$2y$10$abcdefghijklmnopqrstuv', 'user'),
('Paul', 'Durand', 'paul.durand@example.com', '0609091011', '$2y$10$abcdefghijklmnopqrstuv', 'user');

-- NOTE :
-- Les mots de passe ci-dessus sont des placeholders.
-- Remplace-les par de vrais hash bcrypt générés via password_hash().

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

-- Trajet 1
(1, 2, '2026-06-01 08:00:00', '2026-06-01 12:00:00', 4, 2, 2),

-- Trajet 2
(2, 3, '2026-06-02 09:30:00', '2026-06-02 14:00:00', 3, 1, 3),

-- Trajet 3
(4, 1, '2026-06-03 07:15:00', '2026-06-03 11:45:00', 5, 4, 4),

-- Trajet 4
(5, 6, '2026-06-04 10:00:00', '2026-06-04 13:30:00', 4, 3, 2),

-- Trajet 5
(7, 3, '2026-06-05 06:45:00', '2026-06-05 10:15:00', 4, 1, 3);
