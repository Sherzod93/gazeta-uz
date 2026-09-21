<?php

declare(strict_types=1);

use App\Categories\Category;
use App\Shared\RussianDate;
use App\Web\Category\Index\CategoryItem;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var Category $category
 * @var CategoryItem[] $items
 * @var AsideItem[] $asideItems
 */

$this->setTitle($category->name);

require __DIR__ . '/../../Shared/Layout/Partial/Banner.php';
?>

<h1 class="category-page__title"><?= Html::encode($category->name) ?></h1>

<?php if ($items === []): ?>
    <p>Материалов в этой категории пока нет.</p>
<?php else: ?>
    <div class="news-page-grid">
        <div class="news-page-list">
            <?php foreach ($items as $item): ?>
                <article class="news-page-item">
                    <a
                        class="news-page-item__media"
                        href="<?= Html::encode($urlGenerator->generate($item->routeName, ['slug' => $item->slug])) ?>"
                        aria-hidden="true"
                        <?= $item->image !== null ? 'style="background-image:url(\'' . Html::encode($item->image) . '\')"' : '' ?>
                    ></a>
                    <div class="news-page-item__body">
                        <p class="news-page-item__meta"><?= Html::encode(RussianDate::relative($item->publishedAt)) ?></p>
                        <h2 class="news-page-item__title">
                            <a href="<?= Html::encode($urlGenerator->generate($item->routeName, ['slug' => $item->slug])) ?>">
                                <?= Html::encode($item->title) ?>
                            </a>
                        </h2>
                        <p class="news-page-item__excerpt"><?= Html::encode($item->summary) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php require __DIR__ . '/../../Shared/Layout/Partial/RightBlock.php'; ?>
    </div>
<?php endif; ?>
