<?php

namespace App\Models;

use PDO;

class TripModel extends Database
{
    /**
     * Liste complète des trajets (admin + exports)
     */
    public function getAll(): array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency_name,
                a2.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname,
                u.email AS driver_email,
                u.phone AS driver_phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            LEFT JOIN users u ON u.id = t.driver_id
            ORDER BY t.departure_datetime ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trajet par ID (admin + public)
     */
    public function getById(int $id): ?array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency_name,
                a2.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname,
                u.email AS driver_email,
                u.phone AS driver_phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            LEFT JOIN users u ON u.id = t.driver_id
            WHERE t.id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $trip = $stmt->fetch(PDO::FETCH_ASSOC);

        return $trip ?: null;
    }

    /**
     * Création d’un trajet
     */
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO trips 
            (departure_agency_id, arrival_agency_id, departure_datetime, arrival_datetime, 
             seats_total, seats_available, driver_id)
            VALUES 
            (:departure_agency_id, :arrival_agency_id, :departure_datetime, :arrival_datetime, 
             :seats_total, :seats_available, :driver_id)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id'   => $data['arrival_agency_id'],
            'departure_datetime'  => $data['departure_datetime'],
            'arrival_datetime'    => $data['arrival_datetime'],
            'seats_total'         => $data['seats_total'],
            'seats_available'     => $data['seats_available'],
            'driver_id'           => $data['driver_id'] ?? null,
        ]);
    }

    /**
     * Mise à jour d’un trajet
     */
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE trips SET
                departure_agency_id = :departure_agency_id,
                arrival_agency_id   = :arrival_agency_id,
                departure_datetime  = :departure_datetime,
                arrival_datetime    = :arrival_datetime,
                seats_total         = :seats_total,
                seats_available     = :seats_available
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'                  => $id,
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id'   => $data['arrival_agency_id'],
            'departure_datetime'  => $data['departure_datetime'],
            'arrival_datetime'    => $data['arrival_datetime'],
            'seats_total'         => $data['seats_total'],
            'seats_available'     => $data['seats_available'],
        ]);
    }

    /**
     * Suppression d’un trajet
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM trips WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compteur total
     */
    public function countAll(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM trips")->fetchColumn();
    }

    /**
     * Liste complète des trajets pour les exports (Excel / PDF)
     */
    public function getAllForExport(): array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency_name,
                a2.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname,
                u.email AS driver_email,
                u.phone AS driver_phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            LEFT JOIN users u ON u.id = t.driver_id
            ORDER BY t.departure_datetime ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Liste publique des trajets (page d'accueil)
     */
    public function getAllTripsPublic(): array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency_name,
                a2.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname,
                u.email AS driver_email,
                u.phone AS driver_phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            LEFT JOIN users u ON u.id = t.driver_id
            WHERE t.seats_available > 0
            ORDER BY t.departure_datetime ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Liste publique filtrée des trajets
     */
    public function getFilteredTripsPublic(array $filters): array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency_name,
                a2.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname,
                u.email AS driver_email,
                u.phone AS driver_phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            LEFT JOIN users u ON u.id = t.driver_id
            WHERE t.seats_available > 0
              AND t.departure_datetime > NOW()
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql .= " AND t.departure_agency_id = :dep";
            $params['dep'] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql .= " AND t.arrival_agency_id = :arr";
            $params['arr'] = $filters['arrival'];
        }

        if (!empty($filters['date'])) {
            $sql .= " AND DATE(t.departure_datetime) = :date";
            $params['date'] = $filters['date'];
        }

        $sql .= " ORDER BY t.departure_datetime ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
