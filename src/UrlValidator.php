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
            } elseif (!filter_var($urlData['name'], FILTER_VALIDATE_URL)) {
                $errors['name'] = "url is not valid";
            }

        }
        return $errors;
    }
}
