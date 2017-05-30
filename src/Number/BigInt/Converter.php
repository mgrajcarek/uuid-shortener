<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener\Number\BigInt;

use Moontoast\Math\BigNumber;

class Converter implements ConverterInterface
{
    /**
     * @param string $uuid
     *
     * @return BigNumber
     */
    public function fromHex(string $uuid): BigNumber
    {
        $uuidBase10 = BigNumber::convertToBase10($uuid, 16);

        return new BigNumber($uuidBase10);
    }

    /**
     * @param BigNumber $uuid
     *
     * @return string
     */
    public function toHex(BigNumber $uuid): string
    {
        return BigNumber::convertFromBase10($uuid, 16);
    }
}
