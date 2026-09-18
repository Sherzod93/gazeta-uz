<?php

declare(strict_types=1);

use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/**
 * Shared right-side block, rendered the same way on every page.
 *
 * @var UrlGeneratorInterface $urlGenerator
 * @var AsideItem[] $asideItems
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

    <a class="site-aside__promo" href="#">
        <span class="site-aside__promo-logo">gazeta</span>
        <span class="site-aside__promo-title">Книжная полка</span>
        <span class="site-aside__promo-subtitle">писателя, автора романа «Катехон» Евгения Абдуллаева</span>
        <span class="site-aside__promo-cta">читать</span>
    </a>

    <div class="site-aside__links">
        <a href="#">Реклама</a>
        <a href="#">Медиакит</a>
        <a href="#">Контакты</a>
    </div>
</aside>
