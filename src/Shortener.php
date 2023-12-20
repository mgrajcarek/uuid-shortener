<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Keiko\Uuid\Shortener\Exception\DictionaryException;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Number\BigInt\ConverterInterface;
use function extension_loaded;
use function str_pad;
use function str_split;
use function strrev;
use function substr;

/** @psalm-immutable */
class Shortener
{
    /**
     * @param Dictionary         $dictionary
     * @param ConverterInterface $converter
     */
    public function __construct(
        private readonly Dictionary $dictionary,
        private readonly ConverterInterface $converter,
    ) {
    }

    public static function make(Dictionary $dictionary) : self
    {
        if (extension_loaded('gmp')) {
            return new GMPShortener($dictionary);
        }

        return new self($dictionary, new Converter());
    }

    public function reduce(string $uuid): string
    {
        $uuidInt = $this->converter->fromHex($uuid);
        $output = '';

        while ($uuidInt->isPositive()) {
            $output .= $this->dictionary->charsSet[
                $uuidInt->mod($this->dictionary->length)
                    ->toInt()
            ];

            $uuidInt = $uuidInt->dividedBy($this->dictionary->length, RoundingMode::DOWN);
        }

        return $output;
    }

    public function expand(string $shortUuid): string
    {
        $number = BigInteger::zero();
        foreach (str_split(strrev($shortUuid)) as $char) {
            $number = $number
                ->multipliedBy($this->dictionary->length)
                ->plus(
                    $this->dictionary->charIndexes[$char] ?? (static function () : string {
                        throw DictionaryException::indexOutOfBounds();
                    })()
                );
        }

        $base16Uuid = str_pad($this->converter->toHex($number), 32, '0', STR_PAD_LEFT);

        return substr($base16Uuid,0, 8)
            . '-'
            . substr($base16Uuid, 8, 4)
            . '-'
            . substr($base16Uuid, 12, 4)
            . '-'
            . substr($base16Uuid, 16, 4)
            . '-'
            . substr($base16Uuid, 20, 12);
    }
}
