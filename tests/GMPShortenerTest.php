<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\GMPShortener;
use Keiko\Uuid\Shortener\Shortener;

final class GMPShortenerTest extends ShortenerTestCase
{
    protected function shortener(Dictionary $dictionary = null) : Shortener
    {
        return new GMPShortener($dictionary ?? Dictionary::createUnmistakable());
    }

    public function testInstantiatedShortenerIsTheGMPVariation(): void
    {
        self::assertEquals(
            new GMPShortener(Dictionary::createUnmistakable()),
            Shortener::make(Dictionary::createUnmistakable())
        );
    }
}
