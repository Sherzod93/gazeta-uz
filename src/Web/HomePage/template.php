<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use App\Shared\RussianDate;
use App\Web\HomePage\HomePageItem;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var ApplicationParams $applicationParams
 * @var UrlGeneratorInterface $urlGenerator
 * @var HomePageItem[] $mainItems
 * @var AsideItem[] $asideItems
 */

$this->setTitle($applicationParams->name);

$bannerLogo = 'Afisha';
$bannerTitle = 'Лучшие события Ташкента';
$bannerSubtitle = 'Обзор и билеты';
require __DIR__ . '/../Shared/Layout/Partial/Banner.php';

$activeTab = 'home';
require __DIR__ . '/../Shared/Layout/Partial/SubNav.php';
?>

<div class="home-grid">
    <?php foreach ($mainItems as $item): ?>
        <article class="story-card">
            <a
                class="story-card__media"
                href="<?= Html::encode($urlGenerator->generate($item->routeName, ['slug' => $item->slug])) ?>"
                <?= $item->image !== null ? 'style="background-image:url(\'' . Html::encode($item->image) . '\')"' : '' ?>
            >
                <span class="story-card__watermark">gazeta</span>
            </a>
            <div class="story-card__body">
                <p class="story-card__meta"><?= Html::encode(RussianDate::relative($item->publishedAt)) ?></p>
                <h2 class="story-card__title">
                    <a href="<?= Html::encode($urlGenerator->generate($item->routeName, ['slug' => $item->slug])) ?>">
                        <?= Html::encode($item->title) ?>
                    </a>
                </h2>
                <p class="story-card__excerpt"><?= Html::encode($item->summary) ?></p>
            </div>
        </article>
    <?php endforeach; ?>

    <?php require __DIR__ . '/../Shared/Layout/Partial/RightBlock.php'; ?>
</div>
