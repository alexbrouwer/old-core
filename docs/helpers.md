Helpers
=======

Given:

```php

use PAR\Core\ObjectInterface;
use PAR\Core\ComparableInterface;
use PAR\Core\Exception\ClassMismatchException;

class Item implements ObjectInterface 
{
    /**
     * @var int
     */
    private $value;
    
    public static function fromValue(int $value): self
    {
        return new self($value);
    }
    
    private function __construct(int $value) 
    {
        $this->value = $value;
    }
    
    /**
     * Determines if this object equals provided value.
     *
     * @param mixed $other The other value to compare with.
     *
     * @return bool
     */
    public function equals($other) : bool
    {
        if ($other instanceof self && get_class($other) === static::class) {
            return $this->value === $other->value;
        }

        return false;
    }
    
    /**
     * Compares this object with with other object. Returns a negative integer, zero or a positive integer as this
     * object is less than, equals to, or greater then the other object.
     *
     * @param ComparableInterface $other The other object to be compared.
     *
     * @return int
     * @throws ClassMismatchException If the other object's type prevents it from being compared to this object.
     */
    public function compareTo(ComparableInterface $other) : int
    {
        if ($other instanceof self && get_class($other) === static::class) {
            return $this->value - $other->value;
        }

        throw ClassMismatchException::expectedInstance($this, $other);
    }   
    
    public function toString() : string
    {
        return (string) $this->value;
    }   
    
}

```

ClassHelper::isAbstract
-----------------------

```php
\Par\Core\Helper\ClassHelper::isAbstract(Item::class);
```

ClassHelper::isFinal
--------------------

```php
\Par\Core\Helper\ClassHelper::isFinal(Item::class);
```

ClassHelper::getReflectionClass
-------------------------------

It is recommended to use this helper to handle class reflection because it efficiently caches 
already reflected classes.

```php
\Par\Core\Helper\ClassHelper::getReflectionClass(Item::class);
```

FormattingHelper::typeOf
------------------------

```php
\Par\Core\Helper\FormattingHelper::typeOf('text'); // 'string'
\Par\Core\Helper\FormattingHelper::typeOf(new Item('value')); // 'instance of Item'
```

InstanceHelper::isAnyOf
-----------------------
```php
$instance = new stdClass();
\Par\Core\Helper\InstanceHelper::isAnyOf($instance, [new stdClass(), $instance]); // true (strict comparison)

// Support for ObjectInterface
$instance = new Item('value');
\Par\Core\Helper\InstanceHelper::isAnyOf($instance, [new Item('value')]); // true (via ObjectInterface::equals)

// Forgiving with input
\Par\Core\Helper\InstanceHelper::isAnyOf(null, [false]); // false (only compares objects with objects)
```

InstanceHelper::isSameType
--------------------------

```php
$expected = new Item('value');
\PAR\Core\Helper\InstanceHelper::isSameType($expected, new Item('value')); // true
\PAR\Core\Helper\InstanceHelper::isSameType($expected, new stdClass()); // false
```

InstanceHelper::toString
------------------------

```php
$instance = new Item('value');
\PAR\Core\Helper\InstanceHelper::toString($instance); // 000000004080cda50000000021fdb7ab
```
