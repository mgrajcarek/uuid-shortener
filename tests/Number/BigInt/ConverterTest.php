<?php

declare(strict_types=1);

namespace Test\Keiko\Uuid\Shortener\Number\BigInt;

use Brick\Math\BigInteger;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use PHPUnit\Framework\TestCase;

final class ConverterTest extends TestCase
{
    private Converter $converter;

    protected function setUp(): void
    {
        $this->converter = new Converter();
    }

    public function testConvertBigIntegerIntoHex(): void
    {
        $this->assertEquals('fe', $this->converter->toHex(BigInteger::of(254)));
    }

    public function testConvertHexIntoBigInteger(): void
    {
        $this->assertEquals(253, $this->converter->fromHex('fd')->toInt());
    }
}
