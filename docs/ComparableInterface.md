ComparableInterface
===================

Classes implementing the `Par\Core\ComparableInterface` can be compared 
via `$instance->compareTo($otherInstance);`. Both instances must be of 
the same type (class).

When using the following implementation:

```php

namespace App;

use PAR\Core\ComparableInterface;
use PAR\Core\Exception\ClassMismatchException;

class Item implements ComparableInterface 
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
}
```

Comparison can be done via:

```php
$value = Item::fromValue(2);
$same = Item::fromValue(2);
$larger = Item::fromValue(3);
$smaller = Item::fromValue(3);

$value->compareTo($same); // 0 
$value->compareTo($larger); // -1: $value < $larger
$value->compareTo($smaller); // 1: $value > $smaller
```

Sorting is also possible:

Directly via PHP's `uasort` (by reference)

```php
$list = [
    Item::fromValue(2),
    Item::fromValue(3),
    Item::fromValue(1),
];

usasort($list, Par\Core\Comparator::callback());
// $list = [1, 2, 3, ]
```

Or via `Comparator::sortArray`, which will:
 - fail early if a value in the list does not implement the `ComparableInterface`
 - return a new array leaving the original intact

```php
$list = [
    Item::fromValue(2),
    Item::fromValue(3),
    Item::fromValue(1),
];

$sorted = Par\Core\Comparator::sortArray($list);
// $sorted = [1, 2, 3, ]
// $list = [2, 3, 1, ]
```
