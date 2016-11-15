<?php
require 'vendor/autoload.php';
$originalFile = file_get_contents('en.json');
$translationFile = file_get_contents('cs.json');
$original = (array) json_decode($originalFile);
$translation = (array) json_decode($translationFile);

$originalKeys = array_keys($original);
$translationKeys = array_keys($translation);

$result = [];
foreach ($originalKeys as $key) {
    $result[$key] = [
        'key' => $key,
        'original' => $original[$key] ?? '',
        'translation' => $translation[$key] ?? '',
    ];
}

$writer = \League\Csv\Writer::createFromPath('result.csv', 'w+');
if ($writer->isActiveStreamFilter()) {
    //$writer->appendStreamFilter('convert.iconv.UTF-8/CP1250');
}

$writer->insertAll($result);
