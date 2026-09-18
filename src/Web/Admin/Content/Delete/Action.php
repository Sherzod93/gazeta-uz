<?php

declare(strict_types=1);

namespace App\Web\Admin\Content\Delete;

use App\Admin\Content\ContentRepository;
use App\Admin\Content\ContentType;
use App\Web\NotFound\NotFoundHandler;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Http\Status;
use Yiisoft\RequestProvider\RequestProviderInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;

final readonly class Action
{
    public function __construct(
        private ContentRepository $contentRepository,
        private CurrentRoute $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler $notFoundHandler,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $type = ContentType::tryFrom((string) $this->currentRoute->getArgument('type'));
        $id = (int) $this->currentRoute->getArgument('id');
        $item = $type === null ? null : $this->contentRepository->findById($type, $id);

        if ($type === null || $item === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        $this->contentRepository->delete($type, $item->id);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/content/index', ['type' => $type->value]));
    }
}
