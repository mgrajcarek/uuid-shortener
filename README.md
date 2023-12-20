UUID SHORTENER
==============
[![Minimum PHP Version](https://img.shields.io/badge/php-%5E8.1-8892BF.svg)](https://php.net/)
[![Build Status](https://github.com/mgrajcarek/uuid-shortener/actions/workflows/build.yaml/badge.svg?branch=master)](https://github.com/mgrajcarek/uuid-shortener/actions/workflows/build.yaml)

A simple shortener library for RFC 4122 compatible UUIDs. 
Change your 36 chars long UUID into it's shorter equivalent.

Key concept and inspiration taken from [pascaldevink/shortuuid](https://github.com/pascaldevink/shortuuid) library. 
If you just need to generate short UUIDs the easy way, I encourage you to check his work.
If you expect perfomance, this library uses `ext-gmp` to speed up the process.
  
 
# Installation
The preferred method of installation is via [Packagist](https://packagist.org/) and [Composer](https://getcomposer.org). 
Run the following command to install the package and add it as a requirement to your project's composer.json:
```
composer require keiko/uuid-shortener
```

# Example
```php
<?php
require 'vendor/autoload.php';

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Shortener;

// Generate UUID, for example using Ramsey/UUID
$uuid = '806d0969-95b3-433b-976f-774611fdacbb';
$shortener = Shortener::make(
    Dictionary::createUnmistakable() // or pass your own characters set
);

echo $shortener->reduce($uuid); // output: mavTAjNm4NVztDwh4gdSrQ
```

You can reverse the process and expand your short UUID back to hexadecimal value.

```php
<?php
require 'vendor/autoload.php';

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Shortener;

$shortUuid = 'mavTAjNm4NVztDwh4gdSrQ';
$shortener = Shortener::make(
    Dictionary::createUnmistakable()
);

echo $shortener->expand($shortUuid); // output: 806d0969-95b3-433b-976f-774611fdacbb 
```

# Performance

In order to get optimal performance from this library, it is endorsed that you run `ext-gmp`
in your system.

`Keiko\Uuid\Shortener\Shortener::make()` will pick a GMP-compatible shortener or a fallback
shortener based on your system dependencies.

# Plans
UUID Shortener is not connected with any UUID generator library. 
It also does not generate new UUIDs. 
It has only one purpose - transform your long, hexadecimal IDs (no matter where they come from), into a shorter and easier to read set of characters.
