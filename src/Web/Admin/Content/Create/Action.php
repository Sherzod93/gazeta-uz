<?php

declare(strict_types=1);

namespace App\Web\Admin\Content\Create;

use App\Admin\Content\ContentImageUploader;
use App\Admin\Content\ContentInput;
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
        $type = ContentType::tryFrom((string) $this->currentRoute->getArgument('type'));

        if ($type === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        $request = $this->requestProvider->get();

        if ($request->getMethod() !== Method::POST) {
            return $this->render($type, new ContentInput());
        }

        $body = (array) $request->getParsedBody();

        try {
            $image = $this->contentImageUploader->upload($request->getUploadedFiles()['image'] ?? null);
        } catch (InvalidContentImageException $e) {
            return $this->render($type, ContentInput::fromRequestBody($body), ['image' => $e->getMessage()]);
        }

        if ($image !== null) {
            $body['image'] = $image;
        }

        $input = ContentInput::fromRequestBody($body);
        $errors = $this->contentValidator->validate($type, $input);

        if ($errors !== []) {
            return $this->render($type, $input, $errors);
        }

        $this->contentRepository->insert($type, $input);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/content/index', ['type' => $type->value]));
    }

    /**
     * @param array<string, string> $errors
     */
    private function render(ContentType $type, ContentInput $input, array $errors = []): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/layout.php')
            ->render(__DIR__ . '/template', [
                'type' => $type,
                'input' => $input,
                'errors' => $errors,
                'itemId' => null,
            ]);
    }
}
