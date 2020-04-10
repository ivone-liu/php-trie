<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Coordinate;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setLoadSheetsOnly(["sheet1"]);
$xlsx = $reader->load('./test.xlsx'); 
$sheetData = $xlsx->getActiveSheet()->toArray(); // 将sheet数据处理为数组

// foreach ($sheetData as $data) {
// 	var_dump($data[3]); // 摘取其中第几列
// }

echo "Starting ..." . date("Y-m-d H:i:s") . "\n";

for ($i = 3; $i < count($sheetData); $i++) {
	$goods_id = $sheetData[$i][1];
	if (empty($goods_id)) {
		return;
	}
	$cat_id = $sheetData[$i][2];
	$tid = $sheetData[$i][3];
	$seller_id = $sheetData[$i][4];
	$brand_id = $sheetData[$i][5];
	$user_cat_id = $sheetData[$i][6];
	$url = "http://trans.shoping.com/api/v4/goods/trans?from=PINZHIGANG&to=YANGLIANGANG&origin=".$goods_id."&user=".$seller_id."&tid=".$tid."&cat_id=".$cat_id."&brand_id=".$brand_id."&user_cat_id=".$user_cat_id;
	$result = file_get_contents($url);
	print_r(json_decode($result, true));
}
