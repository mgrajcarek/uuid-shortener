<?php
declare(strict_types=1);

namespace Keiko\Uuid\Shortener\Number\BigInt;

use Moontoast\Math\BigNumber;

interface ConverterInterface
{
    /**
     * @param string $uuid
     *
     * @return BigNumber
     */
    public function fromHex(string $uuid): BigNumber;

    /**
     * @param BigNumber $uuid
     *
     * @return string
     */
    public function toHex(BigNumber $uuid): string;
}