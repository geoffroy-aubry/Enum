<?php

namespace GAubry\Enum\Tests;

use GAubry\Enum\Mocks\ColorEnum;

class EnumAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp ()
    {
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
    }

    public function testKeys ()
    {
        $aKeys = ColorEnum::keys();
        $aExpected = array('RED', 'GREEN', 'BLUE');
        $this->assertEquals($aExpected, $aKeys);
    }
}
