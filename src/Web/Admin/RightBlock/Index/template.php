<?php

declare(strict_types=1);

use App\RightBlocks\RightBlock;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var Csrf $csrf
 * @var RightBlock[] $items
 */

$this->setTitle('Правый блок');
?>

<div class="admin-panel">
    <div class="admin-title-row">
        <h1>Правый блок</h1>
        <a class="admin-btn" href="<?= Html::encode($urlGenerator->generate('admin/right-block/create')) ?>">Добавить блок</a>
    </div>

    <?php if ($items === []): ?>
        <p class="admin-empty">Записей пока нет. Пока список пуст, промо-блок в правой колонке не отображается.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
            <tr>
                <th>Заголовок</th>
                <th>Логотип</th>
                <th>Фон</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= Html::encode($item->title) ?></td>
                    <td><img src="<?= Html::encode($item->logo) ?>" alt="" width="60"></td>
                    <td><?php if ($item->backgroundImage !== null): ?><img src="<?= Html::encode($item->backgroundImage) ?>" alt="" width="100"><?php endif; ?></td>
                    <td>
                        <div class="admin-table__actions">
                            <a class="admin-btn admin-btn--ghost" href="<?= Html::encode($urlGenerator->generate('admin/right-block/edit', ['id' => (string) $item->id])) ?>">Изменить</a>
                            <form method="post" action="<?= Html::encode($urlGenerator->generate('admin/right-block/delete', ['id' => (string) $item->id])) ?>" onsubmit="return confirm('Удалить запись «<?= Html::encode(addslashes($item->title)) ?>»?');">
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
