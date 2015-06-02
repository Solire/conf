<?php

namespace Solire\Conf\Tests\Units;

use atoum;
use \Solire\Conf\Loader as TestClass;
use Solire\Conf\Loader\ArrayToConf;
use Solire\Conf\Loader\IniToConf;
use Solire\Conf\Loader\YmlToConf;

/**
 * Test class for Loader
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Loader extends atoum
{
    protected $localIni = TEST_DATA_DIR . '/local.ini';
    protected $localYml = TEST_DATA_DIR . '/local.yml';

    /**
     * Contrôle des getters & setters
     *
     * @return void
     */
    public function testLoad()
    {
        $data = [
            'test' => 'plop',
            'foo' => [
                'bar' => 'foobar',
            ]
        ];
        $this
            ->if($conf = new ArrayToConf($data))
            ->object(TestClass::load($data))
                ->isEqualTo($conf)
            ->if($conf = new IniToConf($this->localIni))
            ->object(TestClass::load($this->localIni))
                ->isEqualTo($conf)
            ->if($conf = new YmlToConf($this->localYml))
            ->object(TestClass::load($this->localYml))
                ->isEqualTo($conf)

            ->exception(function () {
                TestClass::load('Data');
            })
                ->hasMessage('Aucune données exploitable pour charger une Conf')
                ->isInstanceOf('\Solire\Conf\Exception')
            ->exception(function () {
                TestClass::load(TEST_DATA_DIR . '/foo.falsext');
            })
                ->hasMessage('Aucune données exploitable pour charger une Conf')
                ->isInstanceOf('\Solire\Conf\Exception')
        ;
    }
}
