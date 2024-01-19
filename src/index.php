<?php

use App\Map;

require '../vendor/autoload.php';

$input = explode("\r\n", file_get_contents('input1.csv'));

echo "<link href='styles.css' rel='stylesheet' />";

$formatedInputAsArray = [];
foreach ($input as $line) {
    $formatedInputAsArray[] = explode(";", $line);
}

$map = new Map($formatedInputAsArray);
echo 'Init map <br>';
$map->renderMap();
echo 'Execute adventurers movements <br><hr>';
$map->executeMoves();
echo 'Map after movements <br>';
$map->renderMap();
$map->renderMapAsFile();
