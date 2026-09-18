<?php

declare(strict_types=1);

use App\Web\Admin\Layout\AdminAsset;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Html\Html;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var Yiisoft\Aliases\Aliases $aliases
 * @var AssetManager $assetManager
 * @var string $content
 * @var Csrf $csrf
 * @var Yiisoft\View\WebView $this
 * @var CurrentRoute $currentRoute
 * @var UrlGeneratorInterface $urlGenerator
 */

$assetManager->register(AdminAsset::class);

$this->addCssFiles($assetManager->getCssFiles());
$this->addCssStrings($assetManager->getCssStrings());

$activeRoute = $currentRoute->getName();

$this->beginPage()
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->getTitle() ?: 'Админ-панель') ?> — gazeta.uz</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="admin-header">
    <div class="admin-header__inner">
        <a class="admin-header__logo" href="<?= Html::encode($urlGenerator->generate('admin/index')) ?>">gazeta.uz admin</a>

        <nav class="admin-nav">
            <a href="<?= Html::encode($urlGenerator->generate('admin/content/index', ['type' => 'news'])) ?>"
               class="<?= $activeRoute === 'admin/content/index' && $currentRoute->getArgument('type') === 'news' ? 'is-active' : '' ?>">Новости</a>
            <a href="<?= Html::encode($urlGenerator->generate('admin/content/index', ['type' => 'reportings'])) ?>"
               class="<?= $activeRoute === 'admin/content/index' && $currentRoute->getArgument('type') === 'reportings' ? 'is-active' : '' ?>">Репортажи</a>
            <a href="<?= Html::encode($urlGenerator->generate('admin/content/index', ['type' => 'articles'])) ?>"
               class="<?= $activeRoute === 'admin/content/index' && $currentRoute->getArgument('type') === 'articles' ? 'is-active' : '' ?>">Статьи</a>
        </nav>

        <form method="post" action="<?= Html::encode($urlGenerator->generate('admin/logout')) ?>">
            <?= $csrf->hiddenInput() ?>
            <button type="submit" class="admin-logout">Выйти</button>
        </form>
    </div>
</header>

<div class="admin-container">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
