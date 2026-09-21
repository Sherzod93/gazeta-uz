<?php

declare(strict_types=1);

use App\Shared\RussianDate;
use App\Web\Shared\Article\ArticleView;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/**
 * @var UrlGeneratorInterface $urlGenerator
 * @var ArticleView $article
 * @var AsideItem[] $asideItems
 * @var string $activeTab One of 'home', 'news', 'articles', 'reporting', 'media'.
 */

?>

    <?php require __DIR__ . '/Banner.php'; ?>

    <?php require __DIR__ . '/SubNav.php'; ?>

    <div class="article-grid">
        <article class="article">
            <figure class="article__figure">
                <div class="article__media">
                    <?php if ($article->image !== null): ?>
                        <img src="<?= Html::encode($article->image) ?>" alt="<?= Html::encode($article->title) ?>">
                    <?php endif; ?>
                    <span class="article__watermark" aria-hidden="true">gazeta</span>
                </div>
                <figcaption class="article__caption">Фото: Gazeta.uz</figcaption>
            </figure>

            <h1 class="article__title"><?= Html::encode($article->title) ?></h1>
            <p class="article__lead"><?= Html::encode($article->summary) ?></p>

            <div class="article__meta">
                <div class="article__meta-main">
                    <span class="article__date"><?= Html::encode(RussianDate::dateTime($article->publishedAt)) ?></span>
                    <a href="<?= Html::encode($urlGenerator->generate($article->categoryRouteName)) ?>"><?= Html::encode($article->categoryLabel) ?></a>
                </div>
                <div class="article__langs">
                    <a href="#">Ўзбек тилида</a>
                    <a href="#">O'zbek tilida</a>
                </div>
            </div>

            <div class="article__body">
                <?php foreach ($article->paragraphs() as $paragraph): ?>
                    <p><?= Html::encode($paragraph) ?></p>
                <?php endforeach; ?>
            </div>
        </article>

        <?php require __DIR__ . '/RightBlock.php'; ?>
    </div>

