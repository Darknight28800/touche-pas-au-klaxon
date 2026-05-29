<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AgencyModel;
use App\Models\TripModel;

class AdminController
{
    /* ============================================================
       🔒 SÉCURITÉ ADMIN
       ============================================================ */
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }
    }

    /* ============================================================
       🔵 FLASH MESSAGES
       ============================================================ */
    private function flash($message, $type = 'success')
    {
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type
        ];
    }

    /* ============================================================
       🔐 CSRF TOKEN
       ============================================================ */
    private function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    private function verifyCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /* ============================================================
       🔵 DASHBOARD
       ============================================================ */
    public function dashboard()
    {
        $userModel   = new UserModel();
        $agencyModel = new AgencyModel();
        $tripModel   = new TripModel();

        $stats = [
            'users'    => $userModel->countAll(),
            'agencies' => $agencyModel->countAll(),
            'trips'    => $tripModel->countAll()
        ];

        $latestTrips = $tripModel->getLatest(5);

        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    /* ============================================================
       🔵 UTILISATEURS
       ============================================================ */
    public function users()
    {
        $userModel = new UserModel();
        $users = $userModel->getAll();

        require_once __DIR__ . '/../Views/admin/users.php';
    }

    /* ============================================================
       🔵 AGENCES
       ============================================================ */
    public function agencies()
    {
        $agencyModel = new AgencyModel();
        $agencies = $agencyModel->getAll();

        require_once __DIR__ . '/../Views/admin/agencies.php';
    }

    public function createAgency()
    {
        if (!empty($_POST['name'])) {
            $agencyModel = new AgencyModel();
            $agencyModel->create($_POST['name']);
            $this->flash("Agence créée avec succès !");
        }

        header('Location: /admin/agencies');
        exit;
    }

    public function updateAgency($id)
    {
        if (!empty($_POST['name'])) {
            $agencyModel = new AgencyModel();
            $agencyModel->update($id, $_POST['name']);
            $this->flash("Agence mise à jour !");
        }

        header('Location: /admin/agencies');
        exit;
    }

    public function deleteAgency($id)
    {
        $agencyModel = new AgencyModel();

        $count = $agencyModel->countTripsForAgency($id);

        if ($count > 0) {
            $this->flash("Impossible de supprimer cette agence : elle est utilisée dans $count trajet(s).", "danger");
            header('Location: /admin/agencies');
            exit;
        }

        $agencyModel->delete($id);
        $this->flash("Agence supprimée !");
        header('Location: /admin/agencies');
        exit;
    }

    /* ============================================================
       🔵 TRAJETS (LISTE + FILTRES + TRI + PAGINATION)
       ============================================================ */
    public function trips()
    {
        $tripModel   = new TripModel();
        $agencyModel = new AgencyModel();
        $userModel   = new UserModel();

        $sort  = $_GET['sort']  ?? 'date';
        $order = $_GET['order'] ?? 'asc';

        $filters = [
            'departure' => $_GET['departure'] ?? null,
            'arrival'   => $_GET['arrival'] ?? null,
            'driver'    => $_GET['driver'] ?? null,
            'date'      => $_GET['date'] ?? null
        ];

        $page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $trips      = $tripModel->getFilteredTripsAdmin($filters, $limit, $offset, $sort, $order);
        $totalTrips = $tripModel->countFilteredTripsAdmin($filters);
        $totalPages = max(1, ceil($totalTrips / $limit));

        $agencies = $agencyModel->getAll();
        $users    = $userModel->getAll();

        require_once __DIR__ . '/../Views/admin/trips.php';
    }

    /* ============================================================
       🔵 FORMULAIRE CRÉATION TRAJET
       ============================================================ */
    public function createTripForm()
    {
        $agencyModel = new AgencyModel();
        $userModel   = new UserModel();

        $agencies = $agencyModel->getAll();
        $users    = $userModel->getAll();

        require_once __DIR__ . '/../Views/admin/trips_create.php';
    }

    public function createTrip()
    {
        if ($_POST['departure_agency_id'] == $_POST['arrival_agency_id']) {
            $this->flash("L'agence de départ et d'arrivée doivent être différentes.", "danger");
            header('Location: /admin/trips/create');
            exit;
        }

        if (strtotime($_POST['arrival_datetime']) <= strtotime($_POST['departure_datetime'])) {
            $this->flash("La date d'arrivée doit être après la date de départ.", "danger");
            header('Location: /admin/trips/create');
            exit;
        }

        $tripModel = new TripModel();

        $data = [
            'departure_agency_id' => $_POST['departure_agency_id'],
            'arrival_agency_id'   => $_POST['arrival_agency_id'],
            'departure_datetime'  => $_POST['departure_datetime'],
            'arrival_datetime'    => $_POST['arrival_datetime'],
            'seats_total'         => $_POST['seats_total'],
            'seats_available'     => $_POST['seats_total'],
            'driver_id'           => $_POST['driver_id']
        ];

        $tripModel->create($data);

        $this->flash("Trajet créé avec succès !");
        header('Location: /admin/trips');
        exit;
    }

    /* ============================================================
       🔵 FORMULAIRE ÉDITION TRAJET
       ============================================================ */
    public function editTripForm($id)
    {
        $tripModel   = new TripModel();
        $agencyModel = new AgencyModel();
        $userModel   = new UserModel();

        $trip     = $tripModel->getById($id);
        $agencies = $agencyModel->getAll();
        $users    = $userModel->getAll();

        require_once __DIR__ . '/../Views/admin/trips_edit.php';
    }

    public function updateTrip($id)
    {
        if ($_POST['departure_agency_id'] == $_POST['arrival_agency_id']) {
            $this->flash("L'agence de départ et d'arrivée doivent être différentes.", "danger");
            header('Location: /admin/trips/'.$id.'/edit');
            exit;
        }

        if (strtotime($_POST['arrival_datetime']) <= strtotime($_POST['departure_datetime'])) {
            $this->flash("La date d'arrivée doit être après la date de départ.", "danger");
            header('Location: /admin/trips/'.$id.'/edit');
            exit;
        }

        $seatsAvailable = min($_POST['seats_available'], $_POST['seats_total']);

        $tripModel = new TripModel();

        $data = [
            'departure_agency_id' => $_POST['departure_agency_id'],
            'arrival_agency_id'   => $_POST['arrival_agency_id'],
            'departure_datetime'  => $_POST['departure_datetime'],
            'arrival_datetime'    => $_POST['arrival_datetime'],
            'seats_total'         => $_POST['seats_total'],
            'seats_available'     => $seatsAvailable,
            'driver_id'           => $_POST['driver_id']
        ];

        $tripModel->update($id, $data);

        $this->flash("Trajet mis à jour !");
        header('Location: /admin/trips');
        exit;
    }

    /* ============================================================
       🔵 SUPPRESSION TRAJET
       ============================================================ */
    public function deleteTrip($id)
    {
        $tripModel = new TripModel();
        $tripModel->delete($id);

        $this->flash("Trajet supprimé !");
        header('Location: /admin/trips');
        exit;
    }

    /* ============================================================
       🔵 EXPORT PDF
       ============================================================ */
    public function exportTripsPDF()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        $tripModel = new TripModel();

        $filters = [
            'departure' => $_GET['departure'] ?? null,
            'arrival'   => $_GET['arrival'] ?? null,
            'driver'    => $_GET['driver'] ?? null,
            'date'      => $_GET['date'] ?? null
        ];

        $sort  = $_GET['sort'] ?? 'date';
        $order = $_GET['order'] ?? 'asc';

        $trips = $tripModel->getFilteredTripsAdmin($filters, 999999, 0, $sort, $order);

        ob_start();
        require __DIR__ . '/../Views/admin/pdf_trips.php';
        $html = ob_get_clean();

        $dompdf = new \Dompdf\Dompdf([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("trajets.pdf", ["Attachment" => true]);
        exit;
    }

    /* ============================================================
       🔵 EXPORT CSV
       ============================================================ */
    public function exportTripsCSV()
    {
        $tripModel = new TripModel();

        $filters = [
            'departure' => $_GET['departure'] ?? null,
            'arrival'   => $_GET['arrival'] ?? null,
            'driver'    => $_GET['driver'] ?? null,
            'date'      => $_GET['date'] ?? null
        ];

        $sort  = $_GET['sort'] ?? 'date';
        $order = $_GET['order'] ?? 'asc';

        $trips = $tripModel->getFilteredTripsAdmin($filters, 999999, 0, $sort, $order);

        $filename = "trajets_" . date('Y-m-d_H-i') . ".csv";

        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo "\xEF\xBB\xBF";

        $output = fopen("php://output", "w");

        fputcsv($output, [
            "ID",
            "Départ",
            "Arrivée",
            "Date départ",
            "Conducteur",
            "Places totales",
            "Places dispo"
        ], ";");

        foreach ($trips as $trip) {
            fputcsv($output, [
                $trip['id'],
                $trip['departure_agency_name'],
                $trip['arrival_agency_name'],
                date('d/m/Y H:i', strtotime($trip['departure_datetime'])),
                $trip['driver_firstname'] . ' ' . $trip['driver_lastname'],
                $trip['seats_total'],
                $trip['seats_available']
            ], ";");
        }

        fclose($output);
        exit;
    }

    /* ============================================================
       🔵 EXPORT EXCEL
       ============================================================ */
    public function exportTripsExcel()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        $tripModel = new TripModel();

        $filters = [
            'departure' => $_GET['departure'] ?? null,
            'arrival'   => $_GET['arrival'] ?? null,
            'driver'    => $_GET['driver'] ?? null,
            'date'      => $_GET['date'] ?? null
        ];

        $sort  = $_GET['sort'] ?? 'date';
        $order = $_GET['order'] ?? 'asc';

        $trips = $tripModel->getFilteredTripsAdmin($filters, 999999, 0, $sort, $order);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Trajets');

        $headers = [
            "ID",
            "Départ",
            "Arrivée",
            "Date départ",
            "Conducteur",
            "Places totales",
            "Places dispo"
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        $row = 2;
        foreach ($trips as $trip) {
            $sheet->setCellValue("A$row", $trip['id']);
            $sheet->setCellValue("B$row", $trip['departure_agency_name']);
            $sheet->setCellValue("C$row", $trip['arrival_agency_name']);
            $sheet->setCellValue("D$row", date('d/m/Y H:i', strtotime($trip['departure_datetime'])));
            $sheet->setCellValue("E$row", $trip['driver_firstname'] . ' ' . $trip['driver_lastname']);
            $sheet->setCellValue("F$row", $trip['seats_total']);
            $sheet->setCellValue("G$row", $trip['seats_available']);
            $row++;
        }

        $filename = "trajets_" . date('Y-m-d_H-i') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
