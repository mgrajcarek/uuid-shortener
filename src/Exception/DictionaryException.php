<?php

declare(strict_types = 1);

namespace Keiko\Uuid\Shortener\Exception;

class DictionaryException extends \Exception
{
    /**
     * @return DictionaryException
     */
    public static function indexNotAvailable()
    {
        return new self('Index not available in the Dictionary');
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
    public static function charsetTooShort()
    {
        return new self('Dictionary charset is too short to reduce UUID');
    }

}