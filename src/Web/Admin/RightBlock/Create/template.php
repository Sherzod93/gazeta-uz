<?php

declare(strict_types=1);

use App\RightBlocks\RightBlockInput;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var RightBlockInput $input
 * @var array<string, string> $errors
 * @var int|null $itemId
 */

$this->setTitle('Новая запись — Правый блок');
?>

<div class="admin-panel">
    <div class="admin-title-row">
        <h1>Новая запись — Правый блок</h1>
    </div>

    <?php require __DIR__ . '/../_form.php'; ?>
</div>
