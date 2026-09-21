<?php

declare(strict_types=1);

namespace App\Banners;

final readonly class BannerValidator
{
    /**
     * @return array<string, string> Errors keyed by field name.
     */
    public function validate(BannerInput $input): array
    {
        $errors = [];

        if ($input->logo === '') {
            $errors['logo'] = 'Введите текст логотипа.';
        }

        if ($input->title === '') {
            $errors['title'] = 'Введите заголовок.';
        }

        return $errors;
    }
}
