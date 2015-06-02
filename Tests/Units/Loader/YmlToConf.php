<?php
/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Conf\Tests\Units\Loader;

use atoum;
use \Solire\Conf\Loader\YmlToConf as TestClass;

/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class YmlToConf extends atoum
{
    protected $testLocal = TEST_DATA_DIR . '/local.yml';

    /**
     * Contrôle construct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->object(new TestClass($this->testLocal))
        ;
    }

    public function testLoadVars()
    {
        $this
            ->if($conf = new TestClass($this->testLocal))

            ->integer($conf->get('database', 'port'))
                ->isEqualTo(3306)
            ->integer($conf->database->port)
                ->isEqualTo(3306)
            ->integer($conf['database']['port'])
                ->isEqualTo(3306)
            ->object($conf->get('base'))
                ->isInstanceOf('\Solire\Conf\Conf')
            ->array((array) $conf->get('base'))
                ->isEqualTo(['url' => 'http://localhost/'])
            ->string($conf->get('test')->get('foo')->get('bar'))
                ->isEqualTo('foobar')
        ;
    }
}
