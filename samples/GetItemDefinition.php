<?php

require('../library/SSRS/Report.php');

try {
    $options = array(
        'username' => 'testing',
        'password' => 'password'
    );

    $ssrs = new SSRS_Report('http://localhost/reportserver/', $options);

    $ItemPath = '/Reports/Reference_Report';

    $result = $ssrs->getItemDefinition($ItemPath);

    header('Content-Type:text/xml');
    echo $result;
} catch (Exception $error) {
    echo 'Exception:' . PHP_EOL;
    print_r($error);
}
?>
