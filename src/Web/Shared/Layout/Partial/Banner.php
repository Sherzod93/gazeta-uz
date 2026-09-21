<?php

declare(strict_types=1);

use App\Banners\Banner;
use Yiisoft\Html\Html;

/**
 * Shared top banner, rendered the same way on every page. The banner shown is picked at random
 * (from the admin-managed list) on every page load by {@see \App\Web\Shared\Layout\RandomBlocksViewInjection}.
 *
 * @var Banner|null $banner
 */

if ($banner === null) {
    return;
}
?>
<section class="site-banner">
    <img class="site-banner__logo" src="<?= Html::encode($banner->logo) ?>" alt="<?= Html::encode($banner->title) ?>">
    <p class="site-banner__title"><?= Html::encode($banner->title) ?></p>
    <?php if ($banner->subtitle !== null): ?>
        <p class="site-banner__subtitle"><?= Html::encode($banner->subtitle) ?></p>
    <?php endif; ?>
    <?php if ($banner->ctaText !== null): ?>
        <a class="site-banner__cta" href="<?= Html::encode($banner->ctaHref ?? '#') ?>"><?= Html::encode($banner->ctaText) ?></a>
    <?php endif; ?>
</section>
