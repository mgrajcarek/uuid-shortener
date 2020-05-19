<?php

declare(strict_types=1);

namespace Benchmark\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\GMPShortener;
use Keiko\Uuid\Shortener\Shortener;

final class GMPShortenerBench extends BaseShorteningBench
{
    protected function newShortener() : Shortener
    {
        return new GMPShortener(Dictionary::createUnmistakable());
    }
}
