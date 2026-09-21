<?php

declare(strict_types=1);

namespace App\Admin\Content;

use App\Categories\CategoryRepository;
use DateTimeImmutable;

final readonly class ContentValidator
{
    public function __construct(
        private ContentRepository $repository,
        private CategoryRepository $categoryRepository,
    ) {}

    /**
     * @return array<string, string> Errors keyed by field name.
     */
    public function validate(ContentType $type, ContentInput $input, ?int $excludeId = null): array
    {
        $errors = [];

        if ($input->title === '') {
            $errors['title'] = 'Введите заголовок.';
        }

        if ($input->slug === '') {
            $errors['slug'] = 'Введите URL (slug).';
        } elseif (!preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $input->slug)) {
            $errors['slug'] = 'Slug может содержать только латинские буквы в нижнем регистре, цифры и дефис.';
        } elseif ($this->repository->slugExists($type, $input->slug, $excludeId)) {
            $errors['slug'] = 'Такой URL уже используется.';
        }

        if ($input->summary === '') {
            $errors['summary'] = 'Введите краткое описание.';
        }

        if ($input->content === '') {
            $errors['content'] = 'Введите текст материала.';
        }

        if ($input->publishedAt === '') {
            $errors['publishedAt'] = 'Укажите дату публикации.';
        } elseif (DateTimeImmutable::createFromFormat(ContentInput::DATETIME_FORMAT, $input->publishedAt) === false) {
            $errors['publishedAt'] = 'Некорректная дата публикации.';
        }

        if ($input->categoryId === null) {
            $errors['categoryId'] = 'Выберите категорию.';
        } elseif ($this->categoryRepository->findById($input->categoryId) === null) {
            $errors['categoryId'] = 'Выбранная категория не найдена.';
        }

        return $errors;
    }
}
