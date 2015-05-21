<?php
/**
 * Test class for Merge.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Conf\Tests\Units\Process;

use atoum;
use \Solire\Conf\Process\Merge as TestClass;
use \Solire\Conf\Conf as Conf;

/**
 * Test class for Merge.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Merge extends atoum
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
            ->and($conf->set('varConf', 'sectionConf', 'name'))
            ->and($conf->set('toto', 'stringSection'))
            ->and($conf->set('toto', 'stringSectionSec'))
            ->and($conf->set(new \stdClass(), 'object'))
            ->if($confTwo = new Conf())
            ->and($confTwo->set('varName1TWO', 'section1', 'name1'))
            ->and($confTwo->set('varTestTWO', 'sectionTest', 'name1'))
            ->and($confTwo->set('totoTWO', 'stringSection'))
            ->and($confTwo->set('messageTWO', 'newSection'))
            ->and($confTwo->set('osefVar', 'sectionConf'))
            ->and($confTwo->set('replaceObject', 'object'))
            ->if(call_user_func(['\Solire\Conf\Process\Merge', 'run'], $conf, $confTwo))

            ->string($conf->get('section1', 'name1'))
                ->isEqualTo('varName1TWO')
            ->string($conf->get('stringSection'))
                ->isEqualTo('totoTWO')
            ->string($conf->get('stringSectionSec'))
                ->isEqualTo('toto')
            ->string($conf->get('sectionTest', 'name1'))
                ->isEqualTo('varTestTWO')
            ->string($conf->get('object'))
                ->isEqualTo('replaceObject')
            ->object($conf->get('sectionConf'))
                ->isInstanceOf('\Solire\Conf\Conf')
        ;
    }
}
