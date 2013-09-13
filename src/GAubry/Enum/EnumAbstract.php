<?php

namespace GAubry\Enum;

/**
 * Enum abstract class and generator.
 *
 * Typical usage:
 * TODO ?
 * <code>…</code>
 *
 *
 * Copyright (c) 2013 Geoffroy Aubry <geoffroy.aubry@free.fr>
 * Licensed under the GNU Lesser General Public License v3 (LGPL version 3).
 *
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 * @copyright 2013 Geoffroy Aubry <geoffroy.aubry@free.fr>
 * @license http://www.gnu.org/licenses/lgpl.html
 */
abstract class EnumAbstract
{
    /**
     * Global static counter to ensure that each EnumAbstract instance is unique.
     * @var int
     */
    private static $iCounter = 0;

    /**
     * A cache of all enum values to increase performance.
     * Structure: array(
     *     'class' => array(
     *         'key' => EnumAbstract instance,
     *         …
     *     ),
     *     …
     * )
     *
     * @var array
     */
    private static $aCache = array();

    /**
     * A unique value to ensure that each EnumAbstract instance is unique.
     * @var int
     * @see self::$iCounter
     */
    private $iValue;

    /**
     * Name of enum instance, used by __toString().
     * @var string
     * @see __toString()
     */
    private $sName;

    /**
     * Constructor.
     *
     * @param string $sName Name of instance, used by __toString().
     */
    protected function __construct ($sName)
    {
        $this->iValue = self::$iCounter++;
        $this->sName = $sName;
    }

    /**
     * Converts all static properties into EnumAbstract instances.
     *
     * @throws \BadMethodCallException if called directly on EnumAbstract instead of derived class
     * @return string
     */
    public static function buildInstances ()
    {
        $sClass = get_called_class();
        if (empty(self::$aCache[$sClass])) {
            if ($sClass == get_class()) {
                $sMsg = 'Method for only purpose of inherited classes!';
                throw new \BadMethodCallException($sMsg, 1);
            } else {
                $oReflected = new \ReflectionClass($sClass);
                foreach ($oReflected->getStaticProperties() as $sKey => $mValue) {
                    $sName = (empty($mValue) ? $sKey : (string)$mValue);
                    $oReflected->setStaticPropertyValue($sKey, new static($sName));
                }
                self::$aCache[$sClass] = $oReflected->getStaticProperties();
            }
        }
        return $sClass;
    }

    /**
     * Returns an associative array containing all constants in the enum.
     *
     * @throws \BadMethodCallException if called directly on EnumAbstract instead of derived class
     * @return array Associative array (name => instance, …)
     */
    public static function values()
    {
        $sClass = self::buildInstances();
        return self::$aCache[$sClass];
    }

    /**
     * Returns the names (or keys) of all of constants in the enum.
     *
     * @throws \BadMethodCallException if called directly on EnumAbstract instead of derived class
     * @return array Array of string
     */
    public static function keys()
    {
        return array_keys(self::values());
    }

    /**
     * Get enum instances with lazy instanciation.
     * Triggered when invoking inaccessible methods in a static context.
     *
     * @SuppressWarnings(UnusedFormalParameter)
     * @param string $sName name of the static property
     * @param array  $aArgs not used…
     * @throws \DomainException if not called on one of the static properties
     * @throws \BadMethodCallException if called directly on EnumAbstract instead of derived class
     * @return EnumAbstract enum instance with the specified name
     */
    public static function __callStatic ($sName, $aArgs)
    {
        $sClass = self::buildInstances();
        if (! isset(self::$aCache[$sClass][$sName])) {
            $sMsg = "Unknown type '$sName'! Type must be in: "
                  . implode(', ', array_keys(self::$aCache[$sClass])) . '.';
            throw new \DomainException($sMsg, 1);
        }
        return self::$aCache[$sClass][$sName];
    }

    /**
     * Returns the name of the instance.
     *
     * This magic method is used for setting a string value for the object.
     * It will be used if the object is used as a string.
     *
     * @return string representing the object
     */
    public function __toString ()
    {
        return $this->sName;
    }

    /**
     * Prevent cloning.
     *
     * @throws \RuntimeException Cloning of this object isn't authorized!
     */
    final public function __clone()
    {
        throw new \RuntimeException('Cloning of this object isn\'t authorized!');
    }
}
