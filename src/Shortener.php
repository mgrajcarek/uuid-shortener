<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Number\BigInt\ConverterInterface;
use Moontoast\Math\BigNumber;

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

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function reduce(string $uuid): string
    {
        $uuidInt = $this->converter->fromHex($uuid);
        $output = '';

        while ($uuidInt->getValue() > 0) {
            $previousNumber = clone $uuidInt;
            $uuidInt = $uuidInt->divide($this->dictionary->getLength());
            $digit = $previousNumber->mod($this->dictionary->getLength());
            $output .= $this->dictionary->getChartAt((int) $digit->getValue());
        }

        return $output;
    }

    /**
     * @param string $shortUuid
     *
     * @return string
     */
    public function expand(string $shortUuid): string
    {
        $number = new BigNumber(0);
        foreach (str_split(strrev($shortUuid)) as $char) {
            $number
                ->multiply($this->dictionary->getLength())
                ->add($this->dictionary->getCharIndex($char));
        }

        $hex = $this->converter->toHex($number);
        $expandedUUID = $this->formatHex($hex);

        return $expandedUUID;
    }

    /**
     * @param string $hex
     *
     * @return string
     */
    private function formatHex(string $hex): string
    {
        preg_match('/([a-f0-9]{8})([a-f0-9]{4})([a-f0-9]{4})([a-f0-9]{4})([a-f0-9]{12})/', $hex, $matches);
        array_shift($matches);
        $expandedUUID = implode('-', $matches);

        return $expandedUUID;
    }
}
