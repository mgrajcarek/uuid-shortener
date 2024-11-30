<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Shortener;

final class ShortenerTest extends ShortenerTestCase
{
    protected function shortener(?Dictionary $dictionary = null): Shortener
    {
        return new Shortener(
            $dictionary ?? Dictionary::createUnmistakable(),
            new Converter()
        );
    }
}
