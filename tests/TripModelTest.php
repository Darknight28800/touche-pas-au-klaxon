<?php

use PHPUnit\Framework\TestCase;
use App\Models\Database;
use App\Models\TripModel;

class TripModelTest extends TestCase
{
    private $pdo;
    private $tripModel;

    protected function setUp(): void
    {
        // Connexion via ta classe Database
        $db = new Database();
        $this->pdo = $db->getConnection();

        // On vide la table avant chaque test
        $this->pdo->exec("DELETE FROM trips");

        // Instanciation du modèle
        $this->tripModel = new TripModel();
    }

    public function testCreateTrip()
    {
        $data = [
            'departure_agency_id' => 1,
            'arrival_agency_id' => 2,
            'departure_datetime' => '2026-06-01 08:00:00',
            'arrival_datetime' => '2026-06-01 12:00:00',
            'seats_total' => 4,
            'seats_available' => 4,
            'driver_id' => 1
        ];

        $result = $this->tripModel->create($data);

        $this->assertTrue($result);

        $count = $this->pdo->query("SELECT COUNT(*) FROM trips")->fetchColumn();
        $this->assertEquals(1, $count);
    }

    public function testUpdateTrip()
    {
        // Création d’un trajet
        $this->pdo->exec("
            INSERT INTO trips (departure_agency_id, arrival_agency_id, departure_datetime, arrival_datetime, seats_total, seats_available, driver_id)
            VALUES (1, 2, '2026-06-01 08:00:00', '2026-06-01 12:00:00', 4, 4, 1)
        ");

        $id = $this->pdo->lastInsertId();

        // Données modifiées
        $data = [
            'departure_agency_id' => 1,
            'arrival_agency_id' => 3,
            'departure_datetime' => '2026-06-01 09:00:00',
            'arrival_datetime' => '2026-06-01 13:00:00',
            'seats_total' => 4,
            'seats_available' => 3
        ];

        $result = $this->tripModel->update($id, $data);

        $this->assertTrue($result);

        $trip = $this->pdo->query("SELECT arrival_agency_id FROM trips WHERE id = $id")->fetchColumn();
        $this->assertEquals(3, $trip);
    }

    public function testDeleteTrip()
    {
        // Création d’un trajet
        $this->pdo->exec("
            INSERT INTO trips (departure_agency_id, arrival_agency_id, departure_datetime, arrival_datetime, seats_total, seats_available, driver_id)
            VALUES (1, 2, '2026-06-01 08:00:00', '2026-06-01 12:00:00', 4, 4, 1)
        ");

        $id = $this->pdo->lastInsertId();

        // Suppression
        $result = $this->tripModel->delete($id);

        $this->assertTrue($result);

        $count = $this->pdo->query("SELECT COUNT(*) FROM trips WHERE id = $id")->fetchColumn();
        $this->assertEquals(0, $count);
    }
}
