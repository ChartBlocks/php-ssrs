<?php

require(__DIR__ . '/../vendor/autoload.php');

$options = array(
    'username' => 'testing',
    'password' => 'password'
);

$ssrs = new \SSRS\Report('http://localhost/reportserver/', $options);
$results = $ssrs->listRenderingExtensions();

echo '<table border="1" width="100%">';
echo '<tr>';
echo '<th>ExtensionType</th>';
echo '<th>Name</th>';
echo '<th>LocalisedName</th>';
echo '<th>Visible</th>';
echo '<th>IsModelGenerationSupported</th>';
echo '</tr>';
foreach ($results->Extensions->Extension as $extension) {
    $extension->Visible = (empty($extension->Visible)) ? "Null" : $extension->Visible;
    $extension->IsModelGenerationSupported = (empty($extension->IsModelGenerationSupported)) ? "Null" : $extension->IsModelGenerationSupported;

    echo '<tr>';
    echo '<td>' . $extension->ExtensionType . '</td>';
    echo '<td>' . $extension->Name . '</td>';
    echo '<td>' . $extension->LocalizedName . '</td>';
    echo '<td>' . $extension->Visible . '</td>';
    echo '<td>' . $extension->IsModelGenerationSupported . '</td>';
    echo '</tr>';
}
echo '</table>';