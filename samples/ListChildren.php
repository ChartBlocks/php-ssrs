<?php

require(dirname(__FILE__) . '/../library/SSRS/Report.php');

$options = array(
    'username' => 'testing',
    'password' => 'password',
);

$ssrs = new SSRS_Report('http://localhost/reportserver/', $options);
$result = $ssrs->listChildren('/Reports', true);

foreach ($result->CatalogItems AS $item) {
    echo $item->Name . ': ' . $item->Path . PHP_EOL;
}