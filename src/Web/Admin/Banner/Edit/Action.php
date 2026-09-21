<?php

declare(strict_types=1);

namespace App\Web\Admin\Banner\Edit;

use App\Admin\Content\ContentImageUploader;
use App\Admin\Content\InvalidContentImageException;
use App\Banners\Banner;
use App\Banners\BannerInput;
use App\Banners\BannerRepository;
use App\Banners\BannerValidator;
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
        private BannerRepository $bannerRepository,
        private BannerValidator $bannerValidator,
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
        $id = (int) $this->currentRoute->getArgument('id');
        $item = $this->bannerRepository->findById($id);

        if ($item === null) {
            return $this->notFoundHandler->handle($request);
        }

        if ($request->getMethod() !== Method::POST) {
            return $this->render($item->id, $this->toInput($item));
        }

        $body = (array) $request->getParsedBody();

        try {
            $logo = $this->contentImageUploader->upload($request->getUploadedFiles()['logo'] ?? null);
        } catch (InvalidContentImageException $e) {
            $body['logo'] = $item->logo;

            return $this->render($item->id, BannerInput::fromRequestBody($body), ['logo' => $e->getMessage()]);
        }

        $body['logo'] = $logo ?? $item->logo;

        $input = BannerInput::fromRequestBody($body);
        $errors = $this->bannerValidator->validate($input);

        if ($errors !== []) {
            return $this->render($item->id, $input, $errors);
        }

        $this->bannerRepository->update($item->id, $input);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/banner/index'));
    }

    private function toInput(Banner $item): BannerInput
    {
        return new BannerInput(
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
    private function render(int $itemId, BannerInput $input, array $errors = []): ResponseInterface
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
