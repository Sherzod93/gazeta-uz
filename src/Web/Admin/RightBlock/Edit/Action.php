<?php

declare(strict_types=1);

namespace App\Web\Admin\RightBlock\Edit;

use App\RightBlocks\RightBlock;
use App\RightBlocks\RightBlockInput;
use App\RightBlocks\RightBlockRepository;
use App\RightBlocks\RightBlockValidator;
use App\Web\NotFound\NotFoundHandler;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Http\Method;
use Yiisoft\Http\Status;
use Yiisoft\RequestProvider\RequestProviderInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private RightBlockRepository $rightBlockRepository,
        private RightBlockValidator $rightBlockValidator,
        private CurrentRoute $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler $notFoundHandler,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $request = $this->requestProvider->get();
        $id = (int) $this->currentRoute->getArgument('id');
        $item = $this->rightBlockRepository->findById($id);

        if ($item === null) {
            return $this->notFoundHandler->handle($request);
        }

        if ($request->getMethod() !== Method::POST) {
            return $this->render($item->id, $this->toInput($item));
        }

        $input = RightBlockInput::fromRequestBody((array) $request->getParsedBody());
        $errors = $this->rightBlockValidator->validate($input);

        if ($errors !== []) {
            return $this->render($item->id, $input, $errors);
        }

        $this->rightBlockRepository->update($item->id, $input);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/right-block/index'));
    }

    private function toInput(RightBlock $item): RightBlockInput
    {
        return new RightBlockInput(
            logo: $item->logo,
            title: $item->title,
            subtitle: $item->subtitle,
            ctaText: $item->ctaText,
            ctaHref: $item->ctaHref,
        );
    }

    /**
     * @param array<string, string> $errors
     */
    private function render(int $itemId, RightBlockInput $input, array $errors = []): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/layout.php')
            ->render(__DIR__ . '/template', [
                'input' => $input,
                'errors' => $errors,
                'itemId' => $itemId,
            ]);
    }
}
