# php-enum

Fast and safe enums for PHP 5.3+ without using reflection.

Objectives:
- Be fast. Checking an enum value should be _O(1)_.
- Be concise. The author of the enum should have to write as minimal code as possible without compromising the other objectives.
- Be safe. An instance of the concrete Enum class may only contain a valid value.
- Without Reflection. In particular:
    - Don't use `ReflectionClass` to get a list of a class's constants, since this violates the developer's expectation that a class constant not referenced via `Class::CONSTANT` is unused and can be removed.
    - Don't use `__call` or `__callStatic` to create pseudo-methods, since this violates the developer's expectation that a call to a method of the form `Class::method()` or `$object->method()` which cannot be found in the code is an error.

Example:

```php
use JesseSchalken\Enum\IntEnum;

class Day extends IntEnum {
	const MONDAY    = 0;
    const TUESDAY   = 1;
    const WEDNESDAY = 2;
    const THURSDAY  = 3;
    const FRIDAY    = 4;
    const SATURDAY  = 5;
    const SUNDAY    = 6;

    public static function values() {
    	return array(
        	self::MONDAY,
        	self::TUESDAY,
        	self::WEDNESDAY,
        	self::THURSDAY,
        	self::FRIDAY,
        	self::SATURDAY,
        	self::SUNDAY,
        );
    }
}

function needs_day(Day $d) {
    if ($d->value() == Day::FRIDAY) {
    	print "It's Friday, Friday...";
    }
}

Day::check(Day::TUESDAY); // okay
Day::check(2); // okay
Day::check(7); // throws EnumException

Day::valid(Day::SUNDAY); // true
Day::valid('foo'); // false

$day = new Day(Day::MONDAY);

needs_day($day);
```
```php
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

function needs_color(Color $c) {
	switch ($c->value()) {
    	case Color::RED:
        	print 'is red';
            break;
       	//...
    }
}

$color = new Color(Color::RED);

needs_color($color);
```

