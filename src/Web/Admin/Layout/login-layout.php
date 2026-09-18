<?php

declare(strict_types=1);

use App\Web\Admin\Layout\AdminAsset;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Html\Html;

/**
 * @var AssetManager $assetManager
 * @var string $content
 * @var Yiisoft\View\WebView $this
 */

$assetManager->register(AdminAsset::class);

$this->addCssFiles($assetManager->getCssFiles());
$this->addCssStrings($assetManager->getCssStrings());

$this->beginPage()
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->getTitle() ?: 'Вход в админ-панель') ?> — gazeta.uz</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="admin-container" style="padding: 0;">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
