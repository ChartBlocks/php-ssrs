<?php
require('../library/SSRS/Report.php');
include_once('Zend/Debug.php');
$options = array(
    'username' => 'CaymanUnreg',
    'password' => 'Gottex2011'
);

$ssrs = new SSRS_Report('http://212.203.112.85/reportserver/', $options);
$result = $ssrs->loadReport('/Off Shore/Cayman Weekly Risk');
Zend_Debug::dump($result);
//die();
$reportParameters = array(
    'managedaccount' => '1'
        );

$parameters = new SSRS_Object_ExecutionParameters($reportParameters);

$ssrs->setSessionId($result->executionInfo->ExecutionID)
        ->setExecutionParameters($parameters);

$output = $ssrs->render('HTML4.0'); // PDF | XML | CSV
echo $output;