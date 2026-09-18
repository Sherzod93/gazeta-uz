<?php

declare(strict_types=1);

namespace App\Admin\Content;

final readonly class ContentInput
{
    public const DATETIME_FORMAT = 'Y-m-d\TH:i';

    public function __construct(
        public string $title = '',
        public string $slug = '',
        public string $summary = '',
        public string $content = '',
        public ?string $image = null,
        public string $publishedAt = '',
    ) {}

    /**
     * @param array<string, mixed> $body
     */
    public static function fromRequestBody(array $body): self
    {
        $image = trim((string) ($body['image'] ?? ''));

        return new self(
            title: trim((string) ($body['title'] ?? '')),
            slug: trim((string) ($body['slug'] ?? '')),
            summary: trim((string) ($body['summary'] ?? '')),
            content: trim((string) ($body['content'] ?? '')),
            image: $image === '' ? null : $image,
            publishedAt: trim((string) ($body['published_at'] ?? '')),
        );
    }
}
