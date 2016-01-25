<?php

use \mageekguy\atoum;

$report = $script->addDefaultReport();

// This will add a green or red logo after each run depending on its status.
$report->addField(new atoum\report\fields\runner\result\logo());


if (!is_dir(__DIR__ . '/../coverage')) {
    mkdir(__DIR__ . '/../coverage');
}
$coverageField = new atoum\report\fields\runner\coverage\html('Slrfw', __DIR__ . '/../coverage');
$report->addField($coverageField);

// Chargement du fichier bootstrap
$runner->setBootstrapFile(dirname(__FILE__) . '/.bootstrap.atoum.php');


