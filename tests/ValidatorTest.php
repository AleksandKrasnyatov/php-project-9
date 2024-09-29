<?php

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
        $longException = ['name' => 'max 255 symbols allowed'];
        $this->assertEquals($longException, $this->validator->validate($longUrl));
    }

    public function testBlankUrl(): void
    {
        $emptyUrl = ['name' => ''];
        $longException = ['name' => "field can't be blank"];
        $this->assertEquals($longException, $this->validator->validate($emptyUrl));
    }

    public function testInvalidUrl(): void
    {
        $incorrectUrl = ['name' => 'example.com'];
        $longException = ['name' => "url is not valid"];
        $this->assertEquals($longException, $this->validator->validate($incorrectUrl));
    }

}

