<?php

declare(strict_types=1);

namespace App\Web\Admin\Content\Edit;

use App\Admin\Content\ContentImageUploader;
use App\Admin\Content\ContentInput;
use App\Admin\Content\ContentItem;
use App\Admin\Content\ContentRepository;
use App\Admin\Content\ContentType;
use App\Admin\Content\ContentValidator;
use App\Admin\Content\InvalidContentImageException;
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
        private ContentRepository $contentRepository,
        private ContentValidator $contentValidator,
        private ContentImageUploader $contentImageUploader,
        private CurrentRoute $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler $notFoundHandler,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $request = $this->requestProvider->get();
        $type = ContentType::tryFrom((string) $this->currentRoute->getArgument('type'));
        $id = (int) $this->currentRoute->getArgument('id');
        $item = $type === null ? null : $this->contentRepository->findById($type, $id);

        if ($type === null || $item === null) {
            return $this->notFoundHandler->handle($request);
        }

        if ($request->getMethod() !== Method::POST) {
            return $this->render($type, $item->id, $this->toInput($item));
        }

        $body = (array) $request->getParsedBody();

        try {
            $image = $this->contentImageUploader->upload($request->getUploadedFiles()['image'] ?? null);
        } catch (InvalidContentImageException $e) {
            $body['image'] = $item->image;

            return $this->render($type, $item->id, ContentInput::fromRequestBody($body), ['image' => $e->getMessage()]);
        }

        $body['image'] = $image ?? $item->image;

        $input = ContentInput::fromRequestBody($body);
        $errors = $this->contentValidator->validate($type, $input, excludeId: $item->id);

        if ($errors !== []) {
            return $this->render($type, $item->id, $input, $errors);
        }

        $this->contentRepository->update($type, $item->id, $input);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/content/index', ['type' => $type->value]));
    }

    private function toInput(ContentItem $item): ContentInput
    {
        return new ContentInput(
            title: $item->title,
            slug: $item->slug,
            summary: $item->summary,
            content: $item->content,
            image: $item->image,
            publishedAt: $item->publishedAt->format(ContentInput::DATETIME_FORMAT),
        );
    }

    /**
     * @param array<string, string> $errors
     */
    private function render(ContentType $type, int $itemId, ContentInput $input, array $errors = []): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/layout.php')
            ->render(__DIR__ . '/template', [
                'type' => $type,
                'input' => $input,
                'errors' => $errors,
                'itemId' => $itemId,
            ]);
    }
}
