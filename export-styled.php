<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// TITRE
$sheet->setCellValue('A1', 'Liste des artisans');
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

// EN-TÊTES
$headers = ['Nom', 'Ville', 'Spécialité', 'Catégorie'];
$sheet->fromArray($headers, null, 'A3');

$sheet->getStyle('A3:D3')->getFont()->setBold(true);
$sheet->getStyle('A3:D3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');
$sheet->getStyle('A3:D3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// EXEMPLE DE LIGNES
$data = [
    ['Jean Dupont', 'Paris', 'Plomberie', 'Bâtiment'],
    ['Marie Leroy', 'Lyon', 'Boulangerie', 'Alimentation'],
];

$sheet->fromArray($data, null, 'A4');

// BORDURES
$sheet->getStyle('A4:D5')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

$writer = new Xlsx($spreadsheet);
$writer->save('excel-styled.xlsx');

echo "Excel stylé généré.";
