<?php

namespace App;

class UrlValidator
{
    public function validate(array $urlData): array
    {
        $errors = [];
        if (empty($urlData['name'])) {
            $errors['name'] = "URL не должен быть пустым";
        } else {
            if (strlen($urlData['name']) > 255) {
                $errors['name'] = "Максимум допустимо 255 символов";
            } else {
                $parsedUrl = parse_url($urlData['name']);
                if (!array_key_exists('scheme', $parsedUrl) || !array_key_exists('host', $parsedUrl)) {
                    $errors['name'] = "Некорректный URL";
                } elseif (
                    !in_array($parsedUrl['scheme'], ['http', 'https']) || !str_contains($parsedUrl['host'], '.')
                ) {
                    $errors['name'] = "Некорректный URL";
                }
            }
        }
        return $errors;
    }
}
