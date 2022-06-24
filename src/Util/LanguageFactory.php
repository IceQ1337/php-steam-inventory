<?php

namespace SteamInventory\Util;

final class LanguageFactory
{
    /**
     * List of all available languages.
     *
     * @var array
     */
    private static $languages = [
        'arabic',
        'brazilian',
        'bulgarian',
        'czech',
        'danish',
        'dutch',
        'english',
        'finnish',
        'french',
        'german',
        'greek',
        'hungarian',
        'italian',
        'japanese',
        'koreana',
        'nowegian',
        'polish',
        'portuguese',
        'romanian',
        'russian',
        'schinese',
        'spanish',
        'swedish',
        'tchinese',
        'thai',
        'turkish',
        'ukrainian',
    ];

    /**
     * Returns a list of all available languages.
     *
     * @return array
     */
    public static function getAll(): array
    {
        return self::$languages;
    }

    /**
     * Returns true if the specified language is available.
     *
     * @param  string $language
     * @return bool
     */
    public static function isValid($language): bool
    {
        return \in_array(\strtolower($language), self::$languages);
    }

    /**
     * Returns the default language 'english' if the specified language is not available.
     *
     * @param  string $language
     * @return string
     */
    public static function getLanguage($language): string
    {
        if (!isset($language) || !self::isValid($language)) {
            return 'english';
        }

        return $language;
    }

    /**
     * Returns the default language 'english'
     *
     * @return string
     */
    public static function getDefaultLanguage(): string
    {
        return 'english';
    }
}
