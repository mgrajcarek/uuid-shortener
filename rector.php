<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/benchmark',
        __DIR__.'/src',
        __DIR__.'/static-analysis',
        __DIR__.'/tests',
    ])
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withPhpSets(php81: true)
    ->withPreparedSets(codeQuality: true)
    ->withSets([PHPUnitSetList::PHPUNIT_100]);
