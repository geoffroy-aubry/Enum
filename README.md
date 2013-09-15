# PHP Enum

This is a simple-to-use PHP class that provides the ability to emulate and create type-safe enumerations.

## Table of Contents

  * [Introduction](#introduction)
    * [Definition](#definition)
    * [SplEnum](#splenum)
  * [Features](#features)
  * [Requirements](#requirements)
  * [Usage](#usage)
    * [An enumeration](#an-enumeration)
    * [Magic static calls](#magic-static-calls)
    * [Property calls approach](#property-calls-approach)
    * [Other functionalities](#other-functionalities)
  * [Benchmark](#benchmark)
  * [Installation](#installation)
  * [Documentation](#documentation)
  * [Copyrights & licensing](#copyrights--licensing)
  * [Change log](#change-log)
  * [Continuous integration](#continuous-integration)
  * [Git branching model](#git-branching-model)

## Introduction

### Definition

> In computer programming, an **enumerated type**
(also called **enumeration** or **enum**) 
is a data type consisting of a set of named values called **elements**, members or enumerators of the type. 
— [Wikipedia](http://en.wikipedia.org/wiki/Enumerated_type)

### SplEnum

[SplEnum](http://php.net/manual/en/class.splenum.php) is not integrated to PHP, 
you have to install it separately: `$ sudo pecl install SPL_Types`.

In addition, it's not a panacea:

```php
class Month extends SplEnum {
    const JANUARY  = 1;
    const FEBRUARY = 2;
}

class Fruit extends SplEnum {
    const APPLE  = 1;
    const ORANGE = 2;
}

// you must create new instance before each use:
$jan   = new Month(Month::JANUARY);
$jan2  = new Month(Month::JANUARY);
$apple = new Fruit(Fruit::APPLE);

var_dump($jan === $jan2);          // false
var_dump($jan === Month::JANUARY); // false
var_dump($jan ==  Fruit::APPLE);   // true
```

## Features

*Yet another implementation…*

Several interesting type-safe enumeration's implementations already exists:

  * [FlorianWolters/PHP-Component-Core-Enum](https://github.com/FlorianWolters/PHP-Component-Core-Enum)
  * [myclabs/php-enum](https://github.com/myclabs/php-enum)
  * [eloquent/enumeration](https://github.com/eloquent/enumeration)
  * …

But this one provides all the following advantages:

  * Type-safe enumeration.
  * Whatever the definition of one or more enumerations:
    * each element object is unique under comparison operator 
      ([`==`](http://php.net/manual/en/language.oop5.object-comparison.php))
    * and it is not possible to have 2 distincts instances of the same element, 
      under the identity operator ([`===`](http://php.net/manual/en/language.oop5.object-comparison.php)).
  * Supports both static method calls 
    (via [`__callStatic()`](http://www.php.net/manual/en/language.oop5.overloading.php#object.callstatic) magic method) 
    and property calls.
  * Property calls approach has a low overhead.
  * Supports namespaces to avoid naming collisions.
  * Supports autocompletion within an Integrated Development Environment (IDE).
  * No need to write any method. Just a simple class with elements as properties.
  * Elements cannot be cloned via the magic 
    [`__clone()`](http://php.net/language.oop5.cloning.php#object.clone) method.
  
Drawbacks:

  * Elements are not immutable *(but allow property calls approach with a low overhead)*
  * In case of exclusive property calls approach, a call to `MyEnum::buildInstances();` is needed first.
 
## Requirements

PHP >= 5.3.3

## Usage

### An enumeration

A simple example of enumeration:

```php
<?php

use GAubry\Enum\EnumAbstract;

class ColorEnum extends EnumAbstract {
    public static $RED;
    public static $GREEN;
    public static $BLUE;
}
```

### Magic static calls

With the `ColorEnum` enumeration just defined:

```php
$color = ColorEnum::RED();
var_dump((string)$color); // string(3) "RED"
```

```php
function f (ColorEnum $color) {
    switch($color) {
        case ColorEnum::RED():
        …
    }
    …
}

f(ColorEnum::RED());
```

### Property calls approach

This approach is much faster than that using [magic static calls](#magic-static-calls) 
(see [benchmark](#benchmark) below).

With the same `ColorEnum` enumeration as above:

```php
// One call per enumeration is necessary and sufficient, 
// typically at the top of the program, during instantiation phase:
ColorEnum::buildInstances(); 

$color = ColorEnum::$RED;
var_dump((string)$color); // string(3) "RED"
var_dump(ColorEnum::$RED === ColorEnum::RED()); // true
```

```php
function f (ColorEnum $color) {
    switch($color) {
        case ColorEnum::$RED:
        …
    }
    …
}

f(ColorEnum::$RED);
```

### Other functionalities

#### Cast to string

By default, `__toString()` method returns the name of the property.
But it is possible to choose the string returned: 

```php
class ColorEnum extends EnumAbstract {
    public static $RED = 'red color';
    …
}
```

#### All elements

All values of enumeration can be retrieve by static `values()` method:

```php
var_dump(ColorEnum::values());
```

```
array(3) {
    'RED' => class ColorEnum#13 (2) {
        private $iValue => int(0)
        private $sName  => string(9) "color red"
    }
    'GREEN' => class ColorEnum#14 (2) {
        private $iValue => int(1)
        private $sName  => string(5) "GREEN"
    }
    …
}
```

Keys can be easily listed by static `keys()` method:

```php
var_dump(ColorEnum::keys());
```

```
array(3) {
  [0] => string(3) "RED"
  [1] => string(5) "GREEN"
  [2] => string(4) "BLUE"
}
```

## Benchmark

All files are provided in `/tests` directory:

```bash
$ tests/benchmark.sh 1000 100
```

Result:

```
Averages after 1000 iterations:
    1× DayEnum::buildInstances():          0.436 ms
  100× DayEnum with magic static calls:    3.469 ms
  100× DayEnum with property calls:        0.407 ms
  100× with classic constants:             0.360 ms
```

So after the one necessary call to `buildInstances()`, 
property calls approach has a low overhead compared to a simple constant class.

## Installation

1. Class autoloading and dependencies are managed by [Composer](http://getcomposer.org/) 
so install it following the instructions 
on [Composer: Installation - *nix](http://getcomposer.org/doc/00-intro.md#installation-nix)
or just run the following command:
```bash
$ curl -sS https://getcomposer.org/installer | php
```

2. Add dependency to `GAubry\Enum` into require section of your `composer.json`:
```json
    {
        "require": {
            "geoffroy-aubry/enum": "1.*"
        }
    }
```
and run `php composer.phar install` from the terminal into the root folder of your project.

3. Include Composer's autoloader and use the `GAubry\Enum\EnumAbstract` class:
```php
    <?php
    
    require_once 'vendor/autoload.php';
    …
```

## Documentation

[API documentation](http://htmlpreview.github.io/?https://github.com/geoffroy-aubry/Enum/blob/stable/doc/api/index.html) 
generated by [ApiGen](http://apigen.org/) and included in the `/doc/api` folder.

```bash
$ vendor/bin/apigen.php -c apigen.neon
```

## Copyrights & licensing

Licensed under the GNU Lesser General Public License v3 (LGPL version 3).
See [LICENSE](LICENSE) file for details.

## Change log

See [CHANGELOG](CHANGELOG.md) file for details.

## Continuous integration

[![Build Status](https://secure.travis-ci.org/geoffroy-aubry/Enum.png?branch=stable)](http://travis-ci.org/geoffroy-aubry/Enum)
[![Coverage Status](https://coveralls.io/repos/geoffroy-aubry/Enum/badge.png?branch=stable)](https://coveralls.io/r/geoffroy-aubry/Enum)

Following commands are executed during each build and must report neither errors nor warnings:

 * Unit tests with [PHPUnit](https://github.com/sebastianbergmann/phpunit/):

    ```bash
    $ php vendor/bin/phpunit --configuration phpunit.xml
    ```

 *  Coding standards with [PHP CodeSniffer](http://pear.php.net/package/PHP_CodeSniffer):

    ```bash
    $ php vendor/bin/phpcs --standard=PSR2 src/ tests/ -v
    ```

 *  Code quality with [PHP Mess Detector](http://phpmd.org/):

    ```bash
    $ php vendor/bin/phpmd src/ text codesize,design,unusedcode,naming,controversial
    ```

## Git branching model

The git branching model used for development is the one described and assisted 
by `twgit` tool: [https://github.com/Twenga/twgit](https://github.com/Twenga/twgit).
