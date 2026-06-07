<?php

use PHPUnit\Framework\TestCase;
use App\Models\Database;
use App\Models\TripModel;

class TripUpdateTest extends TestCase
{
    private TripModel $tripModel;
    private PDO $pdo;

    protected function setUp(): void
    {
        $db = new Database('tpk_test');
        $this->pdo = $db->getConnection();

        // Nettoyage propre
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->pdo->exec("DELETE FROM trips");
        $this->pdo->exec("ALTER TABLE trips AUTO_INCREMENT = 1");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

        $this->tripModel = new TripModel($this->pdo);
    }

    public function testUpdateTrip(): void
    {
        // Création d’un trajet
        $this->tripModel->create([
            'departure_agency_id' => 1,
            'arrival_agency_id'   => 2,
            'departure_datetime'  => '2026-06-10 10:00:00',
            'arrival_datetime'    => '2026-06-10 12:00:00',
            'seats_total'         => 4,
            'seats_available'     => 4,
            'driver_id'           => 1
        ]);

        // Récupération de l’ID
        $id = $this->pdo->query("SELECT id_trip FROM trips LIMIT 1")->fetchColumn();

        // Mise à jour
        $result = $this->tripModel->update($id, [
            'departure_agency_id' => 1,
            'arrival_agency_id'   => 3,
            'departure_datetime'  => '2026-06-10 11:00:00',
            'arrival_datetime'    => '2026-06-10 13:00:00',
            'seats_total'         => 4,
            'seats_available'     => 3,
            'driver_id'           => 1
        ]);

        $this->assertTrue($result);
    }
}
