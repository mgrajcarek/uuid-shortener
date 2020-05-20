<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Exception\DictionaryException;
use function gmp_add;
use function gmp_cmp;
use function gmp_div_q;
use function gmp_init;
use function gmp_intval;
use function gmp_mod;
use function gmp_strval;
use function str_pad;
use function str_replace;
use function substr;
use const GMP_ROUND_ZERO;
use const STR_PAD_LEFT;

/** @psalm-immutable */
final class GMPShortener extends Shortener
{
    /** @var Dictionary */
    private $dictionary;

    public function __construct(Dictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    public function reduce(string $uuid): string
    {
        $dictionaryLength = gmp_init($this->dictionary->length, 10);
        $uuidInt = gmp_strval(gmp_init(str_replace('-', '', $uuid), 16));
        $output = '';

        while (gmp_cmp($uuidInt, '0') > 0) {
            $output .= $this->dictionary->charsSet[gmp_intval(gmp_mod($uuidInt, $dictionaryLength))];

            $uuidInt = gmp_div_q($uuidInt, $dictionaryLength, GMP_ROUND_ZERO);
        }

        return $output;
    }

    public function expand(string $shortUuid): string
    {
        $number = gmp_init(0, 10);
        $dictionaryLength = gmp_init($this->dictionary->length, 10);

        foreach (str_split(strrev($shortUuid)) as $char) {
            $number = gmp_add(
                gmp_mul($number, $dictionaryLength),
                (string) ($this->dictionary->charIndexes[$char] ?? (static function () : string {
                    throw DictionaryException::indexOutOfBounds();
                })())
            );
        }

        $base16Uuid = str_pad(gmp_strval($number, 16), 32, '0', STR_PAD_LEFT);

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
