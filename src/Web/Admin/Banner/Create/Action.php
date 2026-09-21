<?php

declare(strict_types=1);

namespace App\Web\Admin\Banner\Create;

use App\Banners\BannerInput;
use App\Banners\BannerRepository;
use App\Banners\BannerValidator;
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
        private BannerRepository $bannerRepository,
        private BannerValidator $bannerValidator,
        private RequestProviderInterface $requestProvider,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $request = $this->requestProvider->get();

        if ($request->getMethod() !== Method::POST) {
            return $this->render(new BannerInput());
        }

        $input = BannerInput::fromRequestBody((array) $request->getParsedBody());
        $errors = $this->bannerValidator->validate($input);

        if ($errors !== []) {
            return $this->render($input, $errors);
        }

        $this->bannerRepository->insert($input);

        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/banner/index'));
    }

    /**
     * @param array<string, string> $errors
     */
    private function render(BannerInput $input, array $errors = []): ResponseInterface
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
