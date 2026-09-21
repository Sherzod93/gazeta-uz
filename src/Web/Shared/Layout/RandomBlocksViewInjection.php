<?php

declare(strict_types=1);

namespace App\Web\Shared\Layout;

use App\Banners\BannerRepository;
use App\RightBlocks\RightBlockRepository;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;

/**
 * Picks a random banner and a random right-side promo block on every render, so the content
 * shown in those shared slots varies across page loads while staying consistent within one page.
 */
final readonly class RandomBlocksViewInjection implements CommonParametersInjectionInterface
{
    public function __construct(
        private BannerRepository $bannerRepository,
        private RightBlockRepository $rightBlockRepository,
    ) {}

    public function getCommonParameters(): array
    {
        return [
            'banner' => $this->bannerRepository->findRandom(),
            'rightBlock' => $this->rightBlockRepository->findRandom(),
        ];
    }
}
