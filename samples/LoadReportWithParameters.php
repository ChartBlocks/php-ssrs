<?php

require(__DIR__ . '/../vendor/autoload.php');

$options = array(
    'username' => 'testing',
    'password' => 'password'
);

$ssrs = new \SSRS\Report('http://localhost/reportserver/', $options);
$result = $ssrs->loadReport('/Reports/Reference_Report');

$reportParameters = array(
    'test' => '1'
);

$parameters = new SSRS_Object_ExecutionParameters($reportParameters);

$ssrs->setSessionId($result->executionInfo->ExecutionID)
        ->setExecutionParameters($parameters);

$output = $ssrs->render('HTML4.0'); // PDF | XML | CSV
echo $output;
