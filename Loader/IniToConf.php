<?php

namespace Solire\Conf\Loader;

use Solire\Conf\Conf;
use Solire\Conf\ConfigInterface;
use Solire\Conf\Process\ParseVar;

/**
 * Chargement d'une configuration à partir d'un fichier .ini
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class IniToConf extends Conf implements ConfigInterface
{
    /**
     * Charge un nouveau fichier de configuration
     *
     * @param string $iniPath Chemin vers le fichier de configuration
     * @param $procze $name Description
     */

    /**
     * Charge un nouveau fichier de configuration
     *
     * @param type $iniPath Chemin vers le fichier de configuration
     * @param type $process Doit-on effectuer le process de remplacement
     * de variable
     */
    public function __construct($iniPath, $process = false)
    {
        $confData = parse_ini_file($iniPath, true);

        foreach ($confData as $sectionName => $sectionValue) {
            foreach ($sectionValue as $name => $value) {
                $this->set($value, $sectionName, $name);
            }
        }

        if ($process) {
            $processList = [
                [[ParseVar::class, 'run']],
            ];

            $this->applyProcess($processList, $this);
        }
    }
}
