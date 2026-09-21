<?php

declare(strict_types=1);

namespace App\Web\Admin\Banner\Index;

use App\Banners\BannerRepository;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private BannerRepository $bannerRepository,
    ) {}

    public function __invoke(): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/layout.php')
            ->render(__DIR__ . '/template', [
                'items' => $this->bannerRepository->findAll(),
            ]);
    }
}
