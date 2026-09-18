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
