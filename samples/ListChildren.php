<?php
require(dirname(__FILE__) . '/../library/SSRS/Report.php');

try {
    $options = array(
        'username' => 'testing',
        'password' => 'password',
    );

    $ssrs = new SSRS_Report('http://localhost/reportserver/', $options);
    $result = $ssrs->listChildren('/Reports', true);

//    print_r($result);

    foreach($result->CatalogItems AS $item){
    	echo $item->Name . ': ' . $item->Path . PHP_EOL;
    }

} catch (Exception $error) {
    echo 'Exception:' . PHP_EOL;
    print_r($error);
}
