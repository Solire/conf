<?php

namespace Solire\Conf\Tests\Units\Loader;

use atoum;
use \Solire\Conf\Loader\ArrayToConf as TestClass;

/**
 * Test class for ArrayToConf
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class ArrayToConf extends atoum
{
    /**
     * Contrôle construct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->object(new TestClass([]))
                ->class('\Solire\Conf\IniConfig')
                ->hasInterface('\Solire\Conf\ConfigInterface')
        ;
    }

    /**
     * Contrôle du chargement du tableau
     */
    public function testLoadVars()
    {
        $data = [
           'database' => [
               'name' => 'base',
               'port' => 3306,
            ],
            'base' => [
                'url' => 'http://localhost/',
            ]
        ];

        $this
            ->if($conf = new TestClass($data))

            ->integer($conf->get('database', 'port'))
                ->isEqualTo(3306)
            ->integer($conf->database->port)
                ->isEqualTo(3306)
            ->integer($conf['database']['port'])
                ->isEqualTo(3306)
            ->string($conf->get('database', 'name'))
                ->isEqualTo('base')
            ->string($conf->database->name)
                ->isEqualTo('base')
            ->string($conf['database']['name'])
                ->isEqualTo('base')
            ->object($conf->get('base'))
                ->class('\Solire\Conf\IniConfig')
            ->array((array) $conf->get('base'))
                ->isEqualTo(['url' => 'http://localhost/'])
        ;
    }
}
