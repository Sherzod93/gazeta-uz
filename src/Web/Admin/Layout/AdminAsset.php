<?php

declare(strict_types=1);

namespace App\Web\Admin\Layout;

use Yiisoft\Assets\AssetBundle;

final class AdminAsset extends AssetBundle
{
    public ?string $basePath = '@assets/admin';
    public ?string $baseUrl = '@assetsUrl/admin';
    public ?string $sourcePath = '@assetsSource/admin';

    public array $css = [
        'admin.css',
    ];
}
