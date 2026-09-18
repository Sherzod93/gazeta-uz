<?php

declare(strict_types=1);

namespace App\Web\Reportings\Index;

use App\Reportings\Reportings;
use App\Reportings\ReportingsRepository;
use App\Web\Shared\Article\AsideItem;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class Action
{
    private const ASIDE_LIMIT = 3;

    public function __construct(
        private WebViewRenderer      $viewRenderer,
        private ReportingsRepository $reportingsRepository,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $reportList = $this->reportingsRepository->findLatest();

        return $this->viewRenderer->render(__DIR__ . '/template', [
            'reportList' => $reportList,
            'asideItems' => array_map(
                static fn (Reportings $item) => new AsideItem(
                    title: $item->title,
                    slug: $item->slug,
                    routeName: 'reporting/view',
                    publishedAt: $item->publishedAt,
                ),
                array_slice($reportList, 0, self::ASIDE_LIMIT),
            ),
        ]);
    }
}
