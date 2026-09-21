<?php

declare(strict_types=1);

namespace App\Web\Admin\RightBlock\Create;

use App\Admin\Content\ContentImageUploader;
use App\Admin\Content\InvalidContentImageException;
use App\RightBlocks\RightBlockInput;
use App\RightBlocks\RightBlockRepository;
use App\RightBlocks\RightBlockValidator;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Http\Method;
use Yiisoft\Http\Status;
use Yiisoft\RequestProvider\RequestProviderInterface;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private RightBlockRepository $rightBlockRepository,
        private RightBlockValidator $rightBlockValidator,
        private ContentImageUploader $contentImageUploader,
        private RequestProviderInterface $requestProvider,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $request = $this->requestProvider->get();

        if ($request->getMethod() !== Method::POST) {
            return $this->render(new RightBlockInput());
        }

        $body = (array) $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        try {
            $logo = $this->contentImageUploader->upload($uploadedFiles['logo'] ?? null);
        } catch (InvalidContentImageException $e) {
            return $this->render(RightBlockInput::fromRequestBody($body), ['logo' => $e->getMessage()]);
        }

        try {
            $backgroundImage = $this->contentImageUploader->upload($uploadedFiles['background_image'] ?? null);
        } catch (InvalidContentImageException $e) {
            return $this->render(RightBlockInput::fromRequestBody($body), ['backgroundImage' => $e->getMessage()]);
        }

        if ($logo !== null) {
            $body['logo'] = $logo;
        }

        if ($backgroundImage !== null) {
            $body['background_image'] = $backgroundImage;
        }

        $input = RightBlockInput::fromRequestBody($body);
        $errors = $this->rightBlockValidator->validate($input);

        if ($errors !== []) {
            return $this->render($input, $errors);
        }

        $this->rightBlockRepository->insert($input);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/right-block/index'));
    }

    /**
     * @param array<string, string> $errors
     */
    private function render(RightBlockInput $input, array $errors = []): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/layout.php')
            ->render(__DIR__ . '/template', [
                'input' => $input,
                'errors' => $errors,
                'itemId' => null,
            ]);
    }
}
