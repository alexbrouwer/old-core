PHP Addition Repository - Core
==============================

[![Build Status](https://travis-ci.org/php-addition-repository/core.svg?branch=master)](https://travis-ci.org/php-addition-repository/core)

Repository containing interfaces enforcing basic implementations of general object functionality.

Install
-------

```
composer require par/core
```

Usage
-----

### PAR\Core\ObjectInterface

Implement this interface on all classes that represents a domain unit.
By doing so, determining equality is a breeze via `$instance->equals( $other );`.
This interface also makes it easier to use the object in any external context via `$instance->toString();`.
