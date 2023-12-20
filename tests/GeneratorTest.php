<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Generator;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Shortener;
use Keiko\Uuid\Shortener\UuidFactory;
use PHPUnit\Framework\TestCase;

final class GeneratorTest extends TestCase
{
    private Generator $generator;

    protected function setUp(): void
    {
        $this->generator = new Generator(
            new class() implements UuidFactory {
                public function create(): string
                {
                    return '806d0969-95b3-433b-976f-774611fdacbb';
                }
            },
            new Shortener(
                Dictionary::createUnmistakable(),
                new Converter()
            ),
        );
    }

    public function testGenerateShortUuid(): void
    {
        self::assertSame('mavTAjNm4NVztDwh4gdSrQ', $this->generator->generate());
    }
}
