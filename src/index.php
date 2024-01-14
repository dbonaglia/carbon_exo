<?php

use App\Map;

require '../vendor/autoload.php';

$input = explode("\r\n", file_get_contents('input.csv'));

$formatedInputAsArray = [];
foreach ($input as $line) {
    $formatedInputAsArray[] = explode(";", $line);
}

$map = new Map($formatedInputAsArray);
// $inputAdventurer = explode(';', explode("\r\n", file_get_contents('adventurer.csv'))[0]);
// $map->placeAdventurer($inputAdventurer);
$map->renderMap();
$map->executeMoves();
$map->renderMap();
