<?php

declare(strict_types=1);

namespace App\Banners;

final readonly class Banner
{
    public function __construct(
        public int $id,
        public string $logo,
        public string $title,
        public ?string $subtitle,
        public ?string $ctaText,
        public ?string $ctaHref,
    ) {}

    public static function fromArray(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            logo: (string) $row['logo'],
            title: (string) $row['title'],
            subtitle: $row['subtitle'] === null ? null : (string) $row['subtitle'],
            ctaText: $row['cta_text'] === null ? null : (string) $row['cta_text'],
            ctaHref: $row['cta_href'] === null ? null : (string) $row['cta_href'],
        );
    }
}
