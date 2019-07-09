Helpers
=======

Given:

```php

use Par\Core\ObjectInterface;

class Item implements ObjectInterface
{
    /**
     * @var string 
     */
    private $value;
    
    public function __construct(string $value) 
    {
        $this->value = $value;
    }
        
    public function toString() : string 
    {
        return $this->value;
    }
}

class SubItem extends Item
{
    
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

```php
\Par\Core\Helper\ClassHelper::getReflectionClass(Item::class);
```

FormattingHelper::typeOf
------------------------

```php
\Par\Core\Helper\FormattingHelper::typeOf('text'); // 'string'
\Par\Core\Helper\FormattingHelper::typeOf(new \stdClass()); // 'instance of stdClass'
```

InstanceHelper::isAnyOf
-----------------------
```php
$instance = new \stdClass();
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
$other = new Item('custom value');

$expected = new Item('custom value');
\PAR\Core\Helper\InstanceHelper::isSameType($expected, $other); // true

$expected = new SubItem('custom value');
\PAR\Core\Helper\InstanceHelper::isSameType($expected, $other); // false
```
