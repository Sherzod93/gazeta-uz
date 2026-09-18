<?php

declare(strict_types=1);

namespace App\Web\Reportings\View;

use App\Reportings\Reportings;
use App\Reportings\ReportingsRepository;
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
        private ReportingsRepository     $reportingsRepository,
        private CurrentRoute             $currentRoute,
        private RequestProviderInterface $requestProvider,
        private NotFoundHandler          $notFoundHandler,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $slug = $this->currentRoute->getArgument('slug');
        $reports = $slug === null ? null : $this->reportingsRepository->findBySlug($slug);

        if ($reports === null) {
            return $this->notFoundHandler->handle($this->requestProvider->get());
        }

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'article' => new ArticleView(
                title: $reports->title,
                summary: $reports->summary,
                content: $reports->content,
                image: $reports->image,
                publishedAt: $reports->publishedAt,
                categoryLabel: 'Репортажи',
                categoryRouteName: 'reporting/index',
            ),
            'asideItems' => $this->asideItems($reports),
        ]);
    }

    /**
     * @return AsideItem[]
     */
    private function asideItems(Reportings $current): array
    {
        $latest = array_filter(
            $this->reportingsRepository->findLatest(self::ASIDE_LIMIT + 1),
            static fn (Reportings $item) => $item->id !== $current->id,
        );

        return array_map(
            static fn (Reportings $item) => new AsideItem(
                title: $item->title,
                slug: $item->slug,
                routeName: 'reporting/view',
                publishedAt: $item->publishedAt,
            ),
            array_slice($latest, 0, self::ASIDE_LIMIT),
        );
    }
}
