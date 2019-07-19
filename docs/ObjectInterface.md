ObjectInterface
===============

Classes implementing the `Par\Core\ObjectInterface` enforce:
- Testing for equality via `$instance::equals($otherInstance)`
- String casting via `$instance::toString()`

When using the following implementation:

```php

use PAR\Core\ObjectInterface;
use PAR\Core\ObjectCastToString;

class Item implements ObjectInterface 
{
    use ObjectCastToString;
    
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
        
    public function equals($other) : bool
    {
        if ($other instanceof self && get_class($other) === static::class) {
            return $this->value === $other->value;
        }

        return false;
    }
    
    public function toString() : string
    {
        return (string) $this->value;
    }
}
```
