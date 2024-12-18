<?php

// require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Maarten Balliauw')
    ->setTitle('Office 2007 XLSX Test Document')
    ->setSubject('Office 2007 XLSX Test Document')
    ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Test result file');

// Add some data
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'ลำดับ')
    ->setCellValue('B1', 'ชื่อ')
    ->setCellValue('C1', 'เบอร์โทร');

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A2', '1')
    ->setCellValue('B2', 'วรรณชนก พ่วงทรัพย์')
    ->setCellValue('C2', '0928679411');

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A3', '2')
    ->setCellValue('B3', 'อรทัย ฤทธิรงค์')
    ->setCellValue('C3', '0925392364');
	
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A4', '3')
    ->setCellValue('B4', 'สมพงษ์ อนุภาพ')
    ->setCellValue('C4', '0914495989');
	
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A5', '4')
    ->setCellValue('B5', 'ณิชกานต์ สุขแจ่ม')
    ->setCellValue('C5', '0989356019');
// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Simple');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;