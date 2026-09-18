<?php

declare(strict_types=1);

use App\Web\Shared\Article\ArticleView;
use App\Web\Shared\Article\AsideItem;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\WebView;

/**
 * @var WebView $this
 * @var UrlGeneratorInterface $urlGenerator
 * @var ArticleView $article
 * @var AsideItem[] $asideItems
 */

$this->setTitle($article->title);

$activeTab = 'articles';
require __DIR__ . '/../../Shared/Layout/Partial/ArticleDetail.php';
