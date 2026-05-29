<?php

namespace App\Models;

use PDO;

class TripModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
        🔵 1) TRAJETS PUBLICS (HOME)
       ============================================================ */

    public function getFilteredTripsPublic(array $filters, int $limit, int $offset)
    {
        $sql = "
            SELECT 
                t.*,
                da.name AS departure_agency_name,
                aa.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname
            FROM trips t
            JOIN agencies da ON da.id = t.departure_agency_id
            JOIN agencies aa ON aa.id = t.arrival_agency_id
            JOIN users u ON u.id = t.driver_id
            WHERE t.seats_available > 0
            AND t.departure_datetime > NOW()
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql .= " AND t.departure_agency_id = :departure";
            $params['departure'] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql .= " AND t.arrival_agency_id = :arrival";
            $params['arrival'] = $filters['arrival'];
        }

        if (!empty($filters['date'])) {
            $sql .= " AND DATE(t.departure_datetime) = :date";
            $params['date'] = $filters['date'];
        }

        $sql .= " ORDER BY t.departure_datetime ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countFilteredPublicTrips(array $filters)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM trips t
            WHERE t.seats_available > 0
            AND t.departure_datetime > NOW()
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql .= " AND t.departure_agency_id = :departure";
            $params['departure'] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql .= " AND t.arrival_agency_id = :arrival";
            $params['arrival'] = $filters['arrival'];
        }

        if (!empty($filters['date'])) {
            $sql .= " AND DATE(t.departure_datetime) = :date";
            $params['date'] = $filters['date'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }


    /* ============================================================
        🔵 2) PAGE SHOW
       ============================================================ */

    public function getById(int $id)
    {
        $sql = "
            SELECT 
                t.*,
                da.name AS departure_agency_name,
                aa.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname,
                u.email AS driver_email,
                u.phone AS driver_phone
            FROM trips t
            JOIN agencies da ON da.id = t.departure_agency_id
            JOIN agencies aa ON aa.id = t.arrival_agency_id
            JOIN users u ON u.id = t.driver_id
            WHERE t.id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* ============================================================
        🔵 3) ADMIN (LISTE + FILTRES + TRI)
       ============================================================ */

    public function getFilteredTripsAdmin($filters, $limit, $offset, $sort, $order)
    {
        switch ($sort) {
            case 'id':        $sortColumn = 't.id'; break;
            case 'departure': $sortColumn = 'da.name'; break;
            case 'arrival':   $sortColumn = 'aa.name'; break;
            case 'driver':    $sortColumn = 'u.lastname'; break;
            case 'date':
            default:          $sortColumn = 't.departure_datetime'; break;
        }

        $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';

        $sql = "
            SELECT 
                t.*,
                da.name AS departure_agency_name,
                aa.name AS arrival_agency_name,
                u.firstname AS driver_firstname,
                u.lastname AS driver_lastname
            FROM trips t
            JOIN agencies da ON da.id = t.departure_agency_id
            JOIN agencies aa ON aa.id = t.arrival_agency_id
            JOIN users u ON u.id = t.driver_id
            WHERE 1
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql .= " AND t.departure_agency_id = :departure";
            $params['departure'] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql .= " AND t.arrival_agency_id = :arrival";
            $params['arrival'] = $filters['arrival'];
        }

        if (!empty($filters['driver'])) {
            $sql .= " AND t.driver_id = :driver";
            $params['driver'] = $filters['driver'];
        }

        if (!empty($filters['date'])) {
            $sql .= " AND DATE(t.departure_datetime) = :date";
            $params['date'] = $filters['date'];
        }

        $sql .= " ORDER BY $sortColumn $order LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countFilteredTripsAdmin($filters)
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM trips t
            WHERE 1
        ";

        $params = [];

        if (!empty($filters['departure'])) {
            $sql .= " AND t.departure_agency_id = :departure";
            $params['departure'] = $filters['departure'];
        }

        if (!empty($filters['arrival'])) {
            $sql .= " AND t.arrival_agency_id = :arrival";
            $params['arrival'] = $filters['arrival'];
        }

        if (!empty($filters['driver'])) {
            $sql .= " AND t.driver_id = :driver";
            $params['driver'] = $filters['driver'];
        }

        if (!empty($filters['date'])) {
            $sql .= " AND DATE(t.departure_datetime) = :date";
            $params['date'] = $filters['date'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }


    /* ============================================================
        🔵 4) CRUD
       ============================================================ */

    public function create(array $data)
    {
        $sql = "
            INSERT INTO trips 
            (departure_agency_id, arrival_agency_id, departure_datetime, arrival_datetime, seats_total, seats_available, driver_id)
            VALUES 
            (:departure_agency_id, :arrival_agency_id, :departure_datetime, :arrival_datetime, :seats_total, :seats_available, :driver_id)
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }


    public function update(int $id, array $data)
    {
        $sql = "
            UPDATE trips SET
                departure_agency_id = :departure_agency_id,
                arrival_agency_id = :arrival_agency_id,
                departure_datetime = :departure_datetime,
                arrival_datetime = :arrival_datetime,
                seats_total = :seats_total,
                seats_available = :seats_available
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        return $stmt->execute($data);
    }


    public function delete(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM trips WHERE id = :id");
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }


    /* ============================================================
        🔵 5) EXPORT
       ============================================================ */

    public function getAllForExport()
    {
        $sql = "
            SELECT 
                t.id,
                da.name AS departure_agency_name,
                aa.name AS arrival_agency_name,
                t.departure_datetime,
                t.arrival_datetime,
                t.seats_total,
                t.seats_available,
                CONCAT(u.firstname, ' ', u.lastname) AS driver
            FROM trips t
            JOIN agencies da ON da.id = t.departure_agency_id
            JOIN agencies aa ON aa.id = t.arrival_agency_id
            JOIN users u ON u.id = t.driver_id
            ORDER BY t.departure_datetime ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ============================================================
        🔵 6) DERNIERS TRAJETS (DASHBOARD)
       ============================================================ */

    public function getLatest($limit = 5)
    {
        $sql = "
            SELECT 
                t.*,
                a1.name AS departure_agency_name,
                a2.name AS arrival_agency_name,
                CONCAT(u.firstname, ' ', u.lastname) AS driver_name
            FROM trips t
            JOIN agencies a1 ON t.departure_agency_id = a1.id
            JOIN agencies a2 ON t.arrival_agency_id = a2.id
            JOIN users u ON t.driver_id = u.id
            ORDER BY t.departure_datetime DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ============================================================
        🔵 7) COUNT ALL
       ============================================================ */

    public function countAll()
    {
        return $this->db->query("SELECT COUNT(*) FROM trips")->fetchColumn();
    }
}
