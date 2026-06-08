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
    public function getByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Récupère un utilisateur par ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Liste tous les utilisateurs (admin)
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM users ORDER BY lastname ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    /**
     * Mise à jour du rôle d'un utilisateur (admin)
     */
    public function updateRole(int $id, string $role): bool
    {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'role' => $role,
            'id'   => $id,
        ]);
    }

    /**
     * Suppression d'un utilisateur (admin)
    */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

}
