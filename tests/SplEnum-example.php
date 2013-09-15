<?php

/**
 * Test of SplEnum
 * http://php.net/manual/en/class.splenum.php
 *
 * $ sudo apt-get install libpcre3-dev
 * $ sudo pecl install SPL_Types
 * $ vi /etc/php5/cli/php.ini
 *     extension=spl_types.so
 *
 *
 *
 * Copyright (c) 2013 Geoffroy Aubry <geoffroy.aubry@free.fr>
 * Licensed under the GNU Lesser General Public License v3 (LGPL version 3).
 *
 * @copyright 2013 Geoffroy Aubry <geoffroy.aubry@free.fr>
 * @license http://www.gnu.org/licenses/lgpl.html
 */

// @codingStandardsIgnoreFile

class Month extends SplEnum
{
    const JANUARY  = 1;
    const FEBRUARY = 2;
}

class Fruit extends SplEnum
{
    const APPLE  = 1;
    const ORANGE = 2;
}

$jan =   new Month(Month::JANUARY);
$jan2 =  new Month(Month::JANUARY);
$apple = new Fruit(Fruit::APPLE);

var_dump($jan === $jan2);          // false
var_dump($jan === Month::JANUARY); // false
var_dump($jan ==  Fruit::APPLE);   // true
