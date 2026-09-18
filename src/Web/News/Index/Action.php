<?php

declare(strict_types=1);

namespace App\Web\News\Index;

use App\News\News;
use App\News\NewsRepository;
use App\Web\Shared\Article\AsideItem;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    private const ASIDE_LIMIT = 3;

    public function __construct(
        private WebViewRenderer      $viewRenderer,
        private NewsRepository $newsRepository,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $newsList = $this->newsRepository->findLatest();

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'newsList' => $newsList,
            'asideItems' => array_map(
                static fn (News $item) => new AsideItem(
                    title: $item->title,
                    slug: $item->slug,
                    routeName: 'news/view',
                    publishedAt: $item->publishedAt,
                ),
                array_slice($newsList, 0, self::ASIDE_LIMIT),
            ),
        ]);
    }
}
