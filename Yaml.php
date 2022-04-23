<?php
require 'Map.php';
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$fileName = $argv[1];
$inputFilePath = './input/' . $fileName . '.csv';

$inputFileContents = readCSV($inputFilePath);

$value = new Map();

$yamlContents = [];




// CSVを読み込み、1行ずつ読み込む関数
function readCSV(string $filePath): array
{
    $file = fopen($filePath, 'rb');
    $listOfRows = [];
    $headerSkip = false;  // headerをスキップしたかどうかを判定するflg
    while (($row = fgetcsv($file)) !== false) {
        if ($headerSkip === false) {
            $headerSkip = true;
            continue;
        }
        if ($row == [null]) {
            $listOfRows[] = [];
        } else {
            $listOfRows[] = $row;
        }
    } 
    return $listOfRows;
}


?>