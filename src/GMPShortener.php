<?php

declare(strict_types=1);

namespace Keiko\Uuid\Shortener;

use Keiko\Uuid\Shortener\Exception\DictionaryException;

/** @psalm-immutable */
final class GMPShortener extends Shortener
{
    /**
     * @var string[] a map of character replacements to be used when translating a number that is
     *               in base(length(Dictionary)) (keys) to the dictionary characters (values)
     *
     * @psalm-var non-empty-array<non-empty-string, non-empty-string>
     */
    private readonly array $baseReplacements;

    private readonly string $allowedCharactersMatcher;

    public function __construct(private readonly Dictionary $dictionary)
    {
        $replacements = [];

        foreach (range(0, $dictionary->length - 1) as $characterIndex) {
            $replacements[\gmp_strval(\gmp_init((string) $characterIndex, 10), $dictionary->length)] = $dictionary->charsSet[$characterIndex];
        }

        $this->baseReplacements = $replacements;
        $this->allowedCharactersMatcher = '/^['.\preg_quote($dictionary->charsSet, '/').']+$/';
    }

    public function reduce(string $uuid): string
    {
        return \strrev(\strtr(
            \gmp_strval(\gmp_init(\str_replace('-', '', $uuid), 16), $this->dictionary->length),
            $this->baseReplacements
        ));
    }

    public function expand(string $shortUuid): string
    {
        if (1 !== \preg_match($this->allowedCharactersMatcher, $shortUuid)) {
            throw DictionaryException::indexOutOfBounds();
        }

        $base16Uuid = \str_pad(
            \gmp_strval(
                \gmp_init(
                    \strtr(\strrev($shortUuid), \array_flip($this->baseReplacements)),
                    $this->dictionary->length
                ),
                16
            ),
            32,
            '0',
            \STR_PAD_LEFT
        );

        return \substr($base16Uuid, 0, 8)
            .'-'
            .\substr($base16Uuid, 8, 4)
            .'-'
            .\substr($base16Uuid, 12, 4)
            .'-'
            .\substr($base16Uuid, 16, 4)
            .'-'
            .\substr($base16Uuid, 20, 12);
    }
}
