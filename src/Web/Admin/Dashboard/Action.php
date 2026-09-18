<?php

declare(strict_types=1);

namespace App\Web\Admin\Dashboard;

use App\Admin\Content\ContentType;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
    ) {}

    public function __invoke(): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/layout.php')
            ->render(__DIR__ . '/template', [
                'contentTypes' => ContentType::cases(),
            ]);
    }
}
