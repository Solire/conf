<?php
/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */

namespace Solire\Conf\Tests\Units;

use atoum;
use \Solire\Conf\Conf as TestClass;

/**
 * Test class for formulaire.
 *
 * @author  Adrien <aimbert@solire.fr>
 * @license MIT http://mit-license.org/
 */
class Conf extends atoum
{
    /**
     * Contrôle construct
     *
     * @return void
     */
    public function testConstruct()
    {
        $this
            ->object(new TestClass())
            ->class('\Solire\Conf\Conf')
                ->hasInterface('\Solire\Conf\ConfigInterface')
                ->hasInterface('\ArrayAccess')
        ;
    }

    /**
     * Contrôle des getters & setters
     *
     * @return void
     */
    public function testSetters()
    {
        $this
            ->if($conf = new TestClass())
            ->object($conf->set(1, 'section1', 'name1'))
                ->isIdenticalTo($conf)
            ->dump($conf)
            ->integer($conf->get('section1', 'name1'))
                ->isEqualTo(1)
            ->object($conf->set(3, 'section1'))
                ->isIdenticalTo($conf)
            ->integer($conf->get('section1'))
                ->isEqualTo(3)
            ->integer($conf->section1)
                ->isEqualTo(3)
            ->variable($conf->section8)
                ->isNull()
            ->object($conf->set('toto', 'section2'))
                ->isIdenticalTo($conf)
            ->string($conf->get('section2'))
                ->isEqualTo('toto')
            ->string($conf->section2)
                ->isEqualTo('toto')
        ;
    }

    /**
     * Contrôle supression d'un élément
     *
     * @return void
     */
    public function testKill()
    {
        $this
            ->if($conf = new TestClass())
            ->and($conf->set(1, 'section1', 'name1'))
            ->and($conf->set(2, 'section1', 'name2'))
            ->and($conf->set('toto', 'stringSection'))
            ->object($conf->kill('section1', 'name1'))
                ->isIdenticalTo($conf)
            ->variable($conf->get('section1', 'name1'))
                ->isNull()
            ->integer($conf->get('section1', 'name2'))
                ->isEqualTo(2)
            ->object($conf->getAll())
                ->isIdenticalTo($conf)
            ->object($conf->get())
                ->isIdenticalTo($conf)
            ->object($conf->kill('section1'))
                ->isIdenticalTo($conf)
            ->object($conf->kill('section8'))
                ->isIdenticalTo($conf)
            ->if($bar = new \Solire\Conf\Conf())
                ->and($bar->stringSection = 'toto')
            ->object($conf->getAll())
                ->isEqualTo($bar)
        ;
    }

    /**
     * Contrôle supression d'un élément
     *
     * @return void
     */
    public function testHas()
    {
        $this
            ->if($conf = new TestClass())
            ->boolean($conf->has('fuu'))
                ->isFalse()
            ->and($conf->set(1, 'section1', 'name1'))
            ->and($conf->set(2, 'section1', 'name2'))
            ->and($conf->set('toto', 'stringSection'))
            ->boolean($conf->has('section1', 'name1'))
                ->isTrue()
            ->boolean($conf->has('section1'))
                ->isTrue()
            ->boolean($conf->has('section1', 'name1', 'subName1'))
                ->isFalse()
        ;
    }

    /**
     * Utilisation de la configuration comme un tableau
     *
     * @tags array
     */
    public function testArrayUsage()
    {
        $this
            ->if($conf = new TestClass())
            ->boolean(isset($conf['fuu']))
                ->isFalse()
            ->and($conf->set(1, 'section1', 'name1'))
            ->and($conf->set(2, 'section1', 'name2'))
            ->and($conf->set('toto', 'stringSection'))
            ->boolean(isset($conf['section1']))
                ->isTrue()
            ->string($conf['stringSection'])
                ->isEqualTo('toto')
            ->when(function () use ($conf) {
                unset($conf['stringSection']);
            })
            ->boolean(isset($conf['stringSection']))
                ->isFalse()
            ->if($conf['stringSection'] = 'blabla')
            ->boolean(isset($conf['stringSection']))
                ->isTrue()
            ->string($conf['stringSection'])
                ->isEqualTo('blabla')
        ;
    }

    /**
     * Contrôle parcour d'éléments
     *
     * @return void
     */
    public function testEach()
    {
        $this
            ->if($conf = new TestClass())
            ->and($conf->set(1, 'section1', 'name1'))
            ->and($conf->set(2, 'section1', 'name2'))
            ->and($conf->set('toto', 'stringSection'))
            ->array($conf->each())
                ->isEqualTo(['section1' => $conf->get('section1'), 'stringSection' => 'toto'])
            ->array($conf->each('section1'))
                ->isEqualTo(['name1' => 1, 'name2' => 2])
            ->array($conf->each('nonPresent'))
                ->isEqualTo([])
        ;
    }
}
