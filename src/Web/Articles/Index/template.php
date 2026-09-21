<?php

declare(strict_types=1);

use App\Articles\Article;
use App\Shared\RussianDate;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var Article[] $articleList
 * @var AsideItem[] $asideItems
 */

$this->setTitle('Статьи');

require __DIR__ . '/../../Shared/Layout/Partial/Banner.php';

$activeTab = 'articles';
require __DIR__ . '/../../Shared/Layout/Partial/SubNav.php';
?>

<?php if ($articleList === []): ?>
    <p>Статей пока нет.</p>
<?php else: ?>
    <div class="news-page-grid">
        <div class="news-page-list">
            <?php foreach ($articleList as $article): ?>
                <article class="news-page-item">
                    <a
                        class="news-page-item__media"
                        href="<?= Html::encode($urlGenerator->generate('articles/view', ['slug' => $article->slug])) ?>"
                        aria-hidden="true"
                        <?= $article->image !== null ? 'style="background-image:url(\'' . Html::encode($article->image) . '\')"' : '' ?>
                    ></a>
                    <div class="news-page-item__body">
                        <p class="news-page-item__meta"><?= Html::encode(RussianDate::relative($article->publishedAt)) ?></p>
                        <h2 class="news-page-item__title">
                            <a href="<?= Html::encode($urlGenerator->generate('articles/view', ['slug' => $article->slug])) ?>">
                                <?= Html::encode($article->title) ?>
                            </a>
                        </h2>
                        <p class="news-page-item__excerpt"><?= Html::encode($article->summary) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php require __DIR__ . '/../../Shared/Layout/Partial/RightBlock.php'; ?>
    </div>
<?php endif; ?>
