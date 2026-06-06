<?php

namespace App\Models;

use PDO;

class TripModel extends Database
{
    public function getAll(): array
    {
        $sql = "
            SELECT t.*, 
                   a1.name AS departure_agency,
                   a2.name AS arrival_agency
            FROM trips t
            JOIN agencies a1 ON t.departure_agency_id = a1.id
            JOIN agencies a2 ON t.arrival_agency_id = a2.id
            ORDER BY t.departure_datetime ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $sql = "
            SELECT t.*, 
                   a1.name AS departure_agency,
                   a2.name AS arrival_agency
            FROM trips t
            JOIN agencies a1 ON t.departure_agency_id = a1.id
            JOIN agencies a2 ON t.arrival_agency_id = a2.id
            WHERE t.id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $trip = $stmt->fetch(PDO::FETCH_ASSOC);

        return $trip ?: null;
    }

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

    public function getFilteredTripsPublic(array $filters = []): array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency,
                a2.name AS arrival_agency
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            WHERE t.seats_available > 0
              AND t.departure_datetime >= NOW()
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql      .= " AND t.departure_agency_id = ?";
            $params[] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql      .= " AND t.arrival_agency_id = ?";
            $params[] = $filters['arrival'];
        }

        if (!empty($filters['date'])) {
            $sql      .= " AND DATE(t.departure_datetime) = ?";
            $params[] = $filters['date'];
        }

        $sql .= " ORDER BY t.departure_datetime ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredPublicTrips(array $filters, int $limit, int $offset): array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency,
                a2.name AS arrival_agency
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            WHERE t.seats_available > 0
              AND t.departure_datetime >= NOW()
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql      .= " AND t.departure_agency_id = ?";
            $params[] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql      .= " AND t.arrival_agency_id = ?";
            $params[] = $filters['arrival'];
        }

        if (!empty($filters['date'])) {
            $sql      .= " AND DATE(t.departure_datetime) = ?";
            $params[] = $filters['date'];
        }

        $sql .= " ORDER BY t.departure_datetime ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $index => $value) {
            $stmt->bindValue($index + 1, $value);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFilteredPublicTrips(array $filters): int
    {
        $sql = "
            SELECT COUNT(*) 
            FROM trips t
            WHERE t.seats_available > 0
              AND t.departure_datetime >= NOW()
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql      .= " AND t.departure_agency_id = ?";
            $params[] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql      .= " AND t.arrival_agency_id = ?";
            $params[] = $filters['arrival'];
        }

        if (!empty($filters['date'])) {
            $sql      .= " AND DATE(t.departure_datetime) = ?";
            $params[] = $filters['date'];
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $index => $value) {
            $stmt->bindValue($index + 1, $value);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

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

    public function delete(int $id): bool
    {
        $sql  = "DELETE FROM trips WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    public function countAll(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM trips")->fetchColumn();
    }

    public function getAllTripsPublic(): array
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency,
                a2.name AS arrival_agency,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname,
                u.email AS driver_email,
                u.phone AS driver_phone
            FROM trips t
            JOIN agencies a1 ON a1.id = t.departure_agency_id
            JOIN agencies a2 ON a2.id = t.arrival_agency_id
            JOIN users u ON u.id = t.driver_id
            WHERE t.seats_available > 0
            AND t.departure_datetime >= NOW()
            ORDER BY t.departure_datetime ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

}
