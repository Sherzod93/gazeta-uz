<?php

declare(strict_types=1);

namespace App\Banners;

final readonly class BannerInput
{
    public function __construct(
        public string $logo = '',
        public string $title = '',
        public ?string $subtitle = null,
        public ?string $ctaText = null,
        public ?string $ctaHref = null,
    ) {}

    /**
     * @param array<string, mixed> $body
     */
    public static function fromRequestBody(array $body): self
    {
        $subtitle = trim((string) ($body['subtitle'] ?? ''));
        $ctaText = trim((string) ($body['cta_text'] ?? ''));
        $ctaHref = trim((string) ($body['cta_href'] ?? ''));

        return new self(
            logo: trim((string) ($body['logo'] ?? '')),
            title: trim((string) ($body['title'] ?? '')),
            subtitle: $subtitle === '' ? null : $subtitle,
            ctaText: $ctaText === '' ? null : $ctaText,
            ctaHref: $ctaHref === '' ? null : $ctaHref,
        );
    }
}
