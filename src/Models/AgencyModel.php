<?php

namespace App\Models;

use PDO;

/**
 * AgencyModel
 * Gestion des agences (CRUD admin)
 */
class AgencyModel extends Database
{
    public function __construct()
    {
        parent::__construct(); // 🔵 Initialise $this->db
    }

    public function getAll()
    {
        $sql = "SELECT * FROM agencies ORDER BY name ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM agencies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $name)
    {
        $sql = "INSERT INTO agencies (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $name);
        return $stmt->execute();
    }

    public function update(int $id, string $name)
    {
        $sql = "UPDATE agencies SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM agencies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function countTripsForAgency($agencyId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS total 
            FROM trips 
            WHERE departure_agency_id = ? 
            OR arrival_agency_id = ?
        ");
        $stmt->execute([$agencyId, $agencyId]);
        return $stmt->fetch()['total'];
    }

    /** ⭐ Méthode manquante : ajoutée ici */
    public function countAll()
    {
        return $this->db->query("SELECT COUNT(*) FROM agencies")->fetchColumn();
    }
}
