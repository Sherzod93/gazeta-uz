<?php

declare(strict_types=1);

namespace App\RightBlocks;

final readonly class RightBlockValidator
{
    /**
     * @return array<string, string> Errors keyed by field name.
     */
    public function validate(RightBlockInput $input): array
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
