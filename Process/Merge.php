<?php

namespace Solire\Conf\Process;

use Solire\Conf\Conf;

/**
 * Merge de deux configurations
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Merge
{
    /**
     * Ajoute $confTwo dans $conf
     *
     * @param Conf $conf    Configuration recevant les données
     * @param Conf $confTwo Configuration qui sera ajouté à $conf
     *
     * @return void
     */
    public static function run(Conf $conf, Conf $confTwo)
    {
        self::each($conf, $confTwo);
    }

    /**
     * Parcours $conTwo pour alimenter $conf
     *
     * @param Conf $conf    Configuration alimentée
     * @param Conf $confTwo Configuration parcourue
     *
     * @return void
     */
    protected static function each(Conf $conf, Conf $confTwo)
    {
        foreach ($confTwo->each() as $key => $data) {
            if ($conf->has($key) === false) {
                $conf->set($data, $key);
                continue;
            }

            if (gettype($conf->get($key)) !== 'object') {
                $conf->set($data, $key);
                continue;
            }

            if (is_a($conf->get($key), 'Solire\Conf\Conf') === true) {
                if (is_a($data, 'Solire\Conf\Conf') === true) {
                    self::each($conf->get($key), $data);
                    continue;
                }

                continue;
            }

            $conf->set($data, $key);
        }
    }
}
