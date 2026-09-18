<?php

declare(strict_types=1);

namespace App\Web\Articles\Index;

use App\Articles\Article;
use App\Articles\ArticleRepository;
use App\Web\Shared\Article\AsideItem;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    private const ASIDE_LIMIT = 3;

    public function __construct(
        private WebViewRenderer   $viewRenderer,
        private ArticleRepository $articleRepository,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $articleList = $this->articleRepository->findLatest();

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'articleList' => $articleList,
            'asideItems' => array_map(
                static fn (Article $item) => new AsideItem(
                    title: $item->title,
                    slug: $item->slug,
                    routeName: 'articles/view',
                    publishedAt: $item->publishedAt,
                ),
                array_slice($articleList, 0, self::ASIDE_LIMIT),
            ),
        ]);
    }
}
