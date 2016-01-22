<?php

namespace Solire\Conf;

/**
 * Gestionnaire des fichiers de configurations
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
trait ProcessTrait
{
    /**
     * Applique les processus demandé à la configuration
     *
     * @param array             $processList Liste des processus à jouer
     * @param \Solire\Conf\Conf $conf        Configuration a éditer
     * @return type
     */
    public function applyProcess(array $processList, Conf $conf)
    {
        foreach ($processList as $process) {
            $callBack = array_shift($process);
            if (is_callable($callBack) === false) {
                throw new Exception('callback is not callable');
            }

            call_user_func(
                $callBack,
                $conf,
                $process
            );
        }

        return $this;
    }
}
