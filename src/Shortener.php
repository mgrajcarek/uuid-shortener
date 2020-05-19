<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Keiko\Uuid\Shortener\Number\BigInt\Converter;
use Keiko\Uuid\Shortener\Number\BigInt\ConverterInterface;
use function extension_loaded;

/** @psalm-immutable */
class Shortener
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
        $this->dictionary = $dictionary;
        $this->converter = $converter;
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
        $dictionaryLength = $this->dictionary->getLength();
        $uuidInt = $this->converter->fromHex($uuid);
        $output = '';

        while ($uuidInt->isPositive()) {
            $previousNumber = clone $uuidInt;
            $uuidInt = $uuidInt->dividedBy($dictionaryLength, RoundingMode::DOWN);
            $digit = $previousNumber->mod($dictionaryLength);
            $output .= $this->dictionary->getCharAt($digit->toInt());
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
