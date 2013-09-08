<?php

$oLoader = require __DIR__ . '/../vendor/autoload.php';

/* @var $oLoader \Composer\Autoload\ClassLoader */
$oLoader->add('GAubry\Enum\Mocks', __DIR__ . '/');
$oLoader->add('GAubry\Enum\Tests', __DIR__ . '/');
