<?php

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Number\BigInt\ConverterInterface;

final class Shortener
{
    /**
     * @var ConverterInterface
     */
    private $converter;

    /**
     * @var Dictionary
     */
    private $dictionary;

    /**
     * @param string              $charsSet
     * @param ConverterInterface $converter
     */
    public function __construct(string $charsSet, ConverterInterface $converter)
    {
        $this->converter = $converter;
        $this->dictionary = new Dictionary($charsSet);
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
            $output .= $this->dictionary->getElement($digit->getValue());
        }

        return $output;
    }

}