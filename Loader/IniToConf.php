<?php

namespace Solire\Conf\Loader;

use Solire\Conf\Conf;
use Solire\Conf\ConfigInterface;
use Solire\Conf\ProcessTrait;

/**
 * Chargement d'une configuration à partir d'un fichier .ini
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class IniToConf extends Conf implements ConfigInterface
{
    use ProcessTrait;

    /**
     * Charge un nouveau fichier de configuration
     *
     * @param string $iniPath Chemin vers le fichier de configuration
     */
    public function __construct($iniPath)
    {
        $confData = parse_ini_file($iniPath, true);

        foreach ($confData as $sectionName => $sectionValue) {
            foreach ($sectionValue as $name => $value) {
                $this->set($value, $sectionName, $name);
            }
        }

        $processList = [
            [['\Solire\Conf\Process\ParseVar', 'run']],
        ];

        $this->applyProcess($processList, $this);
    }
}
