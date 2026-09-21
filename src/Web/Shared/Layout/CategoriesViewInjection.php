<?php

declare(strict_types=1);

namespace App\Web\Shared\Layout;

use App\Categories\CategoryRepository;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;

/**
 * Makes the full category list available to every view and layout, used to render the top navigation.
 */
final readonly class CategoriesViewInjection implements CommonParametersInjectionInterface
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {}

    public function getCommonParameters(): array
    {
        return [
            'categories' => $this->categoryRepository->findAll(),
        ];
    }
}
