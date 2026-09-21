<?php

declare(strict_types=1);

use App\Reportings\Reportings;
use App\Shared\RussianDate;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var Reportings[] $reportList
 * @var AsideItem[] $asideItems
 */

$this->setTitle('Репортажи');

require __DIR__ . '/../../Shared/Layout/Partial/Banner.php';

$activeTab = 'reporting';
require __DIR__ . '/../../Shared/Layout/Partial/SubNav.php';
?>

<?php if ($reportList === []): ?>
    <p>Репортажных статей пока нет..</p>
<?php else: ?>
    <div class="news-page-grid">
        <div class="news-page-list">
            <?php foreach ($reportList as $report): ?>
                <article class="news-page-item">
                    <a
                        class="news-page-item__media"
                        href="<?= Html::encode($urlGenerator->generate('reporting/view', ['slug' => $report->slug])) ?>"
                        aria-hidden="true"
                        <?= $report->image !== null ? 'style="background-image:url(\'' . Html::encode($report->image) . '\')"' : '' ?>
                    ></a>
                    <div class="news-page-item__body">
                        <p class="news-page-item__meta"><?= Html::encode(RussianDate::relative($report->publishedAt)) ?></p>
                        <h2 class="news-page-item__title">
                            <a href="<?= Html::encode($urlGenerator->generate('reporting/view', ['slug' => $report->slug])) ?>">
                                <?= Html::encode($report->title) ?>
                            </a>
                        </h2>
                        <p class="news-page-item__excerpt"><?= Html::encode($report->summary) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php require __DIR__ . '/../../Shared/Layout/Partial/RightBlock.php'; ?>
    </div>
<?php endif; ?>
