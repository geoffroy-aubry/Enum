<?php

namespace GAubry\Enum\Tests;

use GAubry\Enum\Mocks\ColorEnum;
use GAubry\Enum\Mocks\DayEnum;
use GAubry\Enum\EnumAbstract;

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

    /**
     * @covers \GAubry\Enum\EnumAbstract::keys
     */
    public function testKeys ()
    {
        $aKeys = ColorEnum::keys();
        $aExpected = array('RED', 'GREEN', 'BLUE');
        $this->assertEquals($aExpected, $aKeys);

        $aKeys = DayEnum::keys();
        $aExpected = array('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY');
        $this->assertEquals($aExpected, $aKeys);
    }

    public function testKeysThrowExceptionOnAbstractCall ()
    {
        $this->setExpectedException(
            '\\BadMethodCallException',
            'Method for only purpose of inherited classes!'
        );
        $aKeys = EnumAbstract::keys();
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::values
     */
    public function testValues ()
    {
        DayEnum::values();
        $aValues = DayEnum::values();

        $aKeys = array_keys($aValues);
        $aExpectedKeys = array('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY');
        $this->assertEquals($aExpectedKeys, $aKeys);

        $aInstances = array();
        foreach ($aValues as $sKey => $oEnum) {
            $this->assertInstanceOf('\GAubry\Enum\Mocks\DayEnum', $oEnum);
            $this->assertArrayNotHasKey(serialize($oEnum), $aInstances);
            $aInstances[] = serialize($oEnum);
        }
    }

    public function testValuesThrowExceptionOnAbstractCall ()
    {
        $this->setExpectedException(
            '\\BadMethodCallException',
            'Method for only purpose of inherited classes!'
        );
        $aKeys = EnumAbstract::values();
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::__toString
     */
    public function testToString ()
    {
        DayEnum::values();
        $this->assertEquals('MONDAY', (string)DayEnum::$MONDAY);
        $this->assertEquals('TUESDAY', (string)DayEnum::$WEDNESDAY);
        $this->assertTrue((string)DayEnum::$THURSDAY === (string)1);
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::buildInstances
     * @covers \GAubry\Enum\EnumAbstract::__construct
     */
    public function testBuildInstances ()
    {
        $sClass = DayEnum::buildInstances();
        $this->assertEquals('GAubry\Enum\Mocks\DayEnum', $sClass);

        $oProperty = new \ReflectionProperty('\GAubry\Enum\EnumAbstract', 'aCache');
        $oProperty->setAccessible(true);
        $aAllValues = $oProperty->getValue();
        $this->assertEquals(array($sClass), array_keys($aAllValues));

        $aInstances = array();
        $aValues = $aAllValues[$sClass];
        foreach ($aValues as $sKey => $oEnum) {
            $this->assertInstanceOf($sClass, $oEnum);
            $this->assertArrayNotHasKey(serialize($oEnum), $aInstances);
            $aInstances[] = serialize($oEnum);
        }

        $oProperty = new \ReflectionProperty('\GAubry\Enum\EnumAbstract', 'iValue');
        $oProperty->setAccessible(true);
        $this->assertEquals(0, $oProperty->getValue($aValues['MONDAY']));
        $this->assertEquals(1, $oProperty->getValue($aValues['TUESDAY']));

        $oProperty = new \ReflectionProperty('\GAubry\Enum\EnumAbstract', 'sName');
        $oProperty->setAccessible(true);
        $this->assertEquals('MONDAY', $oProperty->getValue($aValues['MONDAY']));
        $this->assertEquals('TUESDAY', $oProperty->getValue($aValues['WEDNESDAY']));
        $this->assertTrue($oProperty->getValue($aValues['THURSDAY']) === (string)1);
    }

    public function testBuildInstancesThrowExceptionOnAbstractCall ()
    {
        $this->setExpectedException(
            '\\BadMethodCallException',
            'Method for only purpose of inherited classes!'
        );
        $aKeys = EnumAbstract::buildInstances();
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::values
     */
    public function testIdentity ()
    {
        ColorEnum::values();
        $aDays = DayEnum::values();
        foreach ($aDays as $sKey1 => $oEnum1) {
            foreach ($aDays as $sKey2 => $oEnum2) {
                $this->assertTrue($sKey1 != $sKey2 || $oEnum1 === $oEnum2);
            }
        }
    }

    public function testEnumConstantsBeforeBuild ()
    {
        $aDays = array(
            'MONDAY' => null,
            'TUESDAY' => null,
            'WEDNESDAY' => 'TUESDAY',
            'THURSDAY' => 1,
            'FRIDAY' => null,
            'SATURDAY' => null,
            'SUNDAY' => null,
        );
        foreach ($aDays as $sDay => $mValue) {
            $this->assertTrue(DayEnum::$$sDay === $mValue);
        }
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::buildInstances
     */
    public function testEnumConstantsAfterBuild ()
    {
        $aDays = array(
            'MONDAY' => null,
            'TUESDAY' => null,
            'WEDNESDAY' => 'TUESDAY',
            'THURSDAY' => 1,
            'FRIDAY' => null,
            'SATURDAY' => null,
            'SUNDAY' => null,
        );
        DayEnum::buildInstances();
        foreach ($aDays as $sDay => $mValue) {
            $this->assertInstanceOf('GAubry\Enum\Mocks\DayEnum', DayEnum::$$sDay);
            $this->assertTrue((string)DayEnum::$$sDay === ($mValue === null ? $sDay : (string)$mValue));
        }
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::__callStatic
     */
    public function testCallStaticThrowExceptionOnAbstractCall ()
    {
        $this->setExpectedException(
            '\\BadMethodCallException',
            'Method for only purpose of inherited classes!'
        );
        EnumAbstract::ANY();
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::__callStatic
     */
    public function testCallStaticThrowExceptionWhenUndefined ()
    {
        $this->setExpectedException(
            '\\DomainException',
            "Unknown type 'NOTDEFINED'!"
                . ' Type must be in: MONDAY, TUESDAY, WEDNESDAY, THURSDAY, FRIDAY, SATURDAY, SUNDAY.'
        );
        DayEnum::NOTDEFINED();
    }

    /**
     * @covers \GAubry\Enum\EnumAbstract::__callStatic
     */
    public function testCallStaticWithoutBuild ()
    {
        $aDays = array(
            'MONDAY' => null,
            'TUESDAY' => null,
            'WEDNESDAY' => 'TUESDAY',
            'THURSDAY' => 1,
            'FRIDAY' => null,
            'SATURDAY' => null,
            'SUNDAY' => null,
        );
        foreach ($aDays as $sDay => $mValue) {
            $this->assertInstanceOf('GAubry\Enum\Mocks\DayEnum', DayEnum::$sDay());
            $this->assertTrue((string)DayEnum::$sDay() === ($mValue === null ? $sDay : (string)$mValue));
        }
    }
}
