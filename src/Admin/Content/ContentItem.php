<?php

declare(strict_types=1);

namespace App\Admin\Content;

use DateTimeImmutable;

final readonly class ContentItem
{
    public function __construct(
        public int $id,
        public string $title,
        public string $slug,
        public string $summary,
        public string $content,
        public ?string $image,
        public DateTimeImmutable $publishedAt,
        public ?int $categoryId,
    ) {}

    /**
     * @param array<string, mixed> $row
     */
    public static function fromArray(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            title: (string) $row['title'],
            slug: (string) $row['slug'],
            summary: (string) $row['summary'],
            content: (string) $row['content'],
            image: $row['image'] === null ? null : (string) $row['image'],
            publishedAt: new DateTimeImmutable((string) $row['published_at']),
            categoryId: $row['category_id'] === null ? null : (int) $row['category_id'],
        );
    }
}
