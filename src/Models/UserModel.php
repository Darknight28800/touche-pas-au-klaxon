<?php

namespace App\Models;

use PDO;

/**
 * UserModel
 * Gestion des utilisateurs (employés)
 */
class UserModel extends Database
{
    /**
     * Récupère un utilisateur par email (connexion)
     */
    public function getByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par ID
     */
    public function getById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Liste tous les utilisateurs (admin)
     */
    public function getAll()
    {
        $sql = "SELECT * FROM users ORDER BY lastname ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        return $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

}
