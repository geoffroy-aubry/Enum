<?php

use GAubry\Enum\Mocks\DayEnum;
use GAubry\Enum\Mocks\Days;

/**
 * User fonction using EnumAbstract magic static calls.
 *
 * @param DayEnum $oEnum
 * @return int
 */
function enumStaticCalls (DayEnum $oEnum)
{
    switch($oEnum) {
        case DayEnum::MONDAY():
            $v = 1;
            break;
        case DayEnum::TUESDAY():
            $v = 2;
            break;
        case DayEnum::FRIDAY():
            $v = 5;
            break;
        default:
            $v = -1;
    }
    return $v;
}

/**
 * User fonction using EnumAbstract constants.
 *
 * @param DayEnum $oEnum
 * @return int
 */
function enumConstants (DayEnum $oEnum)
{
    switch($oEnum) {
        case DayEnum::$MONDAY:
            $v = 1;
            break;
        case DayEnum::$TUESDAY:
            $v = 2;
            break;
        case DayEnum::$FRIDAY:
            $v = 5;
            break;
        default:
            $v = -1;
    }
    return $v;
}

/**
 * User fonction using classic string constants.
 *
 * @param string $sEnum
 * @return int
 */
function classicConstants ($sEnum)
{
    switch($sEnum) {
        case Days::MONDAY:
            $v = 1;
            break;
        case Days::TUESDAY:
            $v = 2;
            break;
        case Days::FRIDAY:
            $v = 5;
            break;
        default:
            $v = -1;
    }
    return $v;
}
