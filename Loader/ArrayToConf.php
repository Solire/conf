<?php

namespace Solire\Conf\Loader;

use Solire\Conf\Conf;
use Solire\Conf\ConfigInterface;

/**
 * Chargement d'une configuration à partir d'un tableau
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class ArrayToConf extends Conf implements ConfigInterface
{
    /**
     * Chargement d'une configuration à partir d'un tableau
     *
     * @param array $data Données de la configuration
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->arrayConvert($this, $data);
    }

    /**
     * Parcour le tableau pour récupérer les données
     *
     * @param Conf|null $conf Configuration dans laquelle mettre les données
     * @param array     $data Données à ajouter dans la configuration
     *
     * @return Conf
     */
    protected function arrayConvert($conf, $data)
    {
        if ($conf === null) {
            $conf = new Conf;
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $conf->set($this->arrayConvert(null, $value), $key);
                continue;
            }

            $conf->set($value, $key);
        }
        return $conf;
    }
}
