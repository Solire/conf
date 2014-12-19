<?php
/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Conf\Tests\Units\Process;

use atoum;
use \Solire\Conf\Process\ParseVar as TestClass;
use \Solire\Conf\Conf as Conf;

/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class ParseVar extends atoum
{
    /**
     * Contrôle construct
     *
     * @return void
     */
    public function testParseVar()
    {
        $this
            ->if($conf = new Conf())
            ->and($conf->set('varName1', 'section1', 'name1'))
            ->and($conf->set('{%name1}', 'section1', 'name2'))
            ->and($conf->set('toto', 'stringSection'))
            ->and($conf->set('{%section1:name2} et {%stringSection}', 'toto', 'foo', 'bar'))
            ->if(call_user_func(['\Solire\Conf\Process\ParseVar', 'run'], $conf))

            ->string($conf->get('section1', 'name2'))
                ->isEqualTo('varName1')
            ->string($conf->toto->foo->bar)
                ->isEqualTo('varName1 et toto')
        ;
    }
}
