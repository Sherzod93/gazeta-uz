<?php

declare(strict_types=1);

namespace App\Web\Articles\View;

use App\Articles\Article;
use App\Articles\ArticleRepository;
use App\Web\NotFound\NotFoundHandler;
use App\Web\Shared\Article\ArticleView;
use App\Web\Shared\Article\AsideItem;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\RequestProvider\RequestProviderInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    private const ASIDE_LIMIT = 3;

    public function __construct(
        private WebViewRenderer          $viewRenderer,
        private ArticleRepository        $articleRepository,
        private CurrentRoute             $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler          $notFoundHandler,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $slug = $this->currentRoute->getArgument('slug');
        $article = $slug === null ? null : $this->articleRepository->findBySlug($slug);

        if ($article === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'article' => new ArticleView(
                title: $article->title,
                summary: $article->summary,
                content: $article->content,
                image: $article->image,
                publishedAt: $article->publishedAt,
                categoryLabel: 'Статьи',
                categoryRouteName: 'articles/index',
            ),
            'asideItems' => $this->asideItems($article),
        ]);
    }

    /**
     * @return AsideItem[]
     */
    private function asideItems(Article $current): array
    {
        $latest = array_filter(
            $this->articleRepository->findLatest(self::ASIDE_LIMIT + 1),
            static fn (Article $item) => $item->id !== $current->id,
        );

        return array_map(
            static fn (Article $item) => new AsideItem(
                title: $item->title,
                slug: $item->slug,
                routeName: 'articles/view',
                publishedAt: $item->publishedAt,
            ),
            array_slice($latest, 0, self::ASIDE_LIMIT),
        );
    }
}
