Helpers
=======

Given:

```php

namespace App\Model;

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

\Par\Core\Helper\ClassHelper::isAbstract
----------------------------------------

```php
\Par\Core\Helper\ClassHelper::isAbstract(\App\Model\Item::class); // false
\Par\Core\Helper\ClassHelper::isAbstract(\PAR\Core\Helper\HelperAbstract::class); // true
```

\Par\Core\Helper\InstanceHelper::isOfClass
------------------------------------------

```php
$instance = new \App\Model\Item('custom value');
\PAR\Core\Helper\InstanceHelper::isOfClass($instance, \App\Model\Item::class); // true

$instance = new \App\Model\SubItem('custom value');
\PAR\Core\Helper\InstanceHelper::isOfClass($instance, \App\Model\Item::class); // false
```

\Par\Core\Helper\InstanceHelper::assertIsOfClass
------------------------------------------------

Same as `\Par\Core\Helper\InstanceHelper::isOfClass` but throws `\Par\Core\Exception\ClassCastException` when `false`.

```php
$instance = new \App\Model\SubItem('custom value');
\PAR\Core\Helper\InstanceHelper::assertIsOfClass($instance, \App\Model\Item::class);
```

\Par\Core\Helper\InstanceHelper::toString
-----------------------------------------

```php
$instance = new \stdClass();
\PAR\Core\Helper\InstanceHelper::toString($instance); // 'FQCN@hash'
```

\Par\Core\Helper\InstanceHelper::hashCode
-----------------------------------------

```php
$instance = new \stdClass();
\PAR\Core\Helper\InstanceHelper::hashCode($instance); // string
```

\Par\Core\Helper\StringHelper::typeOf
-------------------------------------

```php
\Par\Core\Helper\StringHelper::typeOf('text'); // 'string'
\Par\Core\Helper\StringHelper::typeOf(new \stdClass()); // 'instance of stdClass'

// Appends class name with value of ObjectInterface::toString()
$instance = new \App\Model\Item('custom value');
\Par\Core\Helper\StringHelper::typeOf($instance); // 'instance of App\Model\Item@custom value
```