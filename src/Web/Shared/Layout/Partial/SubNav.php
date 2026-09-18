<?php

declare(strict_types=1);

use App\Shared\RussianDate;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;

/**
 * @var UrlGeneratorInterface $urlGenerator
 * @var string $activeTab One of 'home', 'news', 'articles', 'reporting', 'media'.
 */
?>
<nav class="sub-nav">
    <div class="sub-nav__links">
        <a href="<?= Html::encode($urlGenerator->generate('home')) ?>" class="<?= $activeTab === 'home' ? 'is-active' : '' ?>">Главная</a>
        <a href="<?= Html::encode($urlGenerator->generate('news/index')) ?>" class="<?= $activeTab === 'news' ? 'is-active' : '' ?>">Новости</a>
        <a href="<?= Html::encode($urlGenerator->generate('articles/index')) ?>" class="<?= $activeTab === 'articles' ? 'is-active' : '' ?>">Статьи</a>
        <a href="<?= Html::encode($urlGenerator->generate('reporting/index')) ?>" class="<?= $activeTab === 'reporting' ? 'is-active' : '' ?>">Репортажи</a>
        <a href="#" class="<?= $activeTab === 'media' ? 'is-active' : '' ?>">Медиа</a>
    </div>
    <div class="sub-nav__date"><?= Html::encode(RussianDate::today()) ?></div>
    <div class="sub-nav__links sub-nav__links--muted">
        <a href="#">Afisha</a>
        <a href="#">Spot</a>
        <a href="#">Zira</a>
        <a href="#">Погода</a>
        <a href="#">Вакансии</a>
    </div>
</nav>
