<?php

declare(strict_types=1);

namespace App\Web\Admin\Login;

use App\Admin\Auth\AuthManager;
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
        private AuthManager $authManager,
        private RequestProviderInterface $requestProvider,
        private ResponseFactoryInterface $responseFactory,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(): ResponseInterface
    {
        if ($this->authManager->isLoggedIn()) {
            return $this->redirectToDashboard();
        }

        $request = $this->requestProvider->get();

        if ($request->getMethod() !== Method::POST) {
            return $this->render();
        }

        $body = (array) $request->getParsedBody();
        $username = trim((string) ($body['username'] ?? ''));
        $password = (string) ($body['password'] ?? '');

        if ($this->authManager->attempt($username, $password)) {
            return $this->redirectToDashboard();
        }

        return $this->render(error: 'Неверный логин или пароль.', username: $username);
    }

    private function render(?string $error = null, string $username = ''): ResponseInterface
    {
        return $this->viewRenderer
            ->withLayout('@src/Web/Admin/Layout/login-layout.php')
            ->render(__DIR__ . '/template', [
                'error' => $error,
                'username' => $username,
            ]);
    }

    private function redirectToDashboard(): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse(Status::FOUND)
            ->withHeader('Location', $this->urlGenerator->generate('admin/index'));
    }
}
