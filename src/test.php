<?php

require __DIR__ . '/../vendor/autoload.php';

use GAubry\Enum\Intervals;

// var_dump(Intervals::$YEAR);
// var_dump(Intervals::$MONTH);
// var_dump(Intervals::values());
// var_dump(Intervals::values());
// var_dump(Intervals::$YEAR);
// var_dump('(string) ' . Intervals::$YEAR);
// var_dump('(string) ' . Intervals::$MONTH);
// var_dump(Intervals::$YEAR == Intervals::$MONTH);
// var_dump(Intervals::$YEAR === Intervals::$MONTH);

Intervals::buildInstances();
var_dump(Intervals::$YEAR);
var_dump(Intervals::YEAR());
var_dump(Intervals::$YEAR);
