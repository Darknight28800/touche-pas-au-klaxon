<?php

use PHPUnit\Framework\TestCase;
use App\Models\AgencyModel;

class AgencyUpdateTest extends TestCase
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

        // On vide la table avant chaque test
        $this->pdo->exec("TRUNCATE TABLE agencies");

        // Injection du PDO dans le modèle
        $this->agencyModel = new AgencyModel($this->pdo);

        // On crée une agence initiale pour pouvoir la modifier
        $this->pdo->prepare("
            INSERT INTO agencies (name, city)
            VALUES ('Agence Initiale', 'Lyon')
        ")->execute();
    }

    public function testAgencyUpdate(): void
    {
        // On récupère l'ID de l'agence créée dans setUp()
        $stmt = $this->pdo->query("SELECT id FROM agencies LIMIT 1");
        $agency = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $agency['id'];

        // Données mises à jour
        $updatedData = [
            'name' => 'Agence Modifiée',
            'city' => 'Marseille'
        ];

        // Appel du modèle
        $result = $this->agencyModel->update($id, $updatedData);

        // Vérifie que la mise à jour retourne TRUE
        $this->assertTrue($result);

        // Vérifie que les données ont bien été modifiées en base
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $updatedAgency = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Agence Modifiée', $updatedAgency['name']);
        $this->assertEquals('Marseille', $updatedAgency['city']);
    }
}
