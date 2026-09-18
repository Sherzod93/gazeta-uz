<?php

declare(strict_types=1);

use App\News\News;
use App\Shared\RussianDate;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var News[] $newsList
 * @var AsideItem[] $asideItems
 */

$this->setTitle('Новости');

$bannerLogo = 'spot.';
$bannerTitle = 'Деловые новости Узбекистана';
$bannerSubtitle = 'Бизнес, технологии, экономика — www.spot.uz';
require __DIR__ . '/../../Shared/Layout/Partial/Banner.php';

$activeTab = 'news';
require __DIR__ . '/../../Shared/Layout/Partial/SubNav.php';
?>

<?php if ($newsList === []): ?>
    <p>Новостей пока нет.</p>
<?php else: ?>
    <div class="news-page-grid">
        <div class="news-page-list">
            <?php foreach ($newsList as $news): ?>
                <article class="news-page-item">
                    <a
                        class="news-page-item__media"
                        href="<?= Html::encode($urlGenerator->generate('news/view', ['slug' => $news->slug])) ?>"
                        aria-hidden="true"
                        <?= $news->image !== null ? 'style="background-image:url(\'' . Html::encode($news->image) . '\')"' : '' ?>
                    ></a>
                    <div class="news-page-item__body">
                        <p class="news-page-item__meta"><?= Html::encode(RussianDate::relative($news->publishedAt)) ?></p>
                        <h2 class="news-page-item__title">
                            <a href="<?= Html::encode($urlGenerator->generate('news/view', ['slug' => $news->slug])) ?>">
                                <?= Html::encode($news->title) ?>
                            </a>
                        </h2>
                        <p class="news-page-item__excerpt"><?= Html::encode($news->summary) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php require __DIR__ . '/../../Shared/Layout/Partial/RightBlock.php'; ?>
    </div>
<?php endif; ?>
