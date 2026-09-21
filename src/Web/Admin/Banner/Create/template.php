<?php

declare(strict_types=1);

use App\Banners\BannerInput;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var BannerInput $input
 * @var array<string, string> $errors
 * @var int|null $itemId
 */

$this->setTitle('Новый баннер');
?>

<div class="admin-panel">
    <div class="admin-title-row">
        <h1>Новый баннер</h1>
    </div>

    <?php require __DIR__ . '/../_form.php'; ?>
</div>
