<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/TripModel.php';
require_once __DIR__ . '/../config/Database.php';

class TripCreationTest extends TestCase
{
    private PDO $pdo;
    private TripModel $tripModel;

    protected function setUp(): void
    {
        $this->pdo = (new Database())->getConnection();
        $this->tripModel = new TripModel($this->pdo);

        // Nettoyage avant test
        $this->pdo->exec("DELETE FROM trips");
    }

    public function testCreateTrip(): void
    {
        $data = [
            'departure_agency_id' => 1,
            'arrival_agency_id' => 2,
            'departure_datetime' => '2026-06-10 08:00:00',
            'arrival_datetime' => '2026-06-10 12:00:00',
            'seats_total' => 4,
            'seats_available' => 3,
            'driver_id' => 1
        ];

        // Exécution
        $result = $this->tripModel->create($data);

        // Vérifie que l'INSERT retourne TRUE
        $this->assertTrue($result, "La création du trajet doit retourner TRUE");

        // Vérifie que le trajet existe réellement en base
        $stmt = $this->pdo->query("
            SELECT * FROM trips 
            WHERE departure_agency_id = 1 
                AND arrival_agency_id = 2
                AND seats_total = 4
        ");

        $trip = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($trip, "Le trajet doit exister en base après création");
        $this->assertEquals(3, (int)$trip['seats_available']);
        $this->assertEquals(1, (int)$trip['driver_id']);
    }

    protected function tearDown(): void
    {
        // Nettoyage après test
        $this->pdo->exec("DELETE FROM trips");
    }
}
