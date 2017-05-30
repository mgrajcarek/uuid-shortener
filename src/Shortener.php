<?php

declare(strict_types = 1);

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Number\BigInt\ConverterInterface;

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
    public function reduce(string $uuid) : string
    {
        $uuidInt = $this->converter->fromHex($uuid);
        $output = '';

        while ($uuidInt->getValue() > 0) {
            $previousNumber = clone $uuidInt;
            $uuidInt = $uuidInt->divide($this->dictionary->getLength());
            $digit = $previousNumber->mod($this->dictionary->getLength());
            $output .= $this->dictionary->getElement((int) $digit->getValue());
        }

        return $output;
    }

}