<?php

namespace Solire\Conf\Process;

use Solire\Conf\Conf;

/**
 * Utilisation des variables dans les configurations
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class ParseVar
{
    /**
     * Délimiteur d'entrée des variables
     */
    const START_VAR = '{%';

    /**
     * Délimiteur de fin des variables
     */
    const END_VAR = '}';

    /**
     * Séparateur des sections
     */
    const DELIMITER = ':';


    /**
     * Remplace les noms des variables par leurs valeurs
     *
     * @param Solire\Conf\Conf $conf Configuration dans laquelle parser les variables
     *
     * @return void
     */
    public static function run(Conf $conf)
    {
        self::parseVar($conf);
    }

    /**
     * Remplace les noms des variables par leurs valeurs
     *
     * @param Solire\Conf\Conf $conf Configuration dans laquelle parser les variables
     */
    private static function parseVar(Conf $conf)
    {
        foreach ($conf as $key => $value) {
            if (is_object($value)) {
                self::parseVar($value);
                continue;
            }
            if (
                strpos($value, self::START_VAR) === false
                || strpos($value, self::END_VAR) === false
            ) {
                continue;
            }

            $pattern = '/(?<=' . preg_quote(self::START_VAR) . ')'
                     . '(?<selector>[a-zA-Z0-9:]+)'
                     . '(?=' . preg_quote(self::END_VAR) . ')/'
            ;
            preg_match_all($pattern, $value, $matchs);

            foreach ($matchs['selector'] as $selector) {
                $varSelector = explode(self::DELIMITER, $selector);
                $target = self::START_VAR . $selector . self::END_VAR;
                $value = str_replace($target, $conf->get(...$varSelector), $value);
                $conf->set($value, $key);
            }
        }
    }
}
