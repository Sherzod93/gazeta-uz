<?php

declare(strict_types=1);

use App\Admin\Content\ContentType;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var ContentType[] $contentTypes
 */

$this->setTitle('Панель управления');
?>

<div class="admin-panel">
    <div class="admin-title-row">
        <h1>Управление контентом</h1>
    </div>

    <p>Выберите раздел, чтобы просмотреть, добавить, отредактировать или удалить материалы.</p>

    <div class="admin-table__actions" style="justify-content: flex-start; flex-wrap: wrap;">
        <?php foreach ($contentTypes as $type): ?>
            <a class="admin-btn" href="<?= Html::encode($urlGenerator->generate('admin/content/index', ['type' => $type->value])) ?>">
                <?= Html::encode($type->label()) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
