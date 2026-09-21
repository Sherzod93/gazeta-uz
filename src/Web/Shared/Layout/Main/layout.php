<?php

declare(strict_types=1);

use App\Categories\Category;
use App\Web\Shared\Layout\Main\MainAsset;
use Yiisoft\Html\Html;

/**
 * @var \App\Shared\ApplicationParams $applicationParams
 * @var Yiisoft\Aliases\Aliases $aliases
 * @var Yiisoft\Assets\AssetManager $assetManager
 * @var string $content
 * @var string|null $csrf
 * @var Yiisoft\View\WebView $this
 * @var Yiisoft\Router\CurrentRoute $currentRoute
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var Category[] $categories
 */

$assetManager->register(MainAsset::class);

$this->addCssFiles($assetManager->getCssFiles());
$this->addCssStrings($assetManager->getCssStrings());
$this->addJsFiles($assetManager->getJsFiles());
$this->addJsStrings($assetManager->getJsStrings());
$this->addJsVars($assetManager->getJsVars());

$this->beginPage()
?>
<!DOCTYPE html>
<html lang="<?= Html::encode($applicationParams->locale) ?>">
<head>
    <meta charset="<?= Html::encode($applicationParams->charset) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= $aliases->get('@baseUrl/favicon.svg') ?>" type="image/svg+xml">
    <title><?= Html::encode($this->getTitle()) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="site-header">
    <div class="site-header__inner">
        <a class="site-logo" href="<?= Html::encode($urlGenerator->generate('home')) ?>">
            <span class="site-logo__flag" aria-hidden="true">
                <span class="site-logo__flag-bar site-logo__flag-bar--blue"></span>
                <span class="site-logo__flag-bar site-logo__flag-bar--white"></span>
                <span class="site-logo__flag-bar site-logo__flag-bar--green"></span>
            </span>
            gazeta
        </a>

        <nav class="site-nav" aria-label="Categories">
            <?php foreach ($categories as $category): ?>
                <a
                    href="<?= Html::encode($urlGenerator->generate('category/index', ['slug' => $category->slug])) ?>"
                    class="<?= $currentRoute->getName() === 'category/index' && $currentRoute->getArgument('slug') === $category->slug ? 'is-active' : '' ?>"
                ><?= Html::encode($category->name) ?></a>
            <?php endforeach; ?>
        </nav>

        <div class="site-header__tools">
            <button class="icon-btn" type="button" aria-label="Поиск">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18">
                    <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          d="M10.5 18a7.5 7.5 0 1 0 0-15 7.5 7.5 0 0 0 0 15Zm10.5 3-5.2-5.2"/>
                </svg>
            </button>

            <div class="lang-switch">
                <a href="#">O'Z</a>
                <a href="#">ЎЗ</a>
                <a href="#" class="is-active">РУ</a>
                <a href="#">EN</a>
            </div>

            <button class="icon-btn icon-btn--toggle" type="button" aria-label="Переключить тему">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                    <circle cx="12" cy="12" r="5" fill="currentColor"/>
                    <g stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M12 1v3M12 20v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M1 12h3M20 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1"/>
                    </g>
                </svg>
            </button>
        </div>
    </div>
</header>

<main class="site-main">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<footer class="site-footer">
    <div class="container site-footer__inner">
        © <?= date('Y') ?> <?= Html::encode($applicationParams->name) ?>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
