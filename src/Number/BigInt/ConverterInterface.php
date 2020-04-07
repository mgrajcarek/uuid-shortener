<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener\Number\BigInt;

use Brick\Math\BigInteger;

/** @psalm-immutable */
interface ConverterInterface
{
    public function fromHex(string $uuid): BigInteger;

    public function toHex(BigInteger $uuid): string;
}
