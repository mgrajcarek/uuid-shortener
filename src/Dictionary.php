<?php

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Exception\DictionaryException;

class Dictionary
{
    const DICTIONARY_UNMISTAKABLE = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    const DICTIONARY_ALPHANUMERIC = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * @var string
     */
    private $charsSet;

    /**
     * @var int
     */
    private $length;

    /**
     * @param string $charsSet
     */
    public function __construct(string $charsSet)
    {
        $this->charsSet = $charsSet;
        $this->length = strlen($charsSet);

        /**
         * 1) is long enough to reduce uuid?
         * 2) are elements unique?
         */
    }

    /**
     * @return Dictionary
     */
    public static function createUnmistakable()
    {
        return new Dictionary(self::DICTIONARY_UNMISTAKABLE);
    }

    /**
     * @return Dictionary
     */
    public static function createAlphanumeric()
    {
        return new Dictionary(self::DICTIONARY_ALPHANUMERIC);
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $index
     *
     * @throws DictionaryException
     *
     * @return string
     */
    public function getElement(int $index):string
    {
        if (!isset($this->charsSet[$index])) {
            throw DictionaryException::indexNotAvailable();
        }

        return $this->charsSet[$index];
    }
}