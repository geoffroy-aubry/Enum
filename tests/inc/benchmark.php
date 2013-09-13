<?php

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/benchmark-fct.php';

use GAubry\Enum\Mocks\DayEnum;
use GAubry\Enum\Mocks\Days;

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
