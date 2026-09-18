<?php

declare(strict_types=1);

namespace App\Web\Admin\Content\Index;

use App\Admin\Content\ContentRepository;
use App\Admin\Content\ContentType;
use App\Web\NotFound\NotFoundHandler;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\RequestProvider\RequestProviderInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private ContentRepository $contentRepository,
        private CurrentRoute $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler $notFoundHandler,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $type = ContentType::tryFrom((string) $this->currentRoute->getArgument('type'));

        if ($type === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/layout.php')
            ->render(__DIR__ . '/template', [
                'type' => $type,
                'items' => $this->contentRepository->findAll($type),
            ]);
    }
}
