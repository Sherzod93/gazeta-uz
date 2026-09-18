<?php

declare(strict_types=1);

use Yiisoft\Html\Html;

/**
 * Shared top banner, rendered the same way on every page.
 *
 * @var string $bannerLogo
 * @var string $bannerTitle
 * @var string|null $bannerSubtitle
 * @var string|null $bannerCtaText
 * @var string|null $bannerCtaHref
 */

$bannerSubtitle ??= null;
$bannerCtaText ??= null;
$bannerCtaHref ??= null;
?>
<section class="site-banner">
    <span class="site-banner__logo"><?= Html::encode($bannerLogo) ?></span>
    <p class="site-banner__title"><?= Html::encode($bannerTitle) ?></p>
    <?php if ($bannerSubtitle !== null): ?>
        <p class="site-banner__subtitle"><?= Html::encode($bannerSubtitle) ?></p>
    <?php endif; ?>
    <?php if ($bannerCtaText !== null): ?>
        <a class="site-banner__cta" href="<?= Html::encode($bannerCtaHref ?? '#') ?>"><?= Html::encode($bannerCtaText) ?></a>
    <?php endif; ?>
</section>
