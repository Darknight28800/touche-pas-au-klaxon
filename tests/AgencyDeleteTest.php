<?php

use PHPUnit\Framework\TestCase;
use App\Models\AgencyModel;

class AgencyDeleteTest extends TestCase
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

        // On crée une agence initiale pour pouvoir la supprimer
        $this->pdo->prepare("
            INSERT INTO agencies (name, city)
            VALUES ('Agence À Supprimer', 'Nice')
        ")->execute();
    }

    public function testAgencyDelete(): void
    {
        // On récupère l'ID de l'agence créée dans setUp()
        $stmt = $this->pdo->query("SELECT id FROM agencies LIMIT 1");
        $agency = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $agency['id'];

        // Appel du modèle
        $result = $this->agencyModel->delete($id);

        // Vérifie que la suppression retourne TRUE
        $this->assertTrue($result);

        // Vérifie que l’agence n’existe plus en base
        $stmt = $this->pdo->prepare("SELECT * FROM agencies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $deletedAgency = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($deletedAgency);
    }
}
