<?php

namespace Keiko\Uuid\Shortener;

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
         * TODO: Add invariants
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
     * @return string
     */
    public function getElement(int $index):string
    {
        /**
         * TODO: Test + Invariant
         */
        return $this->charsSet[$index];
    }
}