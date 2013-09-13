# PHP Enum

`EnumAbstract` gives the ability to emulate and create type-safe enumerations in PHP.

## Description

### Demo

## Usage

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

3. Include Composer's autoloader and use the `GAubry\Enum` class:
```php
    <?php
    
    require_once 'vendor/autoload.php';
    …
```

## Documentation

## Copyrights & licensing
Licensed under the GNU Lesser General Public License v3 (LGPL version 3).
See [LICENSE](LICENSE) file for details.

## Change log

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
The git branching model used for development is the one described and assisted by `twgit` tool: [https://github.com/Twenga/twgit](https://github.com/Twenga/twgit).
