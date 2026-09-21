<?php

declare(strict_types=1);

use App\Web;
use Yiisoft\Http\Method;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;

return [
    Group::create()
        ->routes(
            Route::get('/')
                ->action(Web\HomePage\Action::class)
                ->name('home'),
            Route::get('/news')
                ->action(Web\News\Index\Action::class)
                ->name('news/index'),
            Route::get('/news/{slug}')
                ->action(Web\News\View\Action::class)
                ->name('news/view'),
            Route::get('/reporting')
                ->action(Web\Reportings\Index\Action::class)
                ->name('reporting/index'),
            Route::get('/reporting/{slug}')
                ->action(Web\Reportings\View\Action::class)
                ->name('reporting/view'),
            Route::get('/articles')
                ->action(Web\Articles\Index\Action::class)
                ->name('articles/index'),
            Route::get('/articles/{slug}')
                ->action(Web\Articles\View\Action::class)
                ->name('articles/view'),
            Route::get('/category/{slug}')
                ->action(Web\Category\Index\Action::class)
                ->name('category/index'),
        ),

    Group::create('/admin')
        ->routes(
            Route::methods([Method::GET, Method::POST], '/login')
                ->action(Web\Admin\Login\Action::class)
                ->name('admin/login'),
            Route::post('/logout')
                ->action(Web\Admin\Logout\Action::class)
                ->name('admin/logout'),
        ),

    Group::create('/admin')
        ->middleware(Web\Admin\AuthMiddleware::class)
        ->routes(
            Route::get('')
                ->action(Web\Admin\Dashboard\Action::class)
                ->name('admin/index'),
            Route::get('/banners')
                ->action(Web\Admin\Banner\Index\Action::class)
                ->name('admin/banner/index'),
            Route::methods([Method::GET, Method::POST], '/banners/create')
                ->action(Web\Admin\Banner\Create\Action::class)
                ->name('admin/banner/create'),
            Route::methods([Method::GET, Method::POST], '/banners/{id}/edit')
                ->action(Web\Admin\Banner\Edit\Action::class)
                ->name('admin/banner/edit'),
            Route::post('/banners/{id}/delete')
                ->action(Web\Admin\Banner\Delete\Action::class)
                ->name('admin/banner/delete'),

            Route::get('/right-blocks')
                ->action(Web\Admin\RightBlock\Index\Action::class)
                ->name('admin/right-block/index'),
            Route::methods([Method::GET, Method::POST], '/right-blocks/create')
                ->action(Web\Admin\RightBlock\Create\Action::class)
                ->name('admin/right-block/create'),
            Route::methods([Method::GET, Method::POST], '/right-blocks/{id}/edit')
                ->action(Web\Admin\RightBlock\Edit\Action::class)
                ->name('admin/right-block/edit'),
            Route::post('/right-blocks/{id}/delete')
                ->action(Web\Admin\RightBlock\Delete\Action::class)
                ->name('admin/right-block/delete'),

            Route::get('/{type}')
                ->action(Web\Admin\Content\Index\Action::class)
                ->name('admin/content/index'),
            Route::methods([Method::GET, Method::POST], '/{type}/create')
                ->action(Web\Admin\Content\Create\Action::class)
                ->name('admin/content/create'),
            Route::methods([Method::GET, Method::POST], '/{type}/{id}/edit')
                ->action(Web\Admin\Content\Edit\Action::class)
                ->name('admin/content/edit'),
            Route::post('/{type}/{id}/delete')
                ->action(Web\Admin\Content\Delete\Action::class)
                ->name('admin/content/delete'),
        ),
];
