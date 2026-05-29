<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/TripModel.php';
require_once __DIR__ . '/../config/Database.php';

class TripDeleteTest extends TestCase
{
    private PDO $pdo;
    private TripModel $tripModel;

    protected function setUp(): void
    {
        $this->pdo = (new Database())->getConnection();
        $this->tripModel = new TripModel($this->pdo);

        // Nettoyage avant test
        $this->pdo->exec("DELETE FROM trips");

        // Création d’un trajet initial pour le test
        $this->pdo->exec("
            INSERT INTO trips 
            (departure_agency_id, arrival_agency_id, departure_datetime, arrival_datetime, seats_total, seats_available, driver_id)
            VALUES 
            (1, 2, '2026-06-10 08:00:00', '2026-06-10 12:00:00', 4, 3, 1)
        ");
    }

    public function testDeleteTrip(): void
    {
        // Récupération de l’ID du trajet créé
        $tripId = $this->pdo->lastInsertId();

        // Appel du modèle
        $result = $this->tripModel->delete($tripId);

        // Vérifie que la suppression retourne TRUE
        $this->assertTrue($result, "La suppression du trajet doit retourner TRUE");

        // Vérifie que le trajet n'existe plus en base
        $stmt = $this->pdo->prepare("SELECT * FROM trips WHERE id = :id");
        $stmt->execute(['id' => $tripId]);
        $trip = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEmpty($trip, "Le trajet ne doit plus exister après suppression");
    }

    protected function tearDown(): void
    {
        // Nettoyage après test
        $this->pdo->exec("DELETE FROM trips");
    }
}
