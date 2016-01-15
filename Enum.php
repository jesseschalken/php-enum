<?php

namespace JesseSchalken\Enum;

interface IEnum {
    /** @return (int|string)[] */
    public static function values();

    /** @return int|string */
    public function value();
}

interface IIntEnum extends IEnum {
    /** @return int[] */
    public static function values();

    /** @return int */
    public function value();
}

interface IStringEnum extends IEnum {
    /** @return string[] */
    public static function values();

    /** @return string */
    public function value();
}

abstract class Enum implements IEnum {
    /**
     * @param int|string $value
     * @return bool
     */
    public final static function valid($value) {
        $set = static::set();
        return isset($set[$value]);
    }

    /**
     * @param int|string $value
     * @return void
     */
    public final static function check($value) {
        $set = static::set();
        if (!isset($set[$value])) {
            throw new EnumException("'$value' must be one of " . join(', ', array_keys($set)));
        }
    }

    /**
     * @return array
     */
    private final static function set() {
        static $cache = array();
        $set =& $cache[get_called_class()];
        if ($set === null) {
            $set = array_fill_keys(static::values(), true);
        }
        return $set;
    }
}

abstract class IntEnum extends Enum implements IIntEnum {
    /** @var int */
    private $value;

    /** @param int $value */
    public function __construct($value) {
        self::check($value);
        $this->value = (int)$value;
    }

    /** @return int */
    public function value() {
        return $this->value;
    }
}

abstract class StringEnum extends Enum implements IStringEnum {
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value) {
        self::check($value);
        $this->value = (string)$value;
    }

    /** @return string */
    public function value() {
        return $this->value;
    }
}

class EnumException extends \InvalidArgumentException {
}

