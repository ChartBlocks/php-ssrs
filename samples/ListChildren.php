<?php

require(__DIR__ . '/../vendor/autoload.php');

$options = array(
    'username' => 'testing',
    'password' => 'password',
);

$ssrs = new \SSRS\Report('http://localhost/reportserver/', $options);
$result = $ssrs->listChildren('/Reports', true);

foreach ($result->CatalogItems AS $item) {
    echo $item->Name . ': ' . $item->Path . PHP_EOL;
}