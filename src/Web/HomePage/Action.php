<?php

declare(strict_types=1);

namespace App\Web\HomePage;

use App\News\News;
use App\News\NewsRepository;
use App\Reportings\Reportings;
use App\Reportings\ReportingsRepository;
use App\Web\Shared\Article\AsideItem;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    public function __construct(
        private WebViewRenderer $viewRenderer,
        private NewsRepository $newsRepository,
        private ReportingsRepository $reportingsRepository,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $items = [
            ...array_map(
                static fn (News $news) => new HomePageItem(
                    title: $news->title,
                    summary: $news->summary,
                    slug: $news->slug,
                    publishedAt: $news->publishedAt,
                    routeName: 'news/view',
                    image: $news->image,
                ),
                $this->newsRepository->findLatest(),
            ),
            ...array_map(
                static fn (Reportings $report) => new HomePageItem(
                    title: $report->title,
                    summary: $report->summary,
                    slug: $report->slug,
                    publishedAt: $report->publishedAt,
                    routeName: 'reporting/view',
                    image: $report->image,
                ),
                $this->reportingsRepository->findLatest(),
            ),
        ];

        usort($items, static fn (HomePageItem $a, HomePageItem $b) => $b->publishedAt <=> $a->publishedAt);

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'mainItems' => array_slice($items, 0, 2),
            'asideItems' => array_map(
                static fn (HomePageItem $item) => new AsideItem(
                    title: $item->title,
                    slug: $item->slug,
                    routeName: $item->routeName,
                    publishedAt: $item->publishedAt,
                ),
                array_slice($items, 2, 6),
            ),
        ]);
    }
}
