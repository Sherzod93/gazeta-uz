<?php

declare(strict_types=1);

namespace App\Web\Shared\Article;

use DateTimeImmutable;

/**
 * A single entry of the "latest" list shown in the article detail sidebar.
 */
final readonly class AsideItem
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $routeName,
        public DateTimeImmutable $publishedAt,
    ) {}
}
