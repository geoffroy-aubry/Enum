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

    public static function values()
    {
        $sClass = self::buildInstances();
        return self::$aCache[$sClass];
    }

    /**
     * Returns the names (or keys) of all of constants in the enum
     *
     * @return array
     */
    public static function keys()
    {
        return array_keys(self::values());
    }

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
