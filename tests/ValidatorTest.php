<?php

namespace Tests;

require __DIR__ . '/../vendor/autoload.php';

use App\UrlValidator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private UrlValidator $validator;
    public function setUp(): void
    {
        $this->validator = new UrlValidator();
    }

    public function testValidUrl(): void
    {
        $correctUrl = ['name' => 'https://example.com'];
        $this->assertEmpty($this->validator->validate($correctUrl));
    }

    public function testTooLongUrl(): void
    {
        $longUrl = ['name' => str_pad('http://example.com', 256, 'a')];
        $longException = ['name' => 'Максимум допустимо 255 символов'];
        $this->assertEquals($longException, $this->validator->validate($longUrl));
    }

    public function testBlankUrl(): void
    {
        $emptyUrl = ['name' => ''];
        $longException = ['name' => "URL не должен быть пустым"];
        $this->assertEquals($longException, $this->validator->validate($emptyUrl));
    }

    public function testInvalidUrl(): void
    {
        $incorrectUrl = ['name' => 'httpsss://abcabca@test.ru'];
        $longException = ['name' => "Некорректный URL"];
        $this->assertEquals($longException, $this->validator->validate($incorrectUrl));
    }
}
