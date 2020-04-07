<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener\Number\BigInt;

use Brick\Math\BigInteger;

/** @psalm-immutable */
class Converter implements ConverterInterface
{
    public function fromHex(string $uuid): BigInteger
    {
        return BigInteger::fromBase(str_replace('-', '', $uuid), 16);
    }

    public function toHex(BigInteger $uuid): string
    {
        return $uuid->toBase(16);
    }
}
