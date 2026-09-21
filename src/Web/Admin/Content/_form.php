<?php

declare(strict_types=1);

use App\Admin\Content\ContentInput;
use App\Admin\Content\ContentType;
use App\Categories\Category;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var UrlGeneratorInterface $urlGenerator
 * @var Csrf $csrf
 * @var ContentType $type
 * @var ContentInput $input
 * @var array<string, string> $errors
 * @var int|null $itemId
 * @var Category[] $categories
 */

$formAction = $itemId === null
    ? $urlGenerator->generate('admin/content/create', ['type' => $type->value])
    : $urlGenerator->generate('admin/content/edit', ['type' => $type->value, 'id' => (string) $itemId]);
?>

<form method="post" action="<?= Html::encode($formAction) ?>" enctype="multipart/form-data">
    <?= $csrf->hiddenInput() ?>

    <div class="admin-form-row">
        <label for="title">Заголовок</label>
        <input type="text" id="title" name="title" value="<?= Html::encode($input->title) ?>" required>
        <?php if (isset($errors['title'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['title']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="slug">URL (slug)</label>
        <input type="text" id="slug" name="slug" value="<?= Html::encode($input->slug) ?>" placeholder="my-article-title" required>
        <?php if (isset($errors['slug'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['slug']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="summary">Краткое описание</label>
        <textarea id="summary" name="summary" rows="3" required><?= Html::encode($input->summary) ?></textarea>
        <?php if (isset($errors['summary'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['summary']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="content">Текст материала</label>
        <textarea id="content" name="content" rows="14" required><?= Html::encode($input->content) ?></textarea>
        <?php if (isset($errors['content'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['content']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="image">Изображение</label>
        <?php if ($input->image !== null): ?>
            <div class="admin-form-current-image">
                <img src="<?= Html::encode($input->image) ?>" alt="" width="120">
                <span>Текущее изображение. Загрузите новый файл, чтобы заменить его.</span>
            </div>
        <?php endif; ?>
        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
        <?php if (isset($errors['image'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['image']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="category_id">Категория</label>
        <select id="category_id" name="category_id" required>
            <option value="">Выберите категорию</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= $input->categoryId === $category->id ? 'selected' : '' ?>>
                    <?= Html::encode($category->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['categoryId'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['categoryId']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-row">
        <label for="published_at">Дата публикации</label>
        <input type="datetime-local" id="published_at" name="published_at" value="<?= Html::encode($input->publishedAt) ?>" required>
        <?php if (isset($errors['publishedAt'])): ?>
            <div class="admin-form-error"><?= Html::encode($errors['publishedAt']) ?></div>
        <?php endif; ?>
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="admin-btn">Сохранить</button>
        <a class="admin-btn admin-btn--ghost" href="<?= Html::encode($urlGenerator->generate('admin/content/index', ['type' => $type->value])) ?>">Отмена</a>
    </div>
</form>
