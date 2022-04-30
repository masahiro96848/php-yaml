<?php
require 'Map.php';
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

if (count($argv) <= 1) {   # コマンドラインで引数があるかどうかの条件分岐
    echo '引数を指定してください';
    return;
}

$fileName = $argv[1];  # csvのファイル名の引数
$inputFilePath = './input/' . $fileName . '.csv';

$inputFileContents = readCSV($inputFilePath);

$valueMap = new Map(); # Mapをインスタンス化

$yamlContents = []; # $yamlContentsの変数に配列を格納

foreach ($inputFileContents as $row) {  # 読み込んだCSVをforeachで回して取得
    $tableName = $row[$valueMap->valueMap['table-name']];  # テーブルを取得する変数
    $genreMap = fetchGenre($row, $valueMap->valueMap);
    $nameMap = fetchName($row, $valueMap->valueMap);
    $contentMap = fetchContent($row, $valueMap->valueMap);
    $yamlContents['body'][$tableName]['genre'] = $genreMap;
    $yamlContents['body'][$tableName]['name'] = $nameMap;
    $yamlContents['body'][$tableName]['content'] = $contentMap;

}
var_dump($yamlContents);

// 配列をyamlに変換する処理
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
    return explode(',', $name);
}
function fetchContent(array $row, array $valueMap)
{
    $content = $row[$valueMap['content']];
    if ($content === '') {
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