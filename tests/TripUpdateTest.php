<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/TripModel.php';
require_once __DIR__ . '/../config/Database.php';

class TripUpdateTest extends TestCase
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

    public function testUpdateTrip(): void
    {
        // Récupération de l’ID du trajet créé
        $tripId = $this->pdo->lastInsertId();

        // Nouvelles données
        $data = [
            'departure_agency_id' => 1,
            'arrival_agency_id' => 3, // changement
            'departure_datetime' => '2026-06-10 09:00:00', // changement
            'arrival_datetime' => '2026-06-10 13:00:00',   // changement
            'seats_total' => 4,
            'seats_available' => 2, // changement
            'driver_id' => 1
        ];

        // Appel du modèle
        $result = $this->tripModel->update($tripId, $data);

        // Vérifie que l’UPDATE retourne TRUE
        $this->assertTrue($result, "La modification du trajet doit retourner TRUE");

        // Vérifie que les données ont bien été modifiées
        $stmt = $this->pdo->prepare("SELECT * FROM trips WHERE id = :id");
        $stmt->execute(['id' => $tripId]);
        $trip = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals(3, (int)$trip['arrival_agency_id']);
        $this->assertEquals('2026-06-10 09:00:00', $trip['departure_datetime']);
        $this->assertEquals(2, (int)$trip['seats_available']);
    }

    protected function tearDown(): void
    {
        // Nettoyage après test
        $this->pdo->exec("DELETE FROM trips");
    }
}
