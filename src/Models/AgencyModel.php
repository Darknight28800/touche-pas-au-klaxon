<?php

namespace App\Models;

use PDO;

class AgencyModel extends Database
{
    /**
     * Récupère toutes les agences
     */
    public function getAll()
    {
        $sql = "SELECT * FROM agencies ORDER BY name ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une agence par ID
     */
    public function getById(int $id)
    {
        $sql = "SELECT * FROM agencies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle agence
     */
    public function create(string $name)
    {
        $sql = "INSERT INTO agencies (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['name' => $name]);
    }

    /**
     * Met à jour une agence
     */
    public function update(int $id, string $name)
    {
        $sql = "UPDATE agencies SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'   => $id,
            'name' => $name
        ]);
    }

    /**
     * Supprime une agence
     */
    public function delete(int $id)
    {
        $sql = "DELETE FROM agencies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compte toutes les agences
     */
    public function countAll()
    {
        return $this->db->query("SELECT COUNT(*) FROM agencies")->fetchColumn();
    }
}
