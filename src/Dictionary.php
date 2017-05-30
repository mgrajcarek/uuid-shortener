<?php

declare(strict_types=1);

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
     *
     * @throws DictionaryException
     */
    public function __construct(string $charsSet)
    {
        $this->charsSet = $charsSet;
        $this->length = strlen($charsSet);

        if ($this->length <= 16) {
            throw DictionaryException::charsetTooShort();
        }

        $uniqueChars = count_chars($charsSet, 3);
        if (strlen($uniqueChars) !== $this->length) {
            throw DictionaryException::nonUniqueChars();
        }
    }

    /**
     * @return Dictionary
     */
    public static function createUnmistakable(): Dictionary
    {
        return new self(self::DICTIONARY_UNMISTAKABLE);
    }

    /**
     * @return Dictionary
     */
    public static function createAlphanumeric(): Dictionary
    {
        return new self(self::DICTIONARY_ALPHANUMERIC);
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
    public function getChartAt(int $index): string
    {
        if (!isset($this->charsSet[$index])) {
            throw DictionaryException::indexNotAvailable();
        }

        return $this->charsSet[$index];
    }

    /**
     * @param string $char
     *
     * @throws DictionaryException
     *
     * @return int
     */
    public function getCharIndex(string $char): int
    {
        $index = strpos($this->charsSet, $char);
        if ($index === false) {
            throw DictionaryException::charNotFound();
        }

        return $index;
    }
}
