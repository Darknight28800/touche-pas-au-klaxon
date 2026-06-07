<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AgencyModel;
use App\Models\TripModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class AdminController extends CoreController
{
    public function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . $this->router->generate('login'));
            exit;
        }
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION[$type] = $message;
    }

    /* ============================
       DASHBOARD
       ============================ */

    public function dashboard(): void
    {
        $userModel   = new UserModel();
        $agencyModel = new AgencyModel();
        $tripModel   = new TripModel();

        $this->render('admin/dashboard', [
            'usersCount'    => $userModel->countAll(),
            'agenciesCount' => $agencyModel->countAll(),
            'tripsCount'    => $tripModel->countAll(),
        ]);
    }

    /* ============================
       UTILISATEURS
       ============================ */

    public function users(): void
    {
        $users = (new UserModel())->getAll();
        $this->render('admin/users', ['users' => $users]);
    }

    public function showUser(int $id): void
    {
        $user = (new UserModel())->getById($id);

        if (!$user) {
            $this->flash('error', "Utilisateur introuvable.");
            header('Location: ' . $this->router->generate('admin-users'));
            exit;
        }

        $this->render('admin/users_show', ['user' => $user]);
    }

    public function updateUserRole(int $id): void
    {
        $role = $_POST['role'] ?? null;

        if (!in_array($role, ['user', 'admin'], true)) {
            $this->flash('error', "Rôle invalide.");
            header('Location: ' . $this->router->generate('admin-user-show', ['id' => $id]));
            exit;
        }

        (new UserModel())->updateRole($id, $role);

        $this->flash('success', "Rôle mis à jour.");
        header('Location: ' . $this->router->generate('admin-user-show', ['id' => $id]));
        exit;
    }

    public function deleteUser(int $id): void
    {
        $userModel = new UserModel();
        $user = $userModel->getById($id);

        if (!$user) {
            $this->flash('error', "Utilisateur introuvable.");
            header('Location: ' . $this->router->generate('admin-users'));
            exit;
        }

        if ($user['role'] === 'admin') {
            $this->flash('error', "Impossible de supprimer un administrateur.");
            header('Location: ' . $this->router->generate('admin-users'));
            exit;
        }

        $userModel->delete($id);

        $this->flash('success', "Utilisateur supprimé.");
        header('Location: ' . $this->router->generate('admin-users'));
        exit;
    }

    /* ============================
       AGENCES
       ============================ */

    public function agencies(): void
    {
        $agencies = (new AgencyModel())->getAll();
        $this->render('admin/agencies', ['agencies' => $agencies]);
    }

    public function createAgency(): void
    {
        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            $this->flash('error', "Nom requis.");
            header('Location: ' . $this->router->generate('admin-agencies'));
            exit;
        }

        (new AgencyModel())->create($name);

        $this->flash('success', "Agence ajoutée.");
        header('Location: ' . $this->router->generate('admin-agencies'));
        exit;
    }

    public function editAgencyForm(int $id): void
    {
        $agency = (new AgencyModel())->getById($id);

        if (!$agency) {
            $this->flash('error', "Agence introuvable.");
            header('Location: ' . $this->router->generate('admin-agencies'));
            exit;
        }

        $this->render('admin/agencies_edit', ['agency' => $agency]);
    }

    public function updateAgency(int $id): void
    {
        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            $this->flash('error', "Nom requis.");
            header('Location: ' . $this->router->generate('admin-agency-edit', ['id' => $id]));
            exit;
        }

        (new AgencyModel())->update($id, $name);

        $this->flash('success', "Agence mise à jour.");
        header('Location: ' . $this->router->generate('admin-agencies'));
        exit;
    }

    public function deleteAgency(int $id): void
    {
        (new AgencyModel())->delete($id);

        $this->flash('success', "Agence supprimée.");
        header('Location: ' . $this->router->generate('admin-agencies'));
        exit;
    }

    /* ============================
       TRAJETS
       ============================ */

    public function trips(): void
    {
        $trips = (new TripModel())->getAll();
        $this->render('admin/trips', ['trips' => $trips]);
    }

    public function createTripForm(): void
    {
        $agencies = (new AgencyModel())->getAll();
        $this->render('admin/trips_create', ['agencies' => $agencies]);
    }

    public function createTrip(): void
    {
        $departure   = $_POST['departure_agency_id'] ?? null;
        $arrival     = $_POST['arrival_agency_id'] ?? null;
        $dateDepart  = $_POST['departure_datetime'] ?? null;
        $dateArrivee = $_POST['arrival_datetime'] ?? null;
        $seatsTotal  = (int) ($_POST['seats_total'] ?? 0);
        $seatsAvail  = (int) ($_POST['seats_available'] ?? $seatsTotal);

        if ($departure === $arrival) {
            $this->flash('error', "L'agence de départ et d'arrivée doivent être différentes.");
            header('Location: ' . $this->router->generate('admin-trip-create'));
            exit;
        }

        if (!$dateDepart || !$dateArrivee || strtotime($dateArrivee) <= strtotime($dateDepart)) {
            $this->flash('error', "La date d'arrivée doit être postérieure à la date de départ.");
            header('Location: ' . $this->router->generate('admin-trip-create'));
            exit;
        }

        if ($seatsTotal < 1 || $seatsAvail < 0 || $seatsAvail > $seatsTotal) {
            $this->flash('error', "Nombre de places incohérent.");
            header('Location: ' . $this->router->generate('admin-trip-create'));
            exit;
        }

        $data = [
            'departure_agency_id' => $departure,
            'arrival_agency_id'   => $arrival,
            'departure_datetime'  => $dateDepart,
            'arrival_datetime'    => $dateArrivee,
            'seats_total'         => $seatsTotal,
            'seats_available'     => $seatsAvail,
            'driver_id'           => $_POST['driver_id'] ?? null,
        ];

        (new TripModel())->create($data);

        $this->flash('success', "Trajet créé.");
        header('Location: ' . $this->router->generate('admin-trips'));
        exit;
    }

    public function editTripForm(int $id): void
    {
        $trip = (new TripModel())->getById($id);

        if (!$trip) {
            $this->flash('error', "Trajet introuvable.");
            header('Location: ' . $this->router->generate('admin-trips'));
            exit;
        }

        $agencies = (new AgencyModel())->getAll();

        $this->render('admin/trips_edit', [
            'trip'     => $trip,
            'agencies' => $agencies,
        ]);
    }

    public function updateTrip(int $id): void
    {
        $departure   = $_POST['departure_agency_id'] ?? null;
        $arrival     = $_POST['arrival_agency_id'] ?? null;
        $dateDepart  = $_POST['departure_datetime'] ?? null;
        $dateArrivee = $_POST['arrival_datetime'] ?? null;
        $seatsTotal  = (int) ($_POST['seats_total'] ?? 0);
        $seatsAvail  = (int) ($_POST['seats_available'] ?? 0);

        if ($departure === $arrival) {
            $this->flash('error', "L'agence de départ et d'arrivée doivent être différentes.");
            header('Location: ' . $this->router->generate('admin-trip-edit', ['id' => $id]));
            exit;
        }

        if (!$dateDepart || !$dateArrivee || strtotime($dateArrivee) <= strtotime($dateDepart)) {
            $this->flash('error', "La date d'arrivée doit être postérieure à la date de départ.");
            header('Location: ' . $this->router->generate('admin-trip-edit', ['id' => $id]));
            exit;
        }

        if ($seatsTotal < 1 || $seatsAvail < 0 || $seatsAvail > $seatsTotal) {
            $this->flash('error', "Nombre de places incohérent.");
            header('Location: ' . $this->router->generate('admin-trip-edit', ['id' => $id]));
            exit;
        }

        $data = [
            'departure_agency_id' => $departure,
            'arrival_agency_id'   => $arrival,
            'departure_datetime'  => $dateDepart,
            'arrival_datetime'    => $dateArrivee,
            'seats_total'         => $seatsTotal,
            'seats_available'     => $seatsAvail,
        ];

        (new TripModel())->update($id, $data);

        $this->flash('success', "Trajet mis à jour.");
        header('Location: ' . $this->router->generate('admin-trips'));
        exit;
    }

    public function deleteTrip(int $id): void
    {
        (new TripModel())->delete($id);

        $this->flash('success', "Trajet supprimé.");
        header('Location: ' . $this->router->generate('admin-trips'));
        exit;
    }

    /* ============================
       EXPORT CSV
       ============================ */

    public function exportTripsCSV(): void
    {
        $tripModel = new TripModel();
        $trips = $tripModel->getAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="trips_' . date('Y-m-d_H-i') . '.csv"');

        $output = fopen('php://output', 'w');

        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($output, [
            'ID',
            'Agence départ',
            'Agence arrivée',
            'Départ',
            'Arrivée',
            'Places dispo',
            'Places totales',
            'Conducteur'
        ]);

        foreach ($trips as $t) {
            fputcsv($output, [
                $t['id'],
                $t['departure_agency_name'],
                $t['arrival_agency_name'],
                $t['departure_datetime'],
                $t['arrival_datetime'],
                $t['seats_available'],
                $t['seats_total'],
                trim(($t['driver_firstname'] ?? '') . ' ' . ($t['driver_lastname'] ?? '')),
            ]);
        }

        fclose($output);
        exit;
    }

    /* ============================
       EXPORT EXCEL
       ============================ */

    public function exportTripsExcel(): void
    {
        $tripModel = new TripModel();
        $trips = $tripModel->getAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Agence départ');
        $sheet->setCellValue('C1', 'Agence arrivée');
        $sheet->setCellValue('D1', 'Départ');
        $sheet->setCellValue('E1', 'Arrivée');
        $sheet->setCellValue('F1', 'Places dispo');
        $sheet->setCellValue('G1', 'Places totales');
        $sheet->setCellValue('H1', 'Conducteur');

        $row = 2;

        foreach ($trips as $t) {
            $sheet->setCellValue('A' . $row, $t['id']);
            $sheet->setCellValue('B' . $row, $t['departure_agency_name']);
            $sheet->setCellValue('C' . $row, $t['arrival_agency_name']);
            $sheet->setCellValue('D' . $row, $t['departure_datetime']);
            $sheet->setCellValue('E' . $row, $t['arrival_datetime']);
            $sheet->setCellValue('F' . $row, $t['seats_available']);
            $sheet->setCellValue('G' . $row, $t['seats_total']);
            $sheet->setCellValue('H' . $row, trim(($t['driver_firstname'] ?? '') . ' ' . ($t['driver_lastname'] ?? '')));
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="trips_' . date('Y-m-d_H-i') . '.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /* ============================
       EXPORT PDF
       ============================ */

    public function exportTripsPDF(): void
    {
        $tripModel = new TripModel();
        $trips = $tripModel->getAll();

        $html = '<h1>Liste des trajets</h1>';
        $html .= '<table border="1" cellspacing="0" cellpadding="6" width="100%">';
        $html .= '<tr>
                    <th>ID</th>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date départ</th>
                    <th>Date arrivée</th>
                    <th>Places</th>
                    <th>Conducteur</th>
                  </tr>';

        foreach ($trips as $t) {
            $html .= '<tr>
                        <td>' . $t['id'] . '</td>
                        <td>' . $t['departure_agency_name'] . '</td>
                        <td>' . $t['arrival_agency_name'] . '</td>
                        <td>' . $t['departure_datetime'] . '</td>
                        <td>' . $t['arrival_datetime'] . '</td>
                        <td>' . $t['seats_available'] . '/' . $t['seats_total'] . '</td>
                        <td>' . trim(($t['driver_firstname'] ?? '') . ' ' . ($t['driver_lastname'] ?? '')) . '</td>
                      </tr>';
        }

        $html .= '</table>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('trips_' . date('Y-m-d_H-i') . '.pdf', ['Attachment' => true]);
        exit;
    }
}
