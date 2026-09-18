<?php

declare(strict_types=1);

namespace App\Web\HomePage;

use DateTimeImmutable;

final readonly class HomePageItem
{
    public function __construct(
        public string $title,
        public string $summary,
        public string $slug,
        public DateTimeImmutable $publishedAt,
        public string $routeName,
        public ?string $image = null,
    ) {}
}
