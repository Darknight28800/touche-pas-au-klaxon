<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\TripModel;

class ExportController
{
    public function exportTrips()
    {
        $tripModel = new TripModel();
        $trips = $tripModel->getAllForExport(); // méthode à créer dans TripModel

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Titre
        $sheet->setCellValue('A1', 'Liste des trajets');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // En-têtes
        $headers = ['Départ', 'Arrivée', 'Départ (date)', 'Arrivée (date)', 'Places totales', 'Places dispo'];
        $sheet->fromArray($headers, null, 'A3');

        // Données
        $sheet->fromArray($trips, null, 'A4');

        // Téléchargement
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="trajets.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
