<?php

namespace App\Controllers;

use App\Models\TripModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class ExportController
 *
 * Gère l'export Excel des trajets pour l'administration.
 */
class ExportController extends CoreController
{
    /**
     * Export des trajets au format Excel.
     *
     * @return void
     */
    public function exportTrips(): void
    {
        $tripModel = new TripModel();
        $trips = $tripModel->getAllForExport();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Titre
        $sheet->setCellValue('A1', 'Liste des trajets');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // En-têtes
        $headers = [
            'Départ',
            'Arrivée',
            'Départ (date)',
            'Arrivée (date)',
            'Places totales',
            'Places dispo',
            'Conducteur'
        ];

        $sheet->fromArray($headers, null, 'A3');

        // Données formatées
        $formattedTrips = [];

        foreach ($trips as $trip) {
            $formattedTrips[] = [
                $trip['departure_agency'],
                $trip['arrival_agency'],
                $trip['departure_datetime'],
                $trip['arrival_datetime'],
                $trip['seats_total'],
                $trip['seats_available'],
                trim(($trip['driver_firstname'] ?? '') . ' ' . ($trip['driver_lastname'] ?? ''))
            ];
        }

        $sheet->fromArray($formattedTrips, null, 'A4');

        // Téléchargement
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="trajets.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
