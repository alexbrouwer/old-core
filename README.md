PHP Addition Repository - Core
==============================

[![Build Status](https://travis-ci.org/php-addition-repository/core.svg?branch=master)](https://travis-ci.org/php-addition-repository/core)
[![Coverage Status](https://coveralls.io/repos/github/php-addition-repository/core/badge.svg?branch=master)](https://coveralls.io/github/php-addition-repository/core?branch=master)

A multitude of data structures to improve on PHP.

I'm working on documentation.

Install
-------

```bash
composer require par/core
```

This package depends on the pecl [Data Structures](https://github.com/php-ds/ext-ds) package. It will work without, but installing it will improve performance greatly.

To install this package run:

```bash
pecl install ds
```

Test
----

```bash
make workspace
composer test
```

Credits
-------

- [Rudi Theunissen](https://github.com/rtheunissen) and [Joe Watkins](https://github.com/krakjoe) for their work on the pecl [Data Structures](https://github.com/php-ds/ext-ds) package which in my opinion should be made available in the PHP core

Licence
-------

The MIT License (MIT). Please see [LICENSE](LICENCE.md) for more information.