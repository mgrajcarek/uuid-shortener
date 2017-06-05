<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener\Exception;

class DictionaryException extends \Exception
{
    /**
     * @return DictionaryException
     */
    public static function indexOutOfBounds()
    {
        return new self('Index out of bounds in the Dictionary');
    }

    /**
     * @return DictionaryException
     */
    public static function nonUniqueChars()
    {
        return new self('Dictionary contains non unique characters');
    }

    /**
     * @return DictionaryException
     */
    public static function charsSetTooShort()
    {
        return new self('Dictionary characters set is too short to reduce UUID');
    }

    /**
     * @return DictionaryException
     */
    public static function charNotFound()
    {
        return new self('Character not found');
    }
}
