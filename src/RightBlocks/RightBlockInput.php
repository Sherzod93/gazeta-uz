<?php

declare(strict_types=1);

namespace App\RightBlocks;

final readonly class RightBlockInput
{
    public function __construct(
        public string $logo = '',
        public ?string $backgroundImage = null,
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
        $backgroundImage = trim((string) ($body['background_image'] ?? ''));
        $subtitle = trim((string) ($body['subtitle'] ?? ''));
        $ctaText = trim((string) ($body['cta_text'] ?? ''));
        $ctaHref = trim((string) ($body['cta_href'] ?? ''));

        return new self(
            logo: trim((string) ($body['logo'] ?? '')),
            backgroundImage: $backgroundImage === '' ? null : $backgroundImage,
            title: trim((string) ($body['title'] ?? '')),
            subtitle: $subtitle === '' ? null : $subtitle,
            ctaText: $ctaText === '' ? null : $ctaText,
            ctaHref: $ctaHref === '' ? null : $ctaHref,
        );
    }
}
