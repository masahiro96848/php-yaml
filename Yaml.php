<?php
require 'Map.php';
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

if (count($argv) <= 1) {
    echo '引数を指定してください';
    return;
}

$fileName = $argv[1];
$inputFilePath = './input/' . $fileName . '.csv';

$inputFileContents = readCSV($inputFilePath);

$valueMap = new Map();

$yamlContents = [];

foreach ($inputFileContents as $row) {
    $genreMap = fetchGenre($row, $valueMap->valueMap);
    $yamlContents['body']['genre'] = $genreMap;
}



// yamlに変換する処理
file_put_contents('./output/' . $fileName . '.yaml', Yaml::dump($yamlContents, 4));


// 値ごとの関数を作成
function fetchGenre(array $row, array $valueMap)
{
    $genre = $row[$valueMap['genre']];
    if ($genre === '') {
        return NULL;
    }
    return $genre;
}

function fetchName(array $row, array $valueMap)
{
    $name = $row[$valueMap['name']];
    if ($name === '') {
        return NULL;
    }
    return $name;
}
function fetchContent(array $row, array $valueMap)
{
    $content = $row[$valueMap['content']];
    if ($genre === '') {
        return NULL;
    }
    return $content;
}

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