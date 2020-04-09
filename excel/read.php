<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Coordinate;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setLoadSheetsOnly(["Sheet1"]);
$xlsx = $reader->load('./read.xlsx'); 
$sheetData = $xlsx->getActiveSheet()->toArray(); // 将sheet数据处理为数组

foreach ($sheetData as $data) {
	var_dump($data[2]); // 摘取其中第几列
}
