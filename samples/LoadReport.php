<?php

require(__DIR__ . '/../vendor/autoload.php');

$options = array(
    'username' => 'testing',
    'password' => 'password'
);

$ssrs = new \SSRS\Report('http://localhost/reportserver/', $options);
$result = $ssrs->loadReport('/Reports/Reference_Report');

$ssrs->setSessionId($result->executionInfo->ExecutionID);

$output = $ssrs->render('HTML4.0'); // PDF | XML | CSV
echo $output;