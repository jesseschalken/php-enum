<?php

namespace JesseSchalken\Enum\Test;

use JesseSchalken\Enum\IntEnum;
use JesseSchalken\Enum\StringEnum;

class Color extends StringEnum {
    const RED    = 'red';
    const ORANGE = 'orange';
    const YELLOW = 'yellow';
    const GREEN  = 'green';
    const BLUE   = 'blue';
    const PURPLE = 'purple';

    public static function values() {
        return array(
            self::RED,
            self::ORANGE,
            self::YELLOW,
            self::GREEN,
            self::BLUE,
            self::PURPLE,
        );
    }
}

class YesNoMaybe extends IntEnum {
    const YES   = 1;
    const NO    = -1;
    const MAYBE = 0;

    public static function values() {
        return array(
            self::YES,
            self::NO,
            self::MAYBE,
        );
    }
}

class Number extends StringEnum {
    const ONE   = '1';
    const TWO   = '2';
    const THREE = '3';

    public static function values() {
        return array(
            self::ONE,
            self::TWO,
            self::THREE,
        );
    }
}

class EnumTest extends \PHPUnit_Framework_TestCase {
    public function testStringEnum() {
        new Color('red');
        new Color(Color::ORANGE);
        new Color('yellow');
        new Color(Color::GREEN);
    }

    /**
     * @expectedException \JesseSchalken\Enum\EnumException
     * @expectedExceptionMessage 'redd' must be one of red, orange, yellow, green, blue, purple
     * @expectedExceptionCode 0
     */
    public function testStringEnumFail1() {
        new Color('redd');
    }

    /**
     * @expectedException \JesseSchalken\Enum\EnumException
     * @expectedExceptionMessage '' must be one of red, orange, yellow, green, blue, purple
     * @expectedExceptionCode 0
     */
    public function testStringEnumFail2() {
        new Color(null);
    }

    public function testIntEnum() {
        new YesNoMaybe(YesNoMaybe::YES);
        new YesNoMaybe(YesNoMaybe::NO);
        new YesNoMaybe(YesNoMaybe::MAYBE);
        new YesNoMaybe(-1);
        new YesNoMaybe(0);
        new YesNoMaybe(1);
        new YesNoMaybe('-1');
        new YesNoMaybe('0');
        new YesNoMaybe('1');
    }

    /**
     * @expectedException \JesseSchalken\Enum\EnumException
     * @expectedExceptionMessage 'hello' must be one of 1, -1, 0
     * @expectedExceptionCode 0
     */
    public function testIntEnumFail1() {
        new YesNoMaybe('hello');
    }

    /**
     * @expectedException \JesseSchalken\Enum\EnumException
     * @expectedExceptionMessage '89' must be one of 1, -1, 0
     * @expectedExceptionCode 0
     */
    public function testIntEnumFail2() {
        new YesNoMaybe(89);
    }

    public function testValid() {
        $this->assertTrue(Color::valid(Color::BLUE));
        $this->assertTrue(Color::valid('purple'));
        $this->assertFalse(Color::valid(''));
        $this->assertFalse(Color::valid(-1));

        $this->assertTrue(YesNoMaybe::valid(YesNoMaybe::YES));
        $this->assertTrue(YesNoMaybe::valid(0));
        $this->assertTrue(YesNoMaybe::valid('0'));
        $this->assertFalse(YesNoMaybe::valid(null));
        $this->assertFalse(YesNoMaybe::valid(98));
        $this->assertFalse(YesNoMaybe::valid(Color::BLUE));
    }

    public function testValue() {
        $this->assertEquals(gettype((new Color('red'))->value()), 'string');

        $this->assertEquals(gettype((new Number(1))->value()), 'string');
        $this->assertEquals(gettype((new Number('2'))->value()), 'string');
        $this->assertEquals(gettype((new Number(3))->value()), 'string');

        $this->assertEquals(gettype((new YesNoMaybe(1))->value()), 'integer');
        $this->assertEquals(gettype((new YesNoMaybe('1'))->value()), 'integer');
    }
}

