ObjectInterface
===============

Classes implementing the `Par\Core\ObjectInterface` enforce:
- Testing for equality via `$instance::equals($otherInstance)`
- 

When using the following implementation:

```php

namespace App;

use PAR\Core\Helper\InstanceHelper;
use PAR\Core\ObjectInterface;

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
    
    public function equals($other) : bool
    {
        /* @var self $other */
        return InstanceHelper::isOfClass($other, static::class) && $this->value === $other->value;
    }
    
    public function toString() : string
    {
        return (string) $this->value;
    }   
    
}
```
