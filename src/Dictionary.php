<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Exception\DictionaryException;

/** @psalm-immutable */
final class Dictionary
{
    public const DICTIONARY_UNMISTAKABLE = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    public const DICTIONARY_ALPHANUMERIC = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public string $charsSet;

    /**
     * @var int[]
     *
     * @psalm-var non-empty-array<non-empty-string, int>
     */
    public array $charIndexes;

    public int $length;

    /**
     * @psalm-param non-empty-string $charsSet
     *
     * @throws DictionaryException
     */
    public function __construct(string $charsSet)
    {
        $length = \strlen($charsSet);

        if ($length <= 16) {
            throw DictionaryException::charsSetTooShort();
        }

        $uniqueChars = \count_chars($charsSet, 3);
        if (\strlen($uniqueChars) !== $length) {
            throw DictionaryException::nonUniqueChars();
        }

        $this->charsSet = $charsSet;
        $this->length = $length;
        $this->charIndexes = \array_flip(\str_split($charsSet));
    }

    /**
     * @psalm-pure
     */
    public static function createUnmistakable(): Dictionary
    {
        return new self(self::DICTIONARY_UNMISTAKABLE);
    }

    /**
     * @psalm-pure
     */
    public static function createAlphanumeric(): Dictionary
    {
        return new self(self::DICTIONARY_ALPHANUMERIC);
    }

    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @throws DictionaryException
     */
    public function getCharAt(int $index): string
    {
        if (!isset($this->charsSet[$index])) {
            throw DictionaryException::indexOutOfBounds();
        }

        return $this->charsSet[$index];
    }

    /**
     * @throws DictionaryException
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
