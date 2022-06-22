<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use SteamInventory\LanguageFactory;

final class LanguageTest extends TestCase
{
    public function testInvalidLanguage(): void
    {
        $language = 'xyz';
        $this->assertFalse(LanguageFactory::isValid($language));
        $this->assertEquals('english', LanguageFactory::getLanguage($language));
    }

    public function testValidLanguage(): void
    {
        $language = 'german';
        $this->assertTrue(LanguageFactory::isValid($language));
        $this->assertEquals($language, LanguageFactory::getLanguage($language));
    }
}
