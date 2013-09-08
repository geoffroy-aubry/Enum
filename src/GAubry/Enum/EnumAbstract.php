<?php

namespace GAubry\Enum;

// final class DayEnum extends EnumAbstract
abstract class EnumAbstract
{
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

    private $iValue;
    private $sName;

    protected function __construct ($sName) {
        $this->iValue = self::$iCounter++;
        $this->sName = $sName;
    }

    private static function buildInstances ()
    {
        $sClass = get_called_class();
        $oReflected = new \ReflectionClass($sClass);
        foreach ($oReflected->getStaticProperties() as $sKey => $mValue) {
            $sName = (empty($mValue) ? $sKey : (string)$mValue);
            $oReflected->setStaticPropertyValue($sKey, new static($sName));
        }
        self::$aCache[$sClass] = $oReflected->getStaticProperties();
    }

    public static function values()
    {
        $sClass = get_called_class();
        if (empty(self::$aCache[$sClass])) {
            static::buildInstances();
        }
        return self::$aCache[$sClass];
    }

    /**
     * The day *monday*.
     *
     * @return DayEnum The day *monday*.
     */
//     final public static function MONDAY()
//     {
//         return self::getInstance();
//     }

    /**
     * Returns the names (or keys) of all of constants in the enum
     *
     * @return array
     */
    public static function keys()
    {
        return array_keys(static::values());
    }

    /**
     * bla…
     *
     * This magic method is used for setting a string value for the object.
     * It will be used if the object is used as a string.
     *
     * @returns string representing the object
     */
    public function __toString ()
    {
        return $this->sName;
    }
}
