Values
======

This class consists of static utility methods for operating on values.

equals
------

```php

use PAR\Core\Values;

Values::equals( $a, $b ); #bool
```

Determines if values should be considered equal.
     
If `$a` implements [`PAR\Core\Hashable`](./Hashable.md, `$a->equals($b)` is used, or if `$b` implements `PAR\Core\Hashable` `$b->equals($a)` is used, otherwise uses a strict comparison (`$a === $b`).

