<?php

namespace BadFaith\Tests;

use BadFaith\ItemContainer;

/**
 * @covers BadFaith\ItemContainer
 */
class ItemContainerTest extends \PHPUnit_Framework_TestCase
{
    public function itemProvider()
    {
        return array(
            array(
                array('one', 'two', 'three'), array('one' => 1, 'three' => 0.5, 'two' => 0.8)
              , array('one', 'two', 'three'), array('three' => 0.3, 'one' => 0.5, 'two' => 0.5)
            )
        );
    }

    /**
     * @dataProvider itemProvider
     */
    public function testExpectedOrder($expected, $given)
    {
        $container = new ItemContainer;
        foreach ($given as $key => $q) {
            $container->insert(new ItemStub($key, $q));
        }

        $this->assertEquals(count($expected), $container->count());

        $i = 0;
        foreach ($container as $item) {
            $this->assertEquals($expected[$i++], $item->getPref());
        }
    }
}
