<?php

declare(strict_types=1);

namespace App\Web\Category\Index;

use App\Articles\Article;
use App\Articles\ArticleRepository;
use App\Categories\CategoryRepository;
use App\News\News;
use App\News\NewsRepository;
use App\Reportings\Reportings;
use App\Reportings\ReportingsRepository;
use App\Web\NotFound\NotFoundHandler;
use App\Web\Shared\Article\AsideItem;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\RequestProvider\RequestProviderInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    private const ASIDE_LIMIT = 3;

    public function __construct(
        private WebViewRenderer $viewRenderer,
        private CategoryRepository $categoryRepository,
        private NewsRepository $newsRepository,
        private ReportingsRepository $reportingsRepository,
        private ArticleRepository $articleRepository,
        private CurrentRoute $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler $notFoundHandler,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $slug = $this->currentRoute->getArgument('slug');
        $category = $slug === null ? null : $this->categoryRepository->findBySlug($slug);

        if ($category === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        $items = [
            ...array_map(
                static fn (News $news) => new CategoryItem(
                    title: $news->title,
                    summary: $news->summary,
                    slug: $news->slug,
                    publishedAt: $news->publishedAt,
                    routeName: 'news/view',
                    image: $news->image,
                ),
                $this->newsRepository->findByCategory($category->id),
            ),
            ...array_map(
                static fn (Reportings $report) => new CategoryItem(
                    title: $report->title,
                    summary: $report->summary,
                    slug: $report->slug,
                    publishedAt: $report->publishedAt,
                    routeName: 'reporting/view',
                    image: $report->image,
                ),
                $this->reportingsRepository->findByCategory($category->id),
            ),
            ...array_map(
                static fn (Article $article) => new CategoryItem(
                    title: $article->title,
                    summary: $article->summary,
                    slug: $article->slug,
                    publishedAt: $article->publishedAt,
                    routeName: 'articles/view',
                    image: $article->image,
                ),
                $this->articleRepository->findByCategory($category->id),
            ),
        ];

        usort($items, static fn (CategoryItem $a, CategoryItem $b) => $b->publishedAt <=> $a->publishedAt);

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'category' => $category,
            'items' => $items,
            'asideItems' => array_map(
                static fn (CategoryItem $item) => new AsideItem(
                    title: $item->title,
                    slug: $item->slug,
                    routeName: $item->routeName,
                    publishedAt: $item->publishedAt,
                ),
                array_slice($items, 0, self::ASIDE_LIMIT),
            ),
        ]);
    }
}
