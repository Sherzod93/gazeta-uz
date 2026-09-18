<?php

declare(strict_types=1);

namespace App\Web\Shared\Article;

use DateTimeImmutable;

/**
 * Everything the shared article detail partial needs to render a single news item or reporting.
 */
final readonly class ArticleView
{
    public function __construct(
        public string $title,
        public string $summary,
        public string $content,
        public ?string $image,
        public DateTimeImmutable $publishedAt,
        public string $categoryLabel,
        public string $categoryRouteName,
    ) {}

    /**
     * @return string[]
     */
    public function paragraphs(): array
    {
        $paragraphs = preg_split('/\R{2,}/', trim($this->content)) ?: [];
        $paragraphs = array_map(trim(...), $paragraphs);

        return array_values(array_filter($paragraphs, static fn (string $paragraph) => $paragraph !== ''));
    }
}
