<?php

declare(strict_types=1);

use App\Shared\ApplicationParams;
use App\Web\Shared\Layout\CategoriesViewInjection;
use App\Web\Shared\Layout\RandomBlocksViewInjection;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Definitions\Reference;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\CsrfViewInjection;

return [
    'application' => require __DIR__ . '/application.php',
    'db' => require __DIR__ . '/db.php',
    'admin' => require __DIR__ . '/admin.php',

    'yiisoft/aliases' => [
        'aliases' => require __DIR__ . '/aliases.php',
    ],

    'yiisoft/view' => [
        'basePath' => null,
        'parameters' => [
            'assetManager' => Reference::to(AssetManager::class),
            'applicationParams' => Reference::to(ApplicationParams::class),
            'aliases' => Reference::to(Aliases::class),
            'urlGenerator' => Reference::to(UrlGeneratorInterface::class),
            'currentRoute' => Reference::to(CurrentRoute::class),
        ],
    ],

    'yiisoft/yii-view-renderer' => [
        'viewPath' => null,
        'layout' => '@src/Web/Shared/Layout/Main/layout.php',
        'injections' => [
            Reference::to(CsrfViewInjection::class),
            Reference::to(RandomBlocksViewInjection::class),
            Reference::to(CategoriesViewInjection::class),
        ],
    ],

    'yiisoft/db-migration' => [
        'newMigrationNamespace' => 'App\\Migration',
        'newMigrationPath' => '',
        'sourceNamespaces' => ['App\\Migration'],
        'sourcePaths' => [],
    ],
];
