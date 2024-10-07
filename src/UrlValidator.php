<?php

namespace App;

class UrlValidator
{
    public function validate(array $urlData): array
    {
        $errors = [];
        if (empty($urlData['name'])) {
            $errors['name'] = "field can't be blank";
        } else {
            if (strlen($urlData['name']) > 255) {
                $errors['name'] = "max 255 symbols allowed";
            } else {
                $parsedUrl = parse_url($urlData['name']);
                if (!array_key_exists('scheme', $parsedUrl) || !array_key_exists('host', $parsedUrl)) {
                    $errors['name'] = "url is not valid";
                } elseif (
                    !in_array($parsedUrl['scheme'], ['http', 'https']) || !str_contains($parsedUrl['host'], '.')
                ) {
                    $errors['name'] = "Некорректный URL ";
                }
            }
        }
        return $errors;
    }
}
