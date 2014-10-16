<?php

namespace Solire\Conf;

/**
 * Interface des classes de configuration
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
interface ConfigInterface
{
    /**
     * Renvoie la valeur d'un parametre de configuration
     *
     * @param string $names Noms de sections
     *
     * @return mixed null si aucune configuration ne répond aux critères
     */
    public function get(...$names);

    /**
     * Enregistre la valeur
     *
     * @param mixed  $value Valeur à mettre dans la configuration
     * @param string $names Noms de sections
     *
     * @return self
     */
    public function set($value, ...$names);

    /**
     * Supprime un parametre de configuration
     *
     * @param string $names Noms de sections
     *
     * @return self
     */
    public function kill(...$names);

    /**
     * Vérifie si une valeur est présente dans la configuration
     *
     * @param string $names Nom du champs
     *
     * @return boolean
     */
    public function has(...$names);

    /**
     * Récupération des paramètres du même niveau
     *
     * @param string $names Noms de sections
     *
     * @return array
     */
    public function each(...$names);

    /**
     * Renvois la valeur d'un parametre de configuration
     *
     * @param string $name Nom du parametre
     *
     * @return mixed
     */
    public function __get($name);
}
