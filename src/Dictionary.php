<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Exception\DictionaryException;
use function array_flip;
use function count_chars;
use function str_split;
use function strlen;

/** @psalm-immutable */
final class Dictionary
{
    const DICTIONARY_UNMISTAKABLE = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    const DICTIONARY_ALPHANUMERIC = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /** @var string */
    public $charsSet;

    /**
     * @var int[]
     *
     * @psalm-var non-empty-array<non-empty-string, int>
     */
    public $charIndexes;

    /** @var int */
    public $length;

    /**
     * @param string $charsSet
     *
     * @psalm-param non-empty-string $charsSet
     *
     * @throws DictionaryException
     */
    public function __construct(string $charsSet)
    {
        $length = strlen($charsSet);

        if ($length <= 16) {
            throw DictionaryException::charsSetTooShort();
        }

        $uniqueChars = count_chars($charsSet, 3);
        if (strlen($uniqueChars) !== $length) {
            throw DictionaryException::nonUniqueChars();
        }

        $this->charsSet = $charsSet;
        $this->length = $length;
        $this->charIndexes = array_flip(str_split($charsSet));
    }

    /**
     * @return Dictionary
     *
     * @psalm-pure
     */
    public static function createUnmistakable(): Dictionary
    {
        return new self(self::DICTIONARY_UNMISTAKABLE);
    }

    /**
     * @return Dictionary
     *
     * @psalm-pure
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
    public function getCharAt(int $index): string
    {
        if (!isset($this->charsSet[$index])) {
            throw DictionaryException::indexOutOfBounds();
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
