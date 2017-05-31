UUID SHORTENER
==============
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg)](https://php.net/)
[![Build Status](https://travis-ci.org/mgrajcarek/uuid-shortener.svg?branch=master)](https://travis-ci.org/mgrajcarek/uuid-shortener)

A simple shortener library for RFC 4122 compatible UUIDs. 
Change your long 34 chars long ID into it's shorter equivalent.

Key concept and inspiration taken from [pascaldevink/shortuuid](https://github.com/pascaldevink/shortuuid) library. 
If you just need to generate short UUIDs fast, I encourage you to check his work.
  
 
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
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Shortener;

// Generate UUID, for example using Ramsey/UUID
$uuid = '806d0969-95b3-433b-976f-774611fdacbb';
$shortener = new Shortener(
    Dictionary::createUnmistakable(), // or just pass your own characters set
    new Converter()
);

echo $shortener->reduce($uuid); // output: mavTAjNm4NVztDwh4gdSrQ
```

You can reverse the process and expand your short UUID back to hexadecimal value.

```php
<?php
require 'vendor/autoload.php';

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Shortener;

// Generate UUID, for example using Ramsey/UUID
$shortUuid = 'mavTAjNm4NVztDwh4gdSrQ';
$shortener = new Shortener(
    Dictionary::createUnmistakable(), // or just pass your own characters set
    new Converter()
);

echo $shortener->expand($shortUuid); // output: 806d0969-95b3-433b-976f-774611fdacbb 
```

# Plans
UUID Shortener is not connected with any UUID generator library. 
It also does not generate new UUIDs. 
It has only one purpose - transform your long, hexadecimal IDs (no matter where they come from), into a shorter and easier to read set of characters.
In the near future additional service will be added, which will be able to generate short UUIDs in companion with most popular UUID generators.