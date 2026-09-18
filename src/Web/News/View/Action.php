<?php

declare(strict_types=1);

namespace App\Web\News\View;

use App\News\News;
use App\News\NewsRepository;
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
        private NewsRepository           $newsRepository,
        private CurrentRoute             $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler          $notFoundHandler,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $slug = $this->currentRoute->getArgument('slug');
        $news = $slug === null ? null : $this->newsRepository->findBySlug($slug);

        if ($news === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'article' => new ArticleView(
                title: $news->title,
                summary: $news->summary,
                content: $news->content,
                image: $news->image,
                publishedAt: $news->publishedAt,
                categoryLabel: 'Новости',
                categoryRouteName: 'news/index',
            ),
            'asideItems' => $this->asideItems($news),
        ]);
    }

    /**
     * @return AsideItem[]
     */
    private function asideItems(News $current): array
    {
        $latest = array_filter(
            $this->newsRepository->findLatest(self::ASIDE_LIMIT + 1),
            static fn (News $item) => $item->id !== $current->id,
        );

        return array_map(
            static fn (News $item) => new AsideItem(
                title: $item->title,
                slug: $item->slug,
                routeName: 'news/view',
                publishedAt: $item->publishedAt,
            ),
            array_slice($latest, 0, self::ASIDE_LIMIT),
        );
    }
}
