<?php

namespace Solire\Conf;

use ArrayAccess;

/**
 * Gestionnaire de configuration
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Conf implements ConfigInterface, ArrayAccess
{

    /**
     * Renvoie toute la configuration
     *
     * @return mixed
     * @deprecated 2.0
     * @ignore
     */
    public function getAll()
    {
        return $this->get();
    }

    /**
     * Récupération directe d'une valeur
     *
     * @param string $name Nom de la variable
     *
     * @return mixed
     * @uses Solire\Conf\Conf::get()
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Ajoute une valeur à la configuration
     *
     * @param string $name  Nom de la valeur
     * @param mixed  $value Valeur à ajouter
     *
     * @return void
     * @uses Solire\Conf\Conf::set()
     * @ignore
     */
    public function __set($name, $value)
    {
        $this->set($value, $name);
    }

    /**
     * Getter via tableau
     *
     * @param mixed $offset Nom du champ
     *
     * @return boolean
     * @uses Solire\Conf\Conf::get()
     * @ignore
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Setter via tableau
     *
     * @param mixed $offset Nom du champ
     * @param mixed $value  Valeur
     *
     * @return boolean
     * @uses Solire\Conf\Conf::set()
     * @ignore
     */
    public function offsetSet($offset, $value)
    {
        $this->set($value, $offset);
    }

    /**
     * Unsset via tableau
     *
     * @param mixed $offset Nom du champ
     *
     * @return void
     * @uses Solire\Conf\Conf::kill()
     * @ignore
     */
    public function offsetUnset($offset)
    {
        $this->kill($offset);
    }

    /**
     * Isset via tableau
     *
     * @param mixed $offset Nom du champ
     *
     * @return boolean
     * @uses Solire\Conf\Conf::exists()
     * @ignore
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Renvoie la valeur d'un parametre de configuration
     *
     * @param string $names Noms de sections
     *
     * @return mixed null si aucune configuration ne répond aux critères
     */
    public function get(...$names)
    {
        $data = $this;
        foreach ($names as $name) {
            if (!isset($data->{$name})) {
                return null;
            }
            $data = $data->{$name};
        }
        return $data;
    }

    /**
     * Enregistre la valeur
     *
     * @param mixed  $value Valeur à mettre dans la configuration
     * @param string $names Noms de sections
     *
     * @return self
     */
    public function set($value, ...$names)
    {
        $data = $this;
        foreach ($names as $count => $name) {
            if ($count == count($names) - 1) {
                $data->{$name} = $value;
                break;
            }

            if (!isset($data->{$name})) {
                $data->{$name} = new self();
            }
            $data = $data->{$name};
        }

        return $this;
    }

    /**
     * Supprime un parametre de configuration
     *
     * @param string $names Noms de sections
     *
     * @return self
     */
    public function kill(...$names)
    {
        $data = $this;
        foreach ($names as $count => $name) {
            if (!isset($data->{$name})) {
                return $this;
            }

            if ($count == count($names) - 1) {
                unset($data->{$name});
                break;
            }

            $data = $data->{$name};
        }

        return $this;
    }

    /**
     * Vérifie si une valeur est présente dans la configuration
     *
     * @param string $names Nom du champs
     *
     * @return boolean
     */
    public function has(...$names)
    {
        $data = $this;
        foreach ($names as $name) {
            if (!isset($data->{$name})) {
                return false;
            }

            $data = $data->{$name};
        }

        return true;
    }

    /**
     * Récupération des paramètres du même niveau
     *
     * @param string $names Noms de sections
     *
     * @return array
     */
    public function each(...$names)
    {
        $data = $this;
        foreach ($names as $name) {
            if (!isset($data->{$name})) {
                return [];
            }
            $data = $data->{$name};
        }

        return get_object_vars($data);
    }
}
