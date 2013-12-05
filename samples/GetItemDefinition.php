<?php

require(__DIR__ . '/../vendor/autoload.php');

$options = array(
    'username' => 'testing',
    'password' => 'password'
);

$ssrs = new \SSRS\Report('http://localhost/reportserver/', $options);

$ItemPath = '/Reports/Reference_Report';
$result = $ssrs->getItemDefinition($ItemPath);

header('Content-Type:text/xml');
echo $result;
