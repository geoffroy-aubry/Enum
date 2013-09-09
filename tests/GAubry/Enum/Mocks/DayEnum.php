<?php

namespace GAubry\Enum\Mocks;

use GAubry\Enum\EnumAbstract;

class DayEnum extends EnumAbstract
{
    public static $MONDAY;
    public static $TUESDAY;
    public static $WEDNESDAY = 'TUESDAY';
    public static $THURSDAY = 1;
    public static $FRIDAY;
    public static $SATURDAY;
    public static $SUNDAY;
}
