<?php

require('../library/SSRS/Report.php');

$options = array(
    'username' => 'testing',
    'password' => 'password'
);

$ssrs = new SSRS_Report('http://localhost/reportserver/', $options);
$result = $ssrs->loadReport('/Reports/Reference_Report');

$reportParameters = array(
    'key1' => 'value1',
    'key2' => 'value2',
);

$parameters = new SSRS_Object_ExecutionParameters($reportParameters);

$ssrs->setSessionId($result->executionInfo->ExecutionID)
        ->setExecutionParameters($parameters);

$output = $ssrs->render('HTML4.0'); // PDF | XML | CSV
echo $output;