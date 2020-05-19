<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Keiko\Uuid\Shortener\Number\BigInt\ConverterInterface;
use function bccomp;
use function gmp_cmp;
use function gmp_div_q;
use function gmp_intval;
use function gmp_mod;

/** @psalm-immutable */
final class BCMathShortener extends Shortener
{
    /**
     * @var Dictionary
     */
    private $dictionary;

    /**
     * @var ConverterInterface
     */
    private $converter;

    /**
     * @param Dictionary         $dictionary
     * @param ConverterInterface $converter
     */
    public function __construct(Dictionary $dictionary, ConverterInterface $converter)
    {
        parent::__construct($dictionary, $converter);

        $this->dictionary = $dictionary;
        $this->converter = $converter;
    }

    public function reduce(string $uuid): string
    {
        $dictionaryLength = (string) $this->dictionary->getLength();
        $uuidInt = $this->converter->fromHex($uuid)->toBase(10);
        $output = '';

        while (bccomp($uuidInt, '0') === 1) {
            $previousNumber = $uuidInt;
            $uuidInt = bcdiv($uuidInt, $dictionaryLength, 0);
            $digit = bcmod($previousNumber, $dictionaryLength, 0);
            $output .= $this->dictionary->getCharAt((int) $digit);
        }

        return $output;
    }

    public function expand(string $shortUuid): string
    {
        $number = BigInteger::zero();
        foreach (str_split(strrev($shortUuid)) as $char) {
            $number = $number
                ->multipliedBy($this->dictionary->getLength())
                ->plus($this->dictionary->getCharIndex($char));
        }

        return $this->formatHex($this->converter->toHex($number));
    }

    private function formatHex(string $hex): string
    {
        $hex = str_pad($hex, 32, '0', \STR_PAD_LEFT);
        preg_match('/([a-f0-9]{8})([a-f0-9]{4})([a-f0-9]{4})([a-f0-9]{4})([a-f0-9]{12})/', $hex, $matches);
        array_shift($matches);

        return implode('-', $matches);
    }
}
