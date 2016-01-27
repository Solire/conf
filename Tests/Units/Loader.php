<?php

namespace Solire\Conf\Tests\Units;

use atoum;
use Solire\Conf\Loader as TestClass;
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
        $confResult = new \Solire\Conf\Conf();
        $confResult
            ->set('plop', 'test')
            ->set('foobar', 'foo', 'bar')
        ;
        $this
            ->assert('$data est un un objet conf')
                ->object(TestClass::load($confResult))
                    ->isEqualTo($confResult)

            ->assert('$data est un tableau')
                ->object(TestClass::load($data))
                    ->isEqualTo($confResult)

            ->assert('$data est un chemin vers un .ini')
                ->if($confIniRef = new IniToConf($this->localIni))
                ->given($confIni = TestClass::load($this->localIni))
                ->object($confIni->get('database'))
                    ->isEqualTo($confIniRef->get('database'))

            ->assert('$data est un chemin vers un .yml')
                ->if($confYmlRef = new YmlToConf($this->localYml))
                ->given($confYml = TestClass::load($this->localYml))
                ->object($confYml->get('database'))
                    ->isEqualTo($confYmlRef->get('database'))

            ->assert('$data n\'est pas exploitable')
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

            ->assert('$data multiple')
                ->if($conf = TestClass::load($data, $this->localIni, $this->localYml))
                ->string($conf->database->host)
                    ->isEqualTo('localhost')
                ->string($conf->get('foo', 'bar'))
                    ->isEqualTo('foobar')
        ;
    }
}
