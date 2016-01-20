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
            ->if($conf1 = new ArrayToConf($data, true))
            ->object(TestClass::load($data))
                ->isEqualTo($conf1)
            ->if($conf2 = new IniToConf($this->localIni, true))
            ->object(TestClass::load($this->localIni))
                ->isEqualTo($conf2)
            ->if($conf3 = new YmlToConf($this->localYml, true))
            ->object(TestClass::load($this->localYml))
                ->isEqualTo($conf3)

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

            ->if($conf = TestClass::load($data, $this->localIni, $this->localYml))
                ->string($conf->database->host)
        ;
    }
}
