<?php

declare(strict_types=1);

use App\RightBlocks\RightBlock;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/**
 * Shared right-side block, rendered the same way on every page. The promo box shown is picked at random
 * (from the admin-managed list) on every page load by {@see \App\Web\Shared\Layout\RandomBlocksViewInjection}.
 *
 * @var UrlGeneratorInterface $urlGenerator
 * @var AsideItem[] $asideItems
 * @var RightBlock|null $rightBlock
 */
?>
<aside class="site-aside">
    <?php if ($asideItems !== []): ?>
        <div class="site-aside__latest">
            <ul class="site-aside__latest-list">
                <?php foreach ($asideItems as $item): ?>
                    <li class="site-aside__latest-item">
                        <span class="site-aside__latest-time"><?= Html::encode($item->publishedAt->format('d.m')) ?></span>
                        <a href="<?= Html::encode($urlGenerator->generate($item->routeName, ['slug' => $item->slug])) ?>">
                            <?= Html::encode($item->title) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($rightBlock !== null): ?>
        <a
            class="site-aside__promo"
            href="<?= Html::encode($rightBlock->ctaHref ?? '#') ?>"
            <?= $rightBlock->backgroundImage !== null ? 'style="background-image:url(\'' . Html::encode($rightBlock->backgroundImage) . '\')"' : '' ?>
        >
            <img class="site-aside__promo-logo" src="<?= Html::encode($rightBlock->logo) ?>" alt="<?= Html::encode($rightBlock->title) ?>">
            <span class="site-aside__promo-title"><?= Html::encode($rightBlock->title) ?></span>
            <?php if ($rightBlock->subtitle !== null): ?>
                <span class="site-aside__promo-subtitle"><?= Html::encode($rightBlock->subtitle) ?></span>
            <?php endif; ?>
            <?php if ($rightBlock->ctaText !== null): ?>
                <span class="site-aside__promo-cta"><?= Html::encode($rightBlock->ctaText) ?></span>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <div class="site-aside__links">
        <a href="#">Реклама</a>
        <a href="#">Медиакит</a>
        <a href="#">Контакты</a>
    </div>
</aside>
