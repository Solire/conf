<?php

namespace Solire\Conf;

use Solire\Conf\Loader\ArrayToConf;
use Solire\Conf\Loader\IniToConf;
use Solire\Conf\Loader\YmlToConf;
use Solire\Conf\Process\Merge;
use Solire\Conf\Process\ParseVar;

/**
 * Créateur de Conf
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Loader
{
    use ProcessTrait;

    protected static $processList = [
        [[ParseVar::class, 'run']],
    ];

    /**
     * Charge un objet Conf depuis chaque données passées en les surchargeant
     *
     * @param array $dataArray Tableau de données sous forme de tableau ou
     * chemin vers un fichier contenant les informations de la config
     *
     * @return Conf
     */
    public static function load(... $dataArray)
    {
        $conf = new Conf();
        foreach ($dataArray as $data) {
            Merge::run($conf, self::loadOne($data));
        }

        self::applyProcess(static::$processList, $conf);
        return $conf;
    }

    /**
     * Charge un objet Conf depuis les données passées
     *
     * @param array|string $data Données sous forme de tableau ou chemin vers un
     * fichier contenant les informations de la config
     *
     * @return Conf
     * @throws Exception Si $data n'est pas exploitable
     */
    private static function loadOne($data)
    {
        if (is_a($data, Conf::class)) {
            return $data;
        }

        if (is_array($data)) {
            return new ArrayToConf($data);
        }

        if (file_exists($data)) {
            switch (strtolower(pathinfo($data, PATHINFO_EXTENSION))) {
                case 'yml':
                case 'yaml':
                    return new YmlToConf($data);

                case 'ini':
                    return new IniToConf($data);
            }
        }

        throw new Exception('Aucune données exploitable pour charger une Conf');
    }
}
