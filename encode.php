<?php
require 'vendor/autoload.php';
$reader = \League\Csv\Reader::createFromPath('translated.csv');
if ($reader->isActiveStreamFilter()) {
    //$reader->appendStreamFilter('convert.iconv.CP1250/UTF-8');
}
$reader->stripBom(true);
$data = $reader->fetchAll();
$result = new stdClass();
foreach ($data as $value) {
    $result->{$value[0]} = $value[2];
}
file_put_contents('result.json', json_encode($result, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));


