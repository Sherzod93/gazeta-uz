<?php

declare(strict_types=1);

use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Renderer\Csrf;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var Csrf $csrf
 * @var string|null $error
 * @var string $username
 */

$this->setTitle('Вход');
?>

<div class="admin-login">
    <div class="admin-login__card">
        <h1 class="admin-login__title">gazeta.uz admin</h1>

        <?php if ($error !== null): ?>
            <div class="admin-alert admin-alert--error"><?= Html::encode($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= Html::encode($urlGenerator->generate('admin/login')) ?>">
            <?= $csrf->hiddenInput() ?>

            <div class="admin-form-row">
                <label for="username">Логин</label>
                <input type="text" id="username" name="username" value="<?= Html::encode($username) ?>" autofocus required>
            </div>

            <div class="admin-form-row">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="admin-btn">Войти</button>
        </form>
    </div>
</div>
