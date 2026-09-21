<?php

declare(strict_types=1);

use App\Banners\BannerInput;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var UrlGeneratorInterface $urlGenerator
 * @var Csrf $csrf
 * @var BannerInput $input
 * @var array<string, string> $errors
 * @var int|null $itemId
 */

$formAction = $itemId === null
    ? $urlGenerator->generate('admin/banner/create')
    : $urlGenerator->generate('admin/banner/edit', ['id' => (string) $itemId]);
?>

<form method="post" action="<?= Html::encode($formAction) ?>" enctype="multipart/form-data">
    <?= $csrf->hiddenInput() ?>

    <div class="admin-form-row">
        <label for="logo">Логотип</label>
        <?php if ($input->logo !== ''): ?>
            <div class="admin-form-current-image">
                <img src="<?= Html::encode($input->logo) ?>" alt="" width="120">
                <span>Текущий логотип. Загрузите новый файл, чтобы заменить его.</span>
            </div>
        <?php endif; ?>
        <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp,image/gif">
        <?php if (isset($errors['logo'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['logo']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="title">Заголовок</label>
        <input type="text" id="title" name="title" value="<?= Html::encode($input->title) ?>" required>
        <?php if (isset($errors['title'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['title']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="subtitle">Подзаголовок</label>
        <input type="text" id="subtitle" name="subtitle" value="<?= Html::encode($input->subtitle ?? '') ?>">
    </div>

    <div class="admin-form-row">
        <label for="cta_text">Текст кнопки</label>
        <input type="text" id="cta_text" name="cta_text" value="<?= Html::encode($input->ctaText ?? '') ?>">
    </div>

    <div class="admin-form-row">
        <label for="cta_href">Ссылка кнопки</label>
        <input type="text" id="cta_href" name="cta_href" value="<?= Html::encode($input->ctaHref ?? '') ?>">
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="admin-btn">Сохранить</button>
        <a class="admin-btn admin-btn--ghost" href="<?= Html::encode($urlGenerator->generate('admin/banner/index')) ?>">Отмена</a>
    </div>
</form>
