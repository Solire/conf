<?php

use \mageekguy\atoum;

$report = $script->addDefaultReport();

// This will add a green or red logo after each run depending on its status.
$report->addField(new atoum\report\fields\runner\result\logo());

define('DIR_BUILD_COVERAGE', __DIR__ . '/../build/html');
if (!is_dir(DIR_BUILD_COVERAGE)) {
    mkdir(DIR_BUILD_COVERAGE);
}
$coverageField = new atoum\report\fields\runner\coverage\html('Slrfw', DIR_BUILD_COVERAGE);
$report->addField($coverageField);

// Chargement du fichier bootstrap
$runner->setBootstrapFile(dirname(__FILE__) . '/.bootstrap.atoum.php');


