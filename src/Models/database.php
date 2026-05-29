<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private string $host = "localhost";
    private string $port = "3306";
    private string $dbname = "touche_pas_au_klaxon";
    private string $username = "root";
    private string $password = "";

    protected PDO $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Établit la connexion PDO
     */
    private function connect(): PDO
    {
        try {
            return new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
     * Retourne la connexion PDO (utilisé par PHPUnit)
     */
    public function getConnection(): PDO
    {
        return $this->db;
    }
}
