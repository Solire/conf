<?php

namespace Solire\Conf;

/**
 * Créateur de Conf
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Loader
{
    /**
     * Charge un objet Conf depuis les données passées
     *
     * @param array|string $data Données sous forme de tableau ou chemin vers un
     * fichier contenant les informations de la config
     * @return \Solire\Conf\Conf
     * @throws Exception Si $data n'est pas exploitable
     */
    public static function load($data)
    {
        if (is_array($data)) {
            return new Loader\ArrayToConf($data);
        }

        if (file_exists($data)) {
            switch (strtolower(pathinfo($data, PATHINFO_EXTENSION))) {
                case 'yml':
                case 'yaml':
                    return new Loader\YmlToConf($data);

                case 'ini':
                    return new Loader\IniToConf($data);
            }
        }

        throw new Exception('Aucune données exploitable pour charger une Conf');
    }
}
