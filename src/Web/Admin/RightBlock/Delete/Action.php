<?php

declare(strict_types=1);

namespace App\Web\Admin\RightBlock\Delete;

use App\RightBlocks\RightBlockRepository;
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
        private RightBlockRepository $rightBlockRepository,
        private CurrentRoute $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler $notFoundHandler,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $id = (int) $this->currentRoute->getArgument('id');
        $item = $this->rightBlockRepository->findById($id);

        if ($item === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        $this->rightBlockRepository->delete($item->id);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/right-block/index'));
    }
}
