<?php

declare(strict_types=1);

use App\Admin\Content\ContentItem;
use App\Admin\Content\ContentType;
use App\Shared\RussianDate;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var Csrf $csrf
 * @var ContentType $type
 * @var ContentItem[] $items
 */

$this->setTitle($type->label());
?>

<div class="admin-panel">
    <div class="admin-title-row">
        <h1><?= Html::encode($type->label()) ?></h1>
        <a class="admin-btn" href="<?= Html::encode($urlGenerator->generate('admin/content/create', ['type' => $type->value])) ?>">Добавить материал</a>
    </div>

    <?php if ($items === []): ?>
        <p class="admin-empty">Материалов пока нет.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
            <tr>
                <th>Заголовок</th>
                <th>Дата публикации</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= Html::encode($item->title) ?></td>
                    <td><?= Html::encode(RussianDate::dateTime($item->publishedAt)) ?></td>
                    <td>
                        <div class="admin-table__actions">
                            <a class="admin-btn admin-btn--ghost" href="<?= Html::encode($urlGenerator->generate('admin/content/edit', ['type' => $type->value, 'id' => (string) $item->id])) ?>">Изменить</a>
                            <form method="post" action="<?= Html::encode($urlGenerator->generate('admin/content/delete', ['type' => $type->value, 'id' => (string) $item->id])) ?>" onsubmit="return confirm('Удалить материал «<?= Html::encode(addslashes($item->title)) ?>»?');">
                                <?= $csrf->hiddenInput() ?>
                                <button type="submit" class="admin-btn admin-btn--danger">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
