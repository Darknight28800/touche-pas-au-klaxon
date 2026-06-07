<?php

use PHPUnit\Framework\TestCase;
use App\Models\Database;
use App\Models\TripModel;

class TripCreationTest extends TestCase
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

    public function testCreateTrip(): void
    {
        $data = [
            'departure_agency_id' => 1,
            'arrival_agency_id'   => 2,
            'departure_datetime'  => '2026-06-10 10:00:00',
            'arrival_datetime'    => '2026-06-10 12:00:00',
            'seats_total'         => 4,
            'seats_available'     => 4,
            'driver_id'           => 1
        ];

        $result = $this->tripModel->create($data);

        $this->assertTrue($result);
    }
}
