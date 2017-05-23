<?php

namespace Solire\Conf\Loader;

use Solire\Conf\Conf;
use Solire\Conf\ConfigInterface;
use Solire\Conf\Exception;
use Solire\Conf\ProcessTrait;

/**
 * Chargement d'une configuration à partir d'un fichier .ini
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class YmlToConf extends ArrayToConf implements ConfigInterface
{
    /**
     * Charge un nouveau fichier de configuration
     *
     * @param string $yamlPath Chemin vers le fichier de configuration
     * @throws Exception si le yml est mal formaté
     */
    public function __construct($yamlPath)
    {
        $data = $this->yamlParseFile($yamlPath);

        if ($data === false) {
            throw new Exception('yml malformed');
        }

        $this->arrayConvert($this, $data);
    }

    private function yamlParseFile($yamlPath)
    {
        if (function_exists('yaml_parse_file')) {
            return yaml_parse_file($yamlPath);
        }

        if (class_exists('Symfony\Component\Yaml\Yaml')) {
            return \Symfony\Component\Yaml\Yaml::parse(file_get_contents($yamlPath));
        }

        throw new Exception('No function defined to parse yml file');
    }
}
