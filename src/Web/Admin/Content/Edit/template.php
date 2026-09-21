<?php

declare(strict_types=1);

use App\Admin\Content\ContentInput;
use App\Admin\Content\ContentType;
use App\Categories\Category;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var Csrf $csrf
 * @var ContentType $type
 * @var ContentInput $input
 * @var array<string, string> $errors
 * @var int|null $itemId
 * @var Category[] $categories
 */

$this->setTitle('Редактирование — ' . $type->label());
?>

<div class="admin-panel">
    <div class="admin-title-row">
        <h1>Редактирование — <?= Html::encode($type->label()) ?></h1>
    </div>

    <?php require __DIR__ . '/../_form.php'; ?>
</div>
