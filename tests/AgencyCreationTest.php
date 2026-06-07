<?php

use PHPUnit\Framework\TestCase;
use App\Models\AgencyModel;

class AgencyCreationTest extends TestCase
{
    private PDO $pdo;
    private AgencyModel $agencyModel;

    protected function setUp(): void
    {
        // Connexion à la base de TEST
        $this->pdo = new PDO(
            'mysql:host=localhost;dbname=tpk_test;charset=utf8',
            'root',
            ''
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // On vide proprement les tables liées
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("DELETE FROM trips");
        $this->pdo->exec("DELETE FROM agencies");
        $this->pdo->exec("ALTER TABLE agencies AUTO_INCREMENT = 1");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

        // On injecte la connexion dans le modèle
        $this->agencyModel = new AgencyModel($this->pdo);
    }

    public function testAgencyCreation(): void
    {
        // Données de test
        $data = [
            'name' => 'Agence Test',
            'city' => 'Paris'
        ];

        // Appel du modèle
        $result = $this->agencyModel->create($data);

        // Vérifie que la création retourne TRUE
        $this->assertTrue($result);

        // Vérifie que l’agence existe en base
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE name = :name");
        $stmt->execute(['name' => 'Agence Test']);
        $agency = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($agency);
        $this->assertEquals('Agence Test', $agency['name']);
        $this->assertEquals('Paris', $agency['city']);
    }
}
