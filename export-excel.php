<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Hello World !');
$sheet->setCellValue('A2', 'Ton premier fichier Excel fonctionne !');

$writer = new Xlsx($spreadsheet);
$writer->save('test.xlsx');

echo "Fichier Excel généré avec succès.";
