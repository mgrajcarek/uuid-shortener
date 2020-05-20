<?php

declare(strict_types=1);

namespace Benchmark\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Shortener;

final class ShortenerBench extends BaseShorteningBench
{
    protected function newShortener() : Shortener
    {
        return new Shortener(Dictionary::createUnmistakable(), new Converter());
    }
}
