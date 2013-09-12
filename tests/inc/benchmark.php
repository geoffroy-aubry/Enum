<?php

require __DIR__ . '/bootstrap.php';

use GAubry\Enum\Mocks\DayEnum;

/**
 * Classic constant class.
 */
abstract class Days
{
    const MONDAY = 'MONDAY';
    const TUESDAY = 'TUESDAY';
    const WEDNESDAY = 'WEDNESDAY';
    const THURSDAY = 'THURSDAY';
    const FRIDAY = 'FRIDAY';
    const SATURDAY = 'SATURDAY';
    const SUNDAY = 'SUNDAY';
}

/**
 * User fonction using EnumAbstract magic static calls.
 *
 * @param DayEnum $oEnum
 * @return int
 */
function enumStaticCalls (DayEnum $oEnum)
{
    switch($oEnum) {
        case DayEnum::MONDAY():  $v = 1; break;
        case DayEnum::TUESDAY(): $v = 2; break;
        case DayEnum::FRIDAY():  $v = 5; break;
        default:                 $v = -1;
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
        case DayEnum::$MONDAY:  $v = 1; break;
        case DayEnum::$TUESDAY: $v = 2; break;
        case DayEnum::$FRIDAY:  $v = 5; break;
        default:                $v = -1;
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
        case Days::MONDAY:  $v = 1; break;
        case Days::TUESDAY: $v = 2; break;
        case Days::FRIDAY:  $v = 5; break;
        default:            $v = -1;
    }
    return $v;
}

$N = $argv[1];

// DayEnum::buildInstances()
// ==> ×1 in 0,4 ms
$fT0 = microtime(true);
DayEnum::buildInstances();
$fT1 = microtime(true);
echo round(($fT1 - $fT0)*1000, 3) . ';';


// DayEnum with magic static calls:
// ==> 100 times in 3,5 ms
$fT0 = microtime(true);
for ($i=0; $i<$N; $i++) {
    $oEnum = DayEnum::FRIDAY();
    enumStaticCalls($oEnum);
}
$fT1 = microtime(true);
echo round(($fT1 - $fT0)*1000, 3) . ';';


// DayEnum with constants:
// ==> 100 times in 0,4 ms
$fT0 = microtime(true);
for ($i=0; $i<$N; $i++) {
    $oEnum = DayEnum::$FRIDAY;
    enumConstants($oEnum);
}
$fT1 = microtime(true);
echo round(($fT1 - $fT0)*1000, 3) . ';';


// With classic constants:
// ==> 100 times in 0,3 ms
$fT0 = microtime(true);
for ($i=0; $i<$N; $i++) {
    $sEnum = Days::FRIDAY;
    classicConstants($sEnum);
}
$fT1 = microtime(true);
echo round(($fT1 - $fT0)*1000, 3) . PHP_EOL;
