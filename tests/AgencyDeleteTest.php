<?php

use PHPUnit\Framework\TestCase;
use App\Models\AgencyModel;

class AgencyDeleteTest extends TestCase
{
    private PDO $pdo;
    private AgencyModel $agencyModel;

    protected function setUp(): void
    {
        // Connexion base de TEST
        $this->pdo = new PDO(
            'mysql:host=localhost;dbname=tpk_test;charset=utf8',
            'root',
            ''
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Nettoyage propre des tables
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("DELETE FROM trips");
        $this->pdo->exec("DELETE FROM agencies");
        $this->pdo->exec("ALTER TABLE agencies AUTO_INCREMENT = 1");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

        // Injection du modèle
        $this->agencyModel = new AgencyModel($this->pdo);
    }

    public function testAgencyDelete(): void
    {
        // Création d’une agence
        $this->agencyModel->create([
            'name' => 'Agence À Supprimer',
            'city' => 'Nice'
        ]);

        // Récupération de l’ID
        $stmt = $this->pdo->query("SELECT id_agency FROM agencies LIMIT 1");
        $id = $stmt->fetchColumn();

        // Suppression
        $result = $this->agencyModel->delete($id);

        $this->assertTrue($result);

        // Vérification
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE id_agency = :id");
        $stmt->execute(['id' => $id]);
        $agency = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($agency); // L’agence ne doit plus exister
    }
}
